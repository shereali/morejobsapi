<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserAcademic;
use App\Models\UserCertification;
use App\Models\UserLanguage;
use App\Models\UserProfile;
use App\Models\UserReference;
use App\Models\UserTraining;
use App\Services\AuthService;
use App\Services\CommonService;
use App\Services\FileHandleService;
use App\Services\HelperService;
use App\Services\StaticValueService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Swift_Attachment;

class ResumeController extends Controller
{
    public function show(Request $request, $id)
    {
        $data = User::with('contactEmails', 'contactMobiles')
            ->with(['profile' => function ($q) {
                $q->with('gender', 'religion', 'maritalStatus', 'country', 'presentArea', 'permanentArea', 'jobLevel', 'jobNature');
            }])
            ->with(['educations' => function ($q) {
                $q->with('educationLevel', 'degree', 'resultType');
                $q->orderBy('view_order', 'ASC');
            }])
            ->with('trainings.country')
            ->with('specializations')
            ->when($request->detail_type == 'short', function ($q) {
                $q->with(['jobExperiences' => function ($q) {
                    $q->with('industryType');
                    $q->orderBy('from', 'DESC');
                }]);
            }, function ($q) {
                $q->with('preferredOrganizationTypes', 'preferredAreas', 'preferredJobCategories');
                $q->with('languageProficiencies', 'jobExperiences', 'certifications', 'references');
            })
            ->whereUserType(StaticValueService::userTypeIdByKey('employee'))
            ->findOrFail($id);

        if ($request->detail_type != 'short') {
            $data->languageProficiencies->map(function ($item) {
                $item['reading_skill'] = StaticValueService::langProficiencySkillById($item->reading_skill);
                $item['writing_skill'] = StaticValueService::langProficiencySkillById($item->writing_skill);
                $item['speaking_skill'] = StaticValueService::langProficiencySkillById($item->speaking_skill);
            });

            $data['preferred_areas'] = $data->preferredAreas->where('country_id', 1)->values();;
            $data['preferred_areas_outside_bd'] = $data->preferredAreas->where('country_id', '!=', 1)->values();

            unset($data->preferredAreas);
        }

        if (count($data->jobExperiences) > 0) {
            $data->jobExperiences->map(function ($item) {
                $item->responsibilities = HelperService::nl2li($item->responsibilities);
            });
        }

        return $this->response($data, 'Employee resume details');
    }

