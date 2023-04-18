<?php

namespace App\Http\Controllers\Employer;

use App\Filters\employer\JobPostFilters;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Post;
use App\Services\CommonService;
use App\Services\HelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Traversable;

class PostController extends Controller
{
    public function initiateList()
    {
        $summary = Post::select(DB::raw("COUNT(CASE WHEN (status = 1 || status = 2) THEN 1 END) AS posted"),
            DB::raw("COUNT(CASE WHEN status = 0 THEN 1 END) AS drafted"),
            DB::raw("COUNT(CASE WHEN status = 3 THEN 1 END) AS archived"))
            ->whereCompanyId(COMPANY_ID)
            ->first();

        return $this->response([
            'summary' => $summary
        ], 'Initiate job post list');
    }

    public function index(JobPostFilters $filters)
    {
        $data = Post::withCount('applicants')
            ->withCount('shortListed', 'viewedApplicants', 'notViewedApplicants')
            // ->with('postMandatoryMatchingCriteria')
            ->whereCompanyId(COMPANY_ID)
            ->filter($filters)
            ->orderBy('created_at', 'DESC')
            ->paginate();

        $matchedEmployeesCount = 0;
//        if (count($data->postMandatoryMatchingCriteria) > 0) {
//            $matchedQuery = User::whereUserType(StaticValueService::userTypeIdByKey('employee'))->whereStatus(1);
//
//            foreach ($data->postMandatoryMatchingCriteria as $criteria) {
//                $criteriaKey = StaticValueService::userCriteriaKeyById($criteria->matching_criteria_id);
//
//                if ($criteriaKey == 'age') {
//                    $ageRange = [$data->age_min, $data->age_max];
//
//                }
//
//            }
//
//            $matchedEmployeesCount = $matchedQuery->count();
//        }


        return $this->response($data, 'Job list');
    }

