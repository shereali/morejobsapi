<?php

namespace App\Http\Controllers\Employer;

use App\Filters\employer\ApplicantsFilters;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Post;
use App\Models\PostApplicant;
use App\Models\UserExperience;
use App\Services\CommonService;
use App\Services\HelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApplicantProcessController extends Controller
{
    public function summary($id)
    {
        $post = Post::withCount('applicants')
            ->with('package')
            ->whereCompanyId(COMPANY_ID)
            ->findOrFail($id);

        $data['post'] = [
            'id' => $post->id,
            'title' => $post->title,
            'status' => $post->status,
            'type' => $post->package,
            'created_at' => $post->created_at,
            'search_view_count' => 0,
            'detail_view_count' => $post->total_view,
            'total_applicants' => $post->applicants_count,
        ];

        return $this->response($data, 'Applicant process summary');
    }

    public function preview($id)
    {
        // ini_set('memory_limit', '256M');

        $post = Post::withCount('applicants')
            ->with('category', 'postAreas', 'package', 'postSkills')
            ->with('postNatures')
            ->with('postLevels', 'postWorkspaces')
            ->with('postDegrees', 'postInstitutes', 'postTrainings', 'postCertificates', 'postAreaExperiences', 'postGenders')
            ->with('postIndustryTypes')
            ->with('postMatchingCriteria')
            ->with('company')
            ->whereCompanyId(COMPANY_ID)
            ->findOrFail($id);

        $post->postAreas->map(function ($item) {
            if ($item->parent) {
                $item['title'] = $item->parent->title_en . ' -> ' . $item->title_en;
            } else {
                $item['title'] = $item->title_en;
            }
            return $item;
        });

        $post->responsibilities = HelperService::nl2li($post->responsibilities);
        $post->job_context = HelperService::nl2li($post->job_context);
        $post->additional_requirements = HelperService::nl2li($post->additional_requirements);

        $data['post'] = [
            'id' => $post->id,
            'title' => $post->title,
            'status' => $post->status,
            'type' => $post->package,
            'created_at' => $post->created_at,
            'search_view_count' => 0,
            'detail_view_count' => $post->total_view,
            'total_applicants' => $post->applicants_count,
        ];
        $data['preview'] = $post;

        return $this->response($data, 'Job post preview');
    }

    public function candidates($id, ApplicantsFilters $filters)
    {
        // DB::enableQueryLog();

       /* $callback = function ($query) {
            $query->addSelect(['exp_in_years' => UserExperience::select(DB::raw("SUM(TIMESTAMPDIFF(year, `from`, IFNULL(`to`, NOW()))) as exp_in_years"))
                ->whereColumn('users.id', 'user_experience.user_id')
            ]);

            if (request()->has('experience_from') && request()->experience_from) {
                $query->having('exp_in_years', '>=', request()->experience_from);
            }
            if (request()->has('experience_to') && request()->experience_to) {
                $query->having('exp_in_years', '<=', request()->experience_to);
            }
        };*/

        $expSubQuery = DB::table('user_experience')
            ->select('user_experience.user_id', DB::raw("SUM(TIMESTAMPDIFF(year, `from`, IFNULL(`to`, NOW()))) as user_exp_year, SUM(TIMESTAMPDIFF(month, `from`, IFNULL(`to`, NOW()))) as user_exp_month"))
            ->groupBy('user_experience.user_id');

        $genderSubQuery = DB::table('post_gender')
            ->select('post_gender.gender_id', DB::raw("COUNT(post_gender.post_id) as gender_matched_count"));

        $userJobAreaSubQuery = DB::table('user_job_area')
            ->select('user_job_area.user_id', DB::raw("COUNT(post_area.id) as location_matched_count"))
            ->join('post_area', 'post_area.area_id', 'user_job_area.area_id')
            ->where('post_area.post_id', $id)
            ->groupBy('user_job_area.user_id');

        $postAreaSubQuery = DB::table('post_area')
            ->select('post_area.post_id', DB::raw("COUNT(post_area.id) as job_location_count"))
            ->groupBy('post_area.post_id');

        $jobLevelSubQuery = DB::table('post_level')
            ->select('post_level.job_level_id', DB::raw("COUNT(post_level.post_id) as job_level_count"))
            ->where('post_level.post_id', $id)
            ->groupBy('post_level.job_level_id');

        $jobSkillCountSubQuery = DB::table('post_skill')
            ->select(DB::raw("COUNT(CASE WHEN type = 2 THEN 1 ELSE null END) AS post_skill_count"))
            ->whereColumn('post_skill.post_id', 'PA.post_id')
            ->groupBy('PA.post_id')
            ->toSql();

        $jobSkillMatchedSubQuery = DB::table('user_skill_keyword')
            ->select('user_skill_keyword.user_id', DB::raw("COUNT(post_skill.id) as user_job_skill_matched_count"))
            ->join('post_skill', 'post_skill.skill_id', 'user_skill_keyword.skill_id')
            ->where('post_skill.post_id', $id)
            ->where('post_skill.type', 2)
            ->groupBy('user_skill_keyword.user_id');


        $jobExpSkillCountSubQuery = DB::table('post_skill')
            ->select(DB::raw("COUNT(CASE WHEN type = 1 THEN 1 ELSE null END) AS post_skill_count"))
            ->whereColumn('post_skill.post_id', 'PA.post_id')
            ->groupBy('PA.post_id')
            ->toSql();

        $jobExpSkillMatchedSubQuery = DB::table('user_skill')
            ->select('user_skill.user_id', DB::raw("COUNT(post_skill.id) as user_exp_skill_matched_count"))
            ->join('post_skill', 'post_skill.skill_id', 'user_skill.skill_id')
            ->where('post_skill.post_id', $id)
            ->where('type', 1)
            ->groupBy('user_skill.user_id');

        $postAppliesCountSubQuery = DB::table('post_applicants')
            ->select('post_applicants.user_id', DB::raw("COUNT(post_applicants.id) AS post_applies_count"))
            ->whereIn('post_id', function ($query) {
                $query->select('id')->from(with(new Post)->getTable())->whereColumn('company_id', 'posts.company_id');
            })
            ->where('post_applicants.post_id', $id)
            ->groupBy('post_applicants.user_id');

        $userAge = DB::raw("TIMESTAMPDIFF (YEAR, user_profile.dob, CURDATE())");
        $mandatoryMatchCount = DB::raw("COUNT(post_matching_criteria.id)");

        $matchPercentSelect = DB::raw("COUNT(
                                    CASE WHEN post_matching_criteria.matching_criteria_id = 1 THEN
                                    (CASE WHEN $userAge >= posts.age_min AND $userAge <= posts.age_max THEN 1 ELSE null END) ELSE
                                    (CASE WHEN post_matching_criteria.matching_criteria_id = 3 THEN
                                    (CASE WHEN expSubQuery.user_exp_year >= posts.experience_min AND expSubQuery.user_exp_year <= posts.experience_max THEN 1 ELSE null END) ELSE
                                    (CASE WHEN post_matching_criteria.matching_criteria_id = 4 THEN
                                    (CASE WHEN PA.expected_salary >= posts.salary_min AND PA.expected_salary <= posts.salary_max THEN 1 ELSE null END) ELSE
                                    (CASE WHEN post_matching_criteria.matching_criteria_id = 5 THEN
                                    (CASE WHEN genderSubQuery.gender_matched_count > 0 THEN 1 ELSE null END) ELSE
                                    (CASE WHEN post_matching_criteria.matching_criteria_id = 2 THEN
                                    (CASE WHEN (job_location_count IS NULL OR userJobAreaSubQuery.location_matched_count > 0) THEN 1 ELSE null END) ELSE
                                    (CASE WHEN post_matching_criteria.matching_criteria_id = 8 THEN
                                    (CASE WHEN jobLevelSubQuery.job_level_count > 0 THEN 1 ELSE null END) ELSE
                                    (CASE WHEN post_matching_criteria.matching_criteria_id = 9 THEN
                                    (CASE WHEN ($jobSkillCountSubQuery IS NULL OR jobSkillSubQuery.user_job_skill_matched_count > 0) THEN 1 ELSE null END) ELSE
                                    (CASE WHEN post_matching_criteria.matching_criteria_id = 7 THEN
                                    (CASE WHEN ($jobExpSkillCountSubQuery IS NULL OR jobExpSkillSubQuery.user_exp_skill_matched_count > 0) THEN 1 ELSE null END) ELSE null END) END) END) END) END) END) END)END
                            )"
        );

        //ROUND((($matchPercentSelect * 100) /$mandatoryMatchCount), 2)

        $matchingSubQuery = DB::table('post_applicants AS PA')
            ->select(
                'PA.id',
                'posts.title AS post_title',
                DB::raw("TIMESTAMPDIFF (YEAR, user_profile.dob, CURDATE()) AS age"),
                'postAppliesCountSubQuery.post_applies_count',
                'expSubQuery.user_exp_year',
                'expSubQuery.user_exp_month',
                DB::raw("CASE WHEN $mandatoryMatchCount > 0 THEN  ROUND((($matchPercentSelect * 100) /$mandatoryMatchCount), 2) ELSE 100 END AS matched_percentage")
            )
            ->join('posts', 'posts.id', '=', 'PA.post_id')
            ->leftJoin('post_matching_criteria', function ($q) {
                $q->on('post_matching_criteria.post_id', 'posts.id')->where('post_matching_criteria.is_mandatory', 1);
            })
            ->join('users', 'users.id', '=', 'PA.user_id')
            ->join('user_profile', 'users.id', '=', 'user_profile.user_id')
            ->leftJoinSub($expSubQuery, 'expSubQuery', function ($join) {
                $join->on('users.id', '=', 'expSubQuery.user_id');
            })
            ->leftJoinSub($genderSubQuery, 'genderSubQuery', function ($join) {
                $join->on('user_profile.gender_id', '=', 'genderSubQuery.gender_id');
            })
            ->leftJoinSub($userJobAreaSubQuery, 'userJobAreaSubQuery', function ($join) {
                $join->on('PA.user_id', '=', 'userJobAreaSubQuery.user_id');
            })
            ->leftJoinSub($postAreaSubQuery, 'postAreaSubQuery', function ($join) {
                $join->on('PA.post_id', '=', 'postAreaSubQuery.post_id');
            })
            ->leftJoinSub($jobLevelSubQuery, 'jobLevelSubQuery', function ($join) {
                $join->on('user_profile.job_level_id', '=', 'jobLevelSubQuery.job_level_id');
            })
            ->leftJoinSub($jobSkillMatchedSubQuery, 'jobSkillSubQuery', function ($join) {
                $join->on('PA.user_id', '=', 'jobSkillSubQuery.user_id');
            })
            ->leftJoinSub($jobExpSkillMatchedSubQuery, 'jobExpSkillSubQuery', function ($join) {
                $join->on('PA.user_id', '=', 'jobExpSkillSubQuery.user_id');
            })
            ->leftJoinSub($postAppliesCountSubQuery, 'postAppliesCountSubQuery', function ($join) {
                $join->on('PA.user_id', '=', 'postAppliesCountSubQuery.user_id');
            })
            ->where('PA.post_id', $id)
            ->groupBy('PA.id');


        $records = PostApplicant::select(
            'post_applicants.*',
            'matchingSubQuery.age',
            'matchingSubQuery.post_applies_count',
            'matchingSubQuery.post_title',
            'matchingSubQuery.user_exp_year',
            'matchingSubQuery.user_exp_month',
            'matchingSubQuery.matched_percentage'
        )
            ->joinSub($matchingSubQuery, 'matchingSubQuery', function ($join) {
                $join->on('post_applicants.id', '=', 'matchingSubQuery.id');
            })
            //->whereHas('user', $callback)
            ->with(['user' => function ($q) use ($matchingSubQuery) {
                $q->with('profile');
                $q->with('contactMobiles');
                $q->with('educations');
                $q->with('jobExperiences', function ($q) {
                    $q->select('id', 'user_id', 'company_name', 'industry_type_id', 'designation', 'from', 'to', 'is_current',
                        DB::raw("TIMESTAMPDIFF(month, `from`, IFNULL(`to`, NOW())) as months"),
                    //DB::raw("TIMESTAMPDIFF(year, `from`, IFNULL(`to`, NOW())) as years")
                    );
                });

//                $q->addSelect(['exp_in_years' => UserExperience::select(DB::raw("SUM(TIMESTAMPDIFF(year, `from`, IFNULL(`to`, NOW()))) as exp_in_years"))
//                    ->whereColumn('users.id', 'user_experience.user_id'),
//                    'exp_in_months' => UserExperience::select(DB::raw("SUM(TIMESTAMPDIFF(month, `from`, IFNULL(`to`, NOW()))) as exp_in_months"))
//                        ->whereColumn('users.id', 'user_experience.user_id')
//                ]);
//
//                if (request()->has('experience_from') && request()->experience_from) {
//                    $q->having('exp_in_years', '>=', request()->experience_from);
//                }
//                if (request()->has('experience_to') && request()->experience_to) {
//                    $q->having('exp_in_years', '<=', request()->experience_to);
//                }
            }])
            ->where('post_applicants.post_id', $id)
            ->filter($filters)
            ->paginate(HelperService::getMAxItemLimit());

 /*       $records->getCollection()->transform(function ($item) {
            //$item['age'] = Carbon::parse(@$item->user->profile->dob)->age;
            $item['post_applies_count'] = PostApplicant::where('user_id', $item->user_id)->whereIn('post_id', $item->post->company->jobs->pluck('id')->toArray())->count();
            //$item['post_applies_count'] = 0;
            return $item;
        });*/

        $data['records'] = $records;
        $data['summary'] = $this->applicantSummary($id);
        $data['filter_initial_data'] = [
            'genders' => CommonService::genders(),
            'job_levels' => CommonService::jobLevels(),
            'job_natures' => CommonService::jobNatures(),
            'degree_levels' => CommonService::educationLevels(),
            'degrees' => CommonService::degrees(),
            'result_types' => CommonService::resultTypes(),
            'institutes' => CommonService::institutes(),
            'areas' => Area::where(function ($q) {
                $q->whereCountryId(1)->whereLevel(1);
            })->orWhere('country_id', '!=', 1)
                ->get(),
            'industry_types' => CommonService::industryTypes(),
        ];

        return $this->response($data, 'Post applicants list');
    }

    public function updateStatus(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:1,6'
        ]);

        $data = PostApplicant::findOrFail($id);

        try {
            $data->fill($request->only('status'));
            $data['is_viewed'] = 1;
            $data->save();

            return $this->successResponse('Action taken successfully');

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    private function applicantSummary($id)
    {
        return PostApplicant::select(
            DB::raw("COUNT(*) AS total"),
            DB::raw("COUNT(CASE WHEN is_viewed = 1 THEN 1 END) AS total_viewed"),
            DB::raw("COUNT(CASE WHEN is_viewed = 0 THEN 1 END) AS total_not_viewed"),
            DB::raw("COUNT(CASE WHEN status = 1 THEN 1 END) AS total_shortlisted"),
            DB::raw("COUNT(CASE WHEN status = 2 THEN 1 END) AS total_interview_listed"),
            DB::raw("COUNT(CASE WHEN status = 3 THEN 1 END) AS total_final_listed"),
            DB::raw("COUNT(CASE WHEN status = 6 THEN 1 END) AS total_rejected")
        )
            ->where('post_id', $id)
            ->first();
    }
}