    public function edit(Request $request)
    {
        $this->validate($request, [
            'edit_option' => 'required|string|in:personal,education_training,employment,specialization,profile_image',
        ]);

        $query = User::whereUserType(StaticValueService::userTypeIdByKey('employee'));

        if ($request->edit_option == 'personal') {
            $query->with('contactEmails', 'contactMobiles', 'preferredJobCategories', 'preferredAreas.parent', 'preferredOrganizationTypes');
            $query->with(['profile' => function ($q) {
                $q->with('gender', 'religion', 'maritalStatus', 'country', 'presentArea.parent.parent',
                    'permanentArea.parent.parent', 'jobLevel', 'jobNature');
            }]);
        } elseif ($request->edit_option == 'education_training') {
            $query->with(['educations' => function ($q) {
                $q->with('educationLevel', 'degree', 'resultType');
                $q->orderBy('view_order', 'ASC');
            }]);
            $query->with('trainings.country');
            $query->with('certifications');
        } elseif ($request->edit_option == 'employment') {
            $query->with(['jobExperiences' => function ($q) {
                $q->with('industryType', 'experienceSkills');
                $q->orderBy('from', 'DESC');
            }]);
        } elseif ($request->edit_option == 'specialization') {
            $query->with('specializations');
            $query->with('languageProficiencies');
            $query->with('references');
        }

        $user = $query->findOrFail(AuthService::getAuthUserId());

        if ($request->edit_option == 'personal') {
            $formattedPreferredAreas = $user->preferredAreas->where('country_id', 1)->values()->map(function ($item) {
                $data = $item->only('id', 'title_en');
                $data['title'] = @$item->parent->title_en . ' -> ' . $item->title_en;

                return $data;
            });

            $user['preferred_areas'] = $formattedPreferredAreas;
            $user['preferred_areas_outside_bd'] = $user->preferredAreas->where('country_id', '!=', 1)->values();

            $user->unsetRelation('preferredAreas');
        }

        $data['resume_data'] = $user;
        $data['initial_data'] = $this->initiateEdit($request->edit_option, $user);

        return $this->response($data, 'Employee resume details');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'edit_option' => 'required|string|in:personal,education_training,employment,specialization,profile_image',
        ]);

        $this->validateRequest($request);

        $user = User::whereUserType(StaticValueService::userTypeIdByKey('employee'))->findOrFail(AuthService::getAuthUserId());
        $message = null;
        $optionalId = 0;

        try {
            DB::beginTransaction();

            if ($request->edit_option == 'personal') {
                $user->load('profile', 'contactEmails', 'contactMobiles');

                $this->updateOrCreateProfile($request, $user);
                $message = 'Personal information updated successfully';

            } elseif ($request->edit_option == 'education_training') {
                $user->load('educations');
                $user->load('trainings.country');
                $user->load('certifications');

                $this->updateOrCreateEducation($request, $user);
                $message = 'Education, Course & Certification information updated successfully';

            } elseif ($request->edit_option == 'employment') {
                $user->load('jobExperiences.industryType');

                $this->updateOrCreateExperience($request, $user);
                $message = 'Employment information updated successfully';

            } elseif ($request->edit_option == 'specialization') {
                $user->load('specializations');
                $data = $this->updateOrCreateSpecialization($request, $user);

                $optionalId = @$data->id;
                $message = 'Specialization information updated successfully';

            } elseif ($request->edit_option == 'profile_image') {
                FileHandleService::delete($user->image);

                if ($request->hasFile('file')) {
                    $user->image = FileHandleService::upload($request->file, FileHandleService::getAvatarStoragePath());

                    $user->save();
                    $message = 'Avatar changed successfully';
                } else {
                    $user->image = null;
                    $user->save();
                    $message = 'Avatar deleted successfully';
                }
            }

            $user['optional_id'] = $optionalId;

            DB::commit();
            return $this->successResponse($message, $user);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }

    }

    public function resumeFileShow()
    {
        $data = UserProfile::whereUserId(AuthService::getAuthUserId())->first();

        return $this->response($data, 'Resume file detail');
    }

    public function uploadResume(Request $request)
    {
        $this->validate($request, [
            //'file' => 'required|mimes:doc,docx,pdf|max:5048'
            'file' => 'required'
        ]);

        $user = AuthService::getAuthUser();
        $userProfile = $user->profile;

        try {
            DB::beginTransaction();

            $extension = $request->file('file')->extension();

            $path = $request->file->storeAs(FileHandleService::getResumeStoragePath(), ucfirst(Auth::user()->first_name) . '.' . $extension);

            if ($userProfile->resume_file) {
                FileHandleService::delete($userProfile->resume_file);
            }

            $userProfile->resume_file = $path;
            $userProfile->save();

            DB::commit();
            return $this->successResponse('Resume uploaded successfully', $user);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }

    public function destroyResume(): JsonResponse
    {
        $userProfile = AuthService::getAuthUser()->profile;

        if (empty($userProfile->resume_file)) {
            return $this->errorResponse('No resume file found!');
        }

        try {
            DB::beginTransaction();

            FileHandleService::delete($userProfile->getRawOriginal('resume_file'));

            $userProfile->resume_file = null;
            $userProfile->save();

            DB::commit();
            return $this->successResponse('Resume file deleted successfully', $userProfile);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }

    public function resumeDownload()
    {
        $data = UserProfile::whereUserId(AuthService::getAuthUserId())->first();

        if (empty($data->resume_file)) {
            return $this->errorResponse('No resume file to download');
        }

        try {
            $file = public_path() . "/uploads/" . $data->resume_file;

            $headers = array(
                'Content-Type' => 'application/pdf',
            );

            return response()->download($file, AuthService::getAuthUser()->first_name . '.pdf', $headers);

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }


    public function resumeDownloadDoc(Request $request)
    {
        $user = AuthService::getAuthUser();

        $data = User::with('contactEmails', 'contactMobiles')
            ->with(['profile' => function ($q) {
                $q->with('gender', 'religion', 'maritalStatus', 'country', 'presentArea', 'permanentArea', 'jobLevel', 'jobNature');
            }])
            ->with(['educations' => function ($q) {
                $q->with('educationLevel', 'degree', 'resultType');
                $q->orderBy('view_order', 'ASC');
            }])
            ->with('trainings.country')
            ->with('specializations')
            ->when($request->detail_type == 'short', function ($q) {
                $q->with(['jobExperiences' => function ($q) {
                    $q->with('industryType');
                    $q->orderBy('from', 'DESC');
                }]);
            }, function ($q) {
                $q->with('preferredOrganizationTypes', 'preferredAreas', 'preferredJobCategories');
                $q->with('languageProficiencies', 'jobExperiences', 'certifications', 'references');
            })
            ->whereUserType(StaticValueService::userTypeIdByKey('employee'))
            ->findOrFail($user->id);


        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        $section = $phpWord->addSection();

        $section->addText($data->first_name . ' ' . $data->last_name, [
            'size' => 18,
            'color' => '0E5DA4',
            'bold' => true
        ]);

        $imageStyle = array(
            'width' => 80,
            'height' => 80,
            'wrappingStyle' => 'square',
            'positioning' => 'absolute',
            'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_RIGHT,
            'posHorizontalRel' => 'margin',
            'posVerticalRel' => 'line',
        );
        $section->addImage("https://www.itsolutionstuff.com/frontTheme/images/logo.png", $imageStyle);

        $section->addText('Address: ' . $data->profile->present_address, [
            'size' => 12,
            'color' => '444749',
        ]);

        $section->addText('Mobile N0: ' . count($data->contactMobiles) > 0 ? $data->contactMobiles[0]['title'] : 'n/a', [
            'size' => 12,
            'color' => '444749',
        ]);

        $section->addText('Email: ' . count($data->contactEmails) > 0 ? $data->contactEmails[0]['title'] : 'n/a', [
            'size' => 12,
            'color' => '444749',
            'lineHeight' => '4',
        ]);

        $section->addText('Career Objective: ',
            [
                'size' => 12, 'color' => '444749', 'paddingTop' => 600, 'marginBottom' => 600
            ],
            [
                'shading' => ['fill' => 'dddddd', 'paddingTop' => 600, 'marginBottom' => 600]
            ]
        );

        $section->addText($data->profile->career_summary, [
            'size' => 12,
            'color' => '444749',
            'lineHeight' => '1',
        ]);

        $section->addText('Employment History: ',
            [
                'size' => 12, 'color' => '444749'
            ],
            [
                'shading' => ['fill' => 'dddddd']
            ]
        );

        $totalExp = $section->addTextRun();
        $totalExp->addText('Total Year of Experience:', [
            'size' => 12,
            'color' => '444749',
            'bold' => true,
            'lineHeight' => '1',
        ]);
        $totalExp->addText('3.5 years', array('color' => '444749'));


        //


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('helloWorld.docx'));
        } catch (\Exception $e) {
        }


        //  return response()->download(storage_path('helloWorld.docx'));


        try {
            $file = public_path() . "/uploads/" . $data->resume_file;

            $headers = array(
                'Content-Type: application/pdf',
            );

            return response()->download($file, AuthService::getAuthUser()->first_name . '.pdf', $headers);

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    private function updateOrCreateProfile($request, $user)
    {
        if ($request->edit_type == 'personal_details') {
            $user->fill($request->only('first_name', 'last_name'));
            $user->resume_completed = 1;
            $user->save();

            if ($user->profile) {
                $user->profile->fill($request->all());
                $user->profile->save();
            } else {
                $user->profile()->create($request->all());
            }

            $user->contacts()->delete();
            $mergedContacts = collect(array_merge($request->contact_mobiles, $request->contact_emails))->where('title', '!=', null)->values();
            foreach ($mergedContacts as $contact) {
                $user->contacts()->create($contact);
            }

        } elseif ($request->edit_type == 'address') {
            $presentAddress = $request->present_address['address_present'];

            //temporary.... start
            $presentPO = $request->present_address['po_present'];
            $permanentPO = @$request->permanent_address['po_permanent'];

            if ($request->present_address['is_present_address_inside']) {
                $presentAreaId = ($request->present_address['thana_present'] ?? $request->present_address['district_present']);
            } else {
                $presentAreaId = $request->present_address['present_area_id_outside'];
            }

            if ($request->same_as_present_address) {
                $permanentAddress = $presentAddress;
                $permanentAreaId = $presentAreaId;
                $permanentPO = $presentPO;
            } else {
                $permanentAddress = $request->permanent_address['address_permanent'];
                if ($request->permanent_address['is_permanent_address_inside']) {
                    $permanentAreaId = ($request->permanent_address['thana_permanent'] ?? $request->permanent_address['district_permanent']);
                } else {
                    $permanentAreaId = $request->permanent_address['permanent_area_id_outside'];
                }
            }
            // //temporary.... end


            /*if ($request->present_address['is_present_address_inside']) {
                $presentAreaId = $request->present_address['po_present'] ?? ($request->present_address['thana_present'] ?? $request->present_address['district_present']);
            } else {
                $presentAreaId = $request->present_address['present_area_id_outside'];
            }

            if ($request->same_as_present_address) {
                $permanentAddress = $presentAddress;
                $permanentAreaId = $presentAreaId;
            } else {
                $permanentAddress = $request->permanent_address['address_permanent'];
                if ($request->permanent_address['is_permanent_address_inside']) {
                    $permanentAreaId = $request->permanent_address['po_permanent'] ?? ($request->permanent_address['thana_permanent'] ?? $request->permanent_address['district_permanent']);
                } else {
                    $permanentAreaId = $request->permanent_address['permanent_area_id_outside'];
                }
            }*/

            if ($user->profile) {
                $user->profile->fill([
                    'present_address' => $presentAddress,
                    'present_area_id' => $presentAreaId,
                    'permanent_address' => $permanentAddress,
                    'permanent_area_id' => $permanentAreaId,

                    'present_po' => $presentPO,
                    'permanent_po' => $permanentPO,
                ]);

                $user->profile->save();
            } else {
                $user->profile()->create([
                    'present_address' => $presentAddress,
                    'present_area_id' => $presentAreaId,
                    'permanent_address' => $permanentAddress,
                    'permanent_area_id' => $permanentAreaId,

                    'present_po' => $presentPO,
                    'permanent_po' => $permanentPO,
                ]);
            }

        } elseif ($request->edit_type == 'career_objective') {
            $user->profile->fill($request->only('objective', 'present_salary', 'expected_salary', 'job_level_id', 'job_nature_id'));
            $user->profile->save();

        } elseif ($request->edit_type == 'preferred_area') {
            $user->preferredJobCategories()->sync(array_merge($request->preferred_job_categories, $request->preferred_job_categories_special_skill));
            $user->preferredAreas()->sync(array_merge(collect($request->preferred_areas)->pluck('id')->values()->toArray(), collect($request->preferred_countries)->pluck('id')->values()->toArray()));
            $user->preferredOrganizationTypes()->sync(collect($request->preferred_org_types)->pluck('id')->values());

        } elseif ($request->edit_type == 'other') {
            $user->profile->fill($request->only('career_summary', 'keywords', 'specialization'));
            $user->profile->save();
        }
    }

    private function updateOrCreateEducation($request, $user)
    {
        if ($request->edit_type == 'academic') {
            if ($request->mode == 'edit') {
                $education = $user->educations->where('id', $request->id)->first();
                $education->fill($request->only('education_level_id', 'degree_id', 'hide_mark', 'passing_year',
                    'duration', 'institute_name', 'achievement', 'cgpa', 'result_type_id', 'major'));
                $education->save();

            } else {
                $user->educations()->create($request->only('education_level_id', 'degree_id', 'hide_mark', 'passing_year',
                    'duration', 'institute_name', 'achievement', 'cgpa', 'result_type_id', 'major'));
            }

        } elseif ($request->edit_type == 'training') {
            if ($request->mode == 'edit') {
                $training = $user->trainings->where('id', $request->id)->first();
                $training->fill($request->only('title', 'country_id', 'topic', 'year', 'duration', 'institute_name', 'address'));
                $training->save();

            } else {
                $user->trainings()->create($request->only('title', 'country_id', 'topic', 'year', 'duration', 'institute_name', 'address'));
            }

        } elseif ($request->edit_type == 'certification') {
            if ($request->mode == 'edit') {
                $certificate = $user->certifications->where('id', $request->id)->first();
                $certificate->fill($request->only('title', 'country_id', 'from', 'to', 'duration', 'institute_name', 'address'));
                $certificate->save();

            } else {
                $user->certifications()->create($request->only('title', 'country_id', 'from', 'to', 'duration', 'institute_name', 'address'));
            }
        }
    }

    private function updateOrCreateExperience($request, $user)
    {
        if ($request->edit_type == 'employment_history') {
            if ($request->mode == 'edit') {
                $experience = $user->jobExperiences->where('id', $request->id)->first();
                $experience->fill($request->all());
                $experience->save();

                $user->userSkills()->wherePivot('user_experience_id', $experience->id)->detach();
                foreach ($request->experience_skills as $skill) {
                    $user->userSkills()->attach($skill['id'], [
                        'user_experience_id' => $experience['id'],
                    ]);
                }

            } else {
                $experience = $user->jobExperiences()->create($request->all());
                foreach ($request->experience_skills as $skill) {
                    $user->userSkills()->attach($skill['id'], [
                        'user_experience_id' => $experience['id'],
                    ]);
                }
            }
        }
    }

    private function updateOrCreateSpecialization($request, $user)
    {
        if ($request->edit_type == 'specialization') {
            $user->specializations()->detach();
            foreach ($request->skill_id as $skill) {
                $user->specializations()->attach($skill['id']);
            }
        } else if ($request->edit_type == 'language') {
            if ($request->id) {
                $data = UserLanguage::findOrFail($request->id);
                $data->fill($request->all());
                return $data->save();
            } else {
                return $user->languageProficiencies()->create($request->all());
            }
        } else if ($request->edit_type == 'references') {
            if ($request->id) {
                $data = UserReference::findOrFail($request->id);
                $data->fill($request->all());
                return $data->save();
            } else {
                return $user->references()->create($request->all());
            }
        }
    }

    private function initiateEdit($editOption, $user = null): array
    {
        $data = [];

        if ($editOption == 'personal') {
            $data['gender'] = CommonService::genders();
            $data['religions'] = CommonService::religions();
            $data['marital_status'] = CommonService::maritalStatus();
            $data['job_levels'] = CommonService::jobLevels();
            $data['job_natures'] = CommonService::jobNatures();
            $data['job_categories_functional'] = CommonService::jobCategories('functional');
            $data['job_categories_special_skill'] = CommonService::jobCategories('special_skill');
            $data['industry_types'] = CommonService::industryTypes();
            $data['areas'] = CommonService::areas();
            $data['areas_outside_bd'] = collect($data['areas'])->where('country_id', '!=', 1)->values()->toArray();
            $data['countries'] = CommonService::countries();
            $data['districts'] = CommonService::districtsInside();

        } elseif ($editOption == 'education_training') {
            $data['education_levels'] = CommonService::educationLevels();
            $data['result_types'] = CommonService::resultTypes();
            $data['degrees'] = CommonService::degrees();
            $data['institutes'] = CommonService::institutes();
            $data['countries'] = CommonService::countries();

            $yearRange = range(1970, Carbon::now()->year);
            $data['passing_years'] = collect(array_reverse($yearRange))->map(function ($item) {
                return [
                    'id' => $item,
                    'title' => $item,
                ];
            });

        } elseif ($editOption == 'employment') {
            $data['skills'] = CommonService::skills();
            $data['industry_types'] = CommonService::industryTypes();

        } elseif ($editOption == 'specialization') {
            $data['skills'] = CommonService::skills();
            $data['skill_learning_technique'] = [
                ['id' => 1, 'title' => 'Self'],
                ['id' => 2, 'title' => 'Job'],
                ['id' => 3, 'title' => 'Educational'],
                ['id' => 4, 'title' => 'Professional Course'],
            ];
            $data['language_skill_rates'] = [
                ['id' => 1, 'title' => 'High'],
                ['id' => 2, 'title' => 'Medium'],
                ['id' => 3, 'title' => 'Low'],
            ];
            $data['relation_types'] = [
                ['id' => 1, 'title' => 'Relative'],
                ['id' => 2, 'title' => 'Family Friend'],
                ['id' => 3, 'title' => 'Academic'],
                ['id' => 4, 'title' => 'Professional'],
                ['id' => 5, 'title' => 'Others'],
            ];
        }


        return $data;
    }

    private function validateRequest($request)
    {
        $rules = [];

        if ($request->edit_option == 'personal') {
            if ($request->edit_type == 'personal_details') {
                $rules = [
                    'first_name' => 'required|string',
                    'last_name' => 'required|string',
                    'dob' => 'required|date',
                    'gender_id' => 'required|integer',
                    'marital_status_id' => 'required|integer',
                    //'country_id' => 'required|integer',
                ];

            } elseif ($request->edit_type == 'address') {
                $rules = [
                    'present_address' => 'required'
                ];

            } elseif ($request->edit_type == 'career_objective') {
                $rules = [
                    'objective' => 'required|string'
                ];

            } elseif ($request->edit_type == 'preferred_area') {
                $min1 = count($request->preferred_job_categories_special_skill) == 0 ? 1 : 0;
                $min2 = count($request->preferred_job_categories) == 0 ? 1 : 0;

                $rules = [
                    'preferred_job_categories' => "required_if:$min2,0|array|min:$min1",
                    'preferred_job_categories.*' => 'integer',
                    'preferred_job_categories_special_skill' => "required_if:$min1,0|array|min:$min2",
                    'preferred_job_categories_special_skill.*' => 'integer',

                    'preferred_areas' => 'required|array|min:1',
                ];
            } elseif ($request->edit_type == 'other') {
                $rules = [
                    'keywords' => 'required|string'
                ];
            }

        } elseif ($request == 'education') {
            if ($request->edit_type == 'academic') {
                $rules = [
                    'education_level_id' => 'required|integer',
                    'degree_id' => 'required|integer',
                    'institute_name' => 'required|string',
                    'result_type_id' => 'required|integer',
                    'cgpa' => 'required|numeric',
                    'duration' => 'required|numeric',
                    'passing_year' => 'required|numeric',
                ];

            } elseif ($request->edit_type == 'training') {
                $rules = [
                    'title' => 'required|string',
                    'country_id' => 'required|integer',
                    'year' => 'required|numeric',
                    'duration' => 'required|string',
                    'institute_name' => 'required|string',
                ];

            } elseif ($request->edit_type == 'certification') {
                $rules = [
                    'title' => 'required|string',
                    'institute_name' => 'required|string',
                    'from' => 'required|date',
                    'to' => 'required|date|after:from',
                ];
            }

        } elseif ($request->edit_option == 'employment') {
            if ($request->edit_type == 'employment_history') {
                $rules = [
                    'company_name' => 'required|string',
                    'industry_type_id' => 'required|integer',
                    'designation' => 'required|string',
                    'from' => 'required|date',
                    'to' => 'nullable|date|after:from',
                    'experience_skills' => 'required|array|min:1'
                ];
            }

        } elseif ($request->edit_option == 'specialization') {
            if ($request->edit_type == 'specialization') {
                $rules = [
                    'skill_id' => 'array',
                ];
            }

        } elseif ($request->edit_option == 'profile_image') {
            $rules = [
                'file' => 'mimes:jpeg,jpg,png,gif|max:2024'
            ];
        }

        $this->validate($request, $rules);
    }

    public function deleteLanguage($id)
    {
        $data = UserLanguage::findOrFail($id);

        try {
            $data->delete();
            return $this->successResponse('Language deleted successfully');

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function deleteReference($id)
    {
        $data = UserReference::findOrFail($id);

        try {
            $data->delete();
            return $this->successResponse('Reference deleted successfully');

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function deleteEducation($id)
    {
        $data = UserAcademic::findOrFail($id);

        try {
            $data->delete();
            return $this->successResponse('Education deleted successfully');

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function deleteTraining($id)
    {
        $data = UserTraining::findOrFail($id);

        try {
            $data->delete();
            return $this->successResponse('Course deleted successfully');

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function deleteCertificate($id)
    {
        $data = UserCertification::findOrFail($id);

        try {
            $data->delete();
            return $this->successResponse('Certificate deleted successfully');

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function sendEmail(Request $request)
    {
        $this->validate($request, [
            'modified_email' => 'required|email',
            'company_email' => 'required|email',
            'subject' => 'required|string',
            'attachment_type' => 'required|string',
        ]);

        try {
            $user = AuthService::getAuthUser()->load('profile');

            if ($request->attachment_type == 'uploaded_file' && $user->profile->resume_file) {
                $attachment = public_path('uploads/' . $user->profile->getRawOriginal('resume_file'));

            } else {
                $resumeType = $request->attachment_type;
                $fileName = ucfirst($user->first_name) . '.doc';

                $resume = User::with('contactEmails', 'contactMobiles')
                    ->with(['profile' => function ($q) {
                        $q->with('gender', 'religion', 'maritalStatus', 'country', 'presentArea', 'permanentArea', 'jobLevel', 'jobNature');
                    }])
                    ->with(['educations' => function ($q) {
                        $q->with('educationLevel', 'degree', 'resultType');
                        $q->orderBy('view_order', 'ASC');
                    }])
                    ->with('trainings.country')
                    ->with('specializations')
                    ->when($request->detail_type == 'short', function ($q) {
                        $q->with(['jobExperiences' => function ($q) {
                            $q->with('industryType');
                            $q->orderBy('from', 'DESC');
                        }]);
                    }, function ($q) {
                        $q->with('preferredOrganizationTypes', 'preferredAreas', 'preferredJobCategories');
                        $q->with('languageProficiencies', 'jobExperiences', 'certifications', 'references');
                    })
                    ->whereUserType(StaticValueService::userTypeIdByKey('employee'))
                    ->findOrFail(AuthService::getAuthUserId());

                if ($request->detail_type != 'short') {
                    $resume->languageProficiencies->map(function ($item) {
                        $item['reading_skill'] = StaticValueService::langProficiencySkillById($item->reading_skill);
                        $item['writing_skill'] = StaticValueService::langProficiencySkillById($item->writing_skill);
                        $item['speaking_skill'] = StaticValueService::langProficiencySkillById($item->speaking_skill);
                    });

                    $resume['preferred_areas'] = $resume->preferredAreas->where('country_id', 1)->values();;
                    $resume['preferred_areas_outside_bd'] = $resume->preferredAreas->where('country_id', '!=', 1)->values();

                    unset($resume->preferredAreas);
                }

                if (count($resume->jobExperiences) > 0) {
                    $resume->jobExperiences->map(function ($item) {
                        $item->responsibilities = HelperService::nl2li($item->responsibilities);
                    });
                }

                $html = View::make('templates.document.resume-doc', compact('resumeType', 'resume'));

                Storage::disk('local')->put($fileName, $html);
                $attachment = storage_path('app/' . $fileName);
            }


            $swiftAttachment = Swift_Attachment::fromPath($attachment);

            Mail::send([], [], function ($message) use ($request, $swiftAttachment) {
                $message->to($request->company_email)
                    ->replyTo($request->modified_email)
                    ->subject($request->subject)
                    ->setBody($request->body)
                    ->attach($swiftAttachment);
            });

            if ($request->attachment_type != 'uploaded_file') {
                unlink($attachment);
            }

            return $this->successResponse('Mail sent successfully');

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }
}