    public function show($id)
    {

    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'step' => 'required|string|in:primary_job_info,more_job_info,candidate_requirements,company_info,matching_criteria,preview,complete'
        ]);

        $post = null;
        if ($request->id) {
            $post = Post::with('category')
                ->with('postNatures', 'postAreas.parent')
                ->with('postLevels', 'postWorkspaces')
                ->with('postDegrees', 'postInstitutes', 'postTrainings', 'postCertificates', 'postAreaExperiences', 'postGenders', 'postSkills')
                ->with('postCompanyIndustryTypes', 'postIndustryTypes')
                ->with('postMatchingCriteria')
                ->with('company')
                ->whereCompanyId(COMPANY_ID)
                ->findOrFail($request->id);

            if ($request->step == 'preview') {
                $post->responsibilities = HelperService::nl2li($post->responsibilities);
                $post->job_context = HelperService::nl2li($post->job_context);
                $post->additional_requirements = HelperService::nl2li($post->additional_requirements);
            }

            $post->postAreas->map(function ($item) {
                if ($item->parent) {
                    $item['title'] = $item->parent->title_en . ' -> ' . $item->title_en;
                } else {
                    $item['title'] = $item->title_en;
                }
                return $item;
            });

            $countryId = @$post->postAreas->first()->country_id;
            if (empty($countryId) || $countryId == 1) {
                $post['job_location'] = 'inside_bd';
            } else {
                $post['job_location'] = 'outside_bd';
            }

            if (count($post->postAreas) == 0) {
                $post->unsetRelation('postAreas');
                $post['post_areas'] = [['id' => '', 'title' => 'Anywhere in Bangladesh', 'country_id' => 1]];
            }
        }

        $data = $this->initiate($request->step);
        $data['post'] = $post;

        return $this->response($data, 'New post create initiate');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'step' => 'required|string|in:primary_job_info,more_job_info,candidate_requirements,company_info,matching_criteria,preview,complete',
            'id' => 'required_unless:step,primary_job_info'
        ]);
        $this->validateRequest($request, $request->step);

        $data = null;

        try {
            DB::beginTransaction();

            if ($request->step == 'primary_job_info') {
                $data = $this->storePrimaryInfo($request);

            } elseif ($request->step == 'more_job_info') {
                $data = $this->storeMoreJobInfo($request, $request->id);

            } elseif ($request->step == 'candidate_requirements') {
                $data = $this->storeCandidateRequirement($request, $request->id);

            } elseif ($request->step == 'company_info') {
                $data = $this->storeCompanyInfo($request, $request->id);

            } elseif ($request->step == 'matching_criteria') {
                $data = $this->storeMatchingCriteria($request, $request->id);
            }

            DB::commit();
            return $this->response($data, 'Information saved  successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }

    public function readyToProcess($id)
    {
        $company = Company::findOrFail(COMPANY_ID);
        if ($company->status['id'] != 1) {
            return $this->errorResponse('Please activate the company before publishing any job post');
        }

        $post = $this->getPostById($id);

        try {
            $post->status = 1;
            $post->save();

            return $this->successResponse('Post is under approval');

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function repost($id)
    {
        $post = Post::with('category')
            ->with('postNatures', 'postAreas.parent')
            ->with('postLevels', 'postWorkspaces')
            ->with('postDegrees', 'postInstitutes', 'postTrainings', 'postCertificates', 'postAreaExperiences', 'postGenders', 'postSkills')
            ->with('postIndustryTypes')
            ->with('postMatchingCriteria')
            ->whereCompanyId(COMPANY_ID)
            ->findOrFail($id);

        try {
            DB::beginTransaction();

            $newPost = $post->replicate();
            $newPost->push();

            $newPost->status = 0;
            $newPost->save();

            foreach ($newPost->getRelations() as $relation => $items) {
                if ($items instanceof Traversable) {
                    foreach ($items as $item) {
                        if (@$item->pivot) {
                            $extra_attributes = Arr::except($item->pivot->getAttributes(), $item->pivot->getForeignKey());
                            $newPost->{$relation}()->attach($item, $extra_attributes);
                        } else {
                            $newPost->{$relation}()->create($item->toArray());
                        }
                    }
                }
            }

            DB::commit();
            return $this->successResponse('Job create successfully', $newPost);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }

    public function updateDeadline(Request $request, $id)
    {
        $this->validate($request, [
            'deadline' => 'required|date|after:today'
        ]);

        $post = $this->getPostById($id);

        try {
            $post->deadline = $request->deadline;
            $post->save();

            return $this->successResponse('Deadline updated successfully');

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    private function storePrimaryInfo($request)
    {
        if ($request->has('id') && $request->id) {
            $post = $this->getPostById($request->id);

            $post->fill($request->only('title', 'no_of_vacancy', 'category_id', 'deadline', 'special_instruction', 'is_profile_image'));
            $post['package_id'] = $request->service_type_id;
            $post->resume_receiving_option = json_encode([
                'is_apply_online' => $request->is_apply_online ?? false,
                'resume_receiving_option' => $request->resume_receiving_option,
                'resume_receiving_details' => $request->resume_receiving_details,
            ]);
            $post->save();

            $post->postNatures()->sync($request->post_nature_ids);

            return $post;
        }

        $data = $request->only('title', 'no_of_vacancy', 'category_id', 'deadline', 'special_instruction', 'is_profile_image', 'language');
        $data['resume_receiving_option'] = json_encode($request->resume_receive_options);
        $data['company_id'] = COMPANY_ID;
        $data['package_id'] = $request->service_type_id;
        $data['resume_receiving_option'] = json_encode([
            'is_apply_online' => $request->is_apply_online ?? false,
            'resume_receiving_option' => $request->resume_receiving_option,
            'resume_receiving_details' => $request->resume_receiving_details,
        ]);

        $post = Post::create($data);

        $post->postNatures()->attach($request->post_nature_ids);

        return $post;
    }

    private function storeMoreJobInfo($request, $id)
    {
        $post = $this->getPostById($id);

        $post->fill($request->only('job_context', 'responsibilities', 'is_negotiable', 'salary_min', 'salary_max', 'salary_type',
            'is_display_salary', 'additional_salary_info'));

        $post->other_benefit = json_encode($request->only('benefits', 'lunch_facility', 'salary_review', 'others', 'other_benefit_type', 'festival_bonus'));
        $post->save();

        $post->postLevels()->sync($request->job_level_ids);
        $post->postWorkspaces()->sync($request->workspace_ids);

        $post->postAreas()->detach();
        foreach ($request->job_location_areas as $area) {
            if ($area['id']) {
                $post->postAreas()->attach($area['id']);
            }
        }

        return $post;
    }


    private function storeCandidateRequirement($request, $id)
    {
        $post = $this->getPostById($id);

        $post->fill($request->only('other_qualification', 'is_experience_require', 'is_fresher_allowed', 'experience_min',
            'experience_max', 'additional_requirements', 'age_min', 'age_max', 'is_disability_allowed'));
        $post->save();

        $post->postAreaExperiences()->detach();
        foreach ($request->area_experiences as $exp) {
            $post->postAreaExperiences()->attach($exp['id'], ['type' => 1]);
        }

        $post->postSkills()->detach();
        foreach ($request->skills as $skill) {
            $post->postSkills()->attach($skill['id'], ['type' => 2]);
        }

        $post->postDegrees()->detach();
        foreach ($request->degrees as $degree) {
            $post->postDegrees()->attach($degree['degree_id'], ['major' => $degree['major']]);
        }

        $post->postGenders()->sync(collect($request->genders)->pluck('id')->toArray());
        $post->postInstitutes()->sync(collect($request->institutes)->pluck('id')->toArray());
        // $post->postInstituteTypes()->sync(collect($request->industry_types)->pluck('id')->toArray());

        $post->postTrainings()->delete();
        $post->postTrainings()->createMany(collect($request->trainings)->where('title', '!=', null));

        $post->postCertificates()->delete();
        $post->postCertificates()->createMany(collect($request->certificates)->where('title', '!=', null));

        return $post;
    }

    private function storeCompanyInfo($request, $id)
    {
        $post = $this->getPostById($id);

        $post->fill($request->only('is_visible_company_name', 'is_visible_address', 'is_visible_about', 'contact_id'));
        $post->save();

        $post->postIndustryTypes()->sync(collect($request->industry_types)->pluck('id')->toArray());

        return $post;
    }

    private function storeMatchingCriteria($request, $id)
    {
        $post = $this->getPostById($id);

        $post->postMatchingCriteria()->delete();

        $selectedMatchingCriteria = collect($request->matching_criteria)->where('is_selected', true);

        foreach ($selectedMatchingCriteria as $criterion) {
            $post->postMatchingCriteria()->create([
                'matching_criteria_id' => $criterion['matching_criteria_id'],
                'is_mandatory' => $criterion['is_mandatory'],
            ]);
        }

        return $post;
    }

    private function initiate($postType)
    {
        $data = [];

        if ($postType == 'primary_job_info') {
            $data['service_types'] = CommonService::serviceTypes()->where('id', 1)->values();
            $data['category_types'] = [
                ['id' => 0, 'tag_id' => 1, 'title_en' => 'Functional', 'title_bn' => 'কার্যকরী'],
                ['id' => 1, 'tag_id' => 2, 'title_en' => 'Industrial', 'title_bn' => 'ক্ষেত্রভিত্তিক'],
                ['id' => 2, 'tag_id' => null, 'title_en' => 'Special Skilled', 'title_bn' => 'স্পেশাল স্কিল্‌ড'],
            ];
            $data['categories'] = CommonService::jobCategories();
            $data['employment_status'] = CommonService::jobNatures();
            $data['resume_receive_options'] = CommonService::resumeReceiveOptions();

        } elseif ($postType == 'more_job_info') {
            $data['job_levels'] = CommonService::jobLevels();
            $data['workspaces'] = CommonService::workspaces();
            $data['salary_types'] = CommonService::salaryTypes();
            $data['benefits'] = CommonService::benefits();

            $data['job_locations'] = collect([['id' => '', 'title' => 'Anywhere in Bangladesh', 'country_id' => 1]])
                ->merge(CommonService::divisions()->merge(CommonService::districtsInside()))->values();

        } elseif ($postType == 'candidate_requirements') {
            $data['education_levels'] = CommonService::educationLevels();
            $data['degrees'] = CommonService::degrees();
            $data['institutes'] = CommonService::institutes();
            $data['skills'] = CommonService::skills();
            $data['genders'] = CommonService::genders();
            $data['industry_types'] = CommonService::industryTypes();

        } elseif ($postType == 'company_info') {
            $company = Company::findOrFail(COMPANY_ID);

            $data['industry_types'] = $company->industryTypes;
            $data['contact_persons'] = CommonService::companyContactPersons();

        } elseif ($postType == 'matching_criteria') {
            $data['matching_criteria'] = CommonService::postMatchingCriteria();
        }

        return $data;
    }

    private function validateRequest($request, $postType)
    {
        $rules = [];

        if ($postType == 'primary_job_info') {
            $rules = [
                'service_type_id' => 'required|integer',
                'title' => 'required|string',
                'no_of_vacancy' => 'nullable|integer',
                'category_id' => 'required|integer',
                'post_nature_ids' => 'required|array|min:1',
                'deadline' => 'required|date',
                'is_apply_online' => 'required_if:resume_receiving_option,null',
                'resume_receiving_option' => 'required_if:is_apply_online,false',
                'resume_receiving_details' => "required_if:resume_receiving_option,email,hard_copy,walk_in_interview",
                // 'resume_receive_options' => 'required|array|min:1',
            ];

        } elseif ($postType == 'more_job_info') {
            $rules = [
                'job_level_ids' => 'required|array|min:1',
                'responsibilities' => 'required|string',
                // 'job_location' => 'required|string|in:inside_bd,outside_bd',
                // 'job_area_ids' => 'required|array|min:1',
//                'is_negotiable' => 'required',
                'salary_min' => 'required_if:is_negotiable,false',
                'salary_max' => 'required_if:is_negotiable,false',
                'salary_type' => 'required_if:is_negotiable,false',
            ];
        }

        $this->validate($request, $rules);
    }

    private function getPostById($id)
    {
        return Post::whereCompanyId(COMPANY_ID)->findOrFail($id);
    }
}
