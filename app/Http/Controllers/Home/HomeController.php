<?php

namespace App\Http\Controllers\Home;

use App\Filters\Home\CategoryWiseJobFilters;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\Area;
use App\Models\Category;
use App\Models\Company;
use App\Models\Post;
use App\Models\PostApplicant;
use App\Models\PostArea;
use App\Models\Tag;
use App\Models\TrainingType;
use App\Models\User;
use App\Models\UserFavPost;
use App\Services\AuthService;
use App\Services\CommonService;
use App\Services\HelperService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function home($lang = null)
    {
        $toDay = Carbon::now()->toDateTimeString();

        $categories = Category::select('categories.id', 'categories.category_type_id', 'categories.title_en', 'categories.title_bn', 'categories.tag_id',
            DB::raw("COUNT(posts.category_id) AS job_count"))
            ->leftJoin('posts', function ($join) use ($toDay) {
                $join->on('posts.category_id', 'categories.id');
                $join->where('posts.job_listing_type_id', 1);
                $join->where('status', 2);
                $join->where('deadline', '>', $toDay);
            })
            ->groupBy('categories.id')
            //->havingRaw('job_count > 0')
            ->get()
            ->groupBy('category_type_id');

        $data['categories_functional'] = @$categories[1] ? collect($categories[1])->where('tag_id', 1) : [];
        $data['categories_industrial'] = @$categories[1] ? collect($categories[1])->where('tag_id', 2) : [];
        $data['categories_special_skilled'] = @$categories[2] ?? [];

        $data['tag_types'] = Tag::select('id', 'title_en', 'title_bn')->get();

        $divisions = Area::select('id', 'title_en', 'title_bn')
            ->with(['subAreas' => function ($q) {
                $q->select('id', 'parent_id');
            }])
            ->whereNull('parent_id')
            ->whereCountryId(1)
            ->get()
            ->map(function ($item) use ($toDay) {
                $ids = array_merge($item->subAreas->pluck('parent_id')->toArray(), [$item->id]);
                $item['job_count'] = PostArea::join('posts', function ($join) use ($toDay) {
                    $join->on('posts.id', 'post_area.post_id');
                    $join->where('posts.job_listing_type_id', 1);
                    $join->where('posts.status', 2);
                    $join->where('deadline', '>', $toDay);
                })->whereIn('area_id', collect($ids)->unique())->count();

                unset($item->subAreas);
                return $item;
            });

        $govtJobs = Post::select('id', 'title', 'company_id', 'job_listing_type_id')
            ->with(['company' => function ($q) {
                $q->Select('id', 'title_en', 'title_bn');
            }])
            ->where('job_listing_type_id', 4)
            ->where('status', 2)
            ->where('deadline', '>', $toDay)
            ->get();

        $hotJobs = Company::whereHas('jobs', function ($q) use ($toDay) {
            $q->where('job_listing_type_id', 2);
            $q->where('status', 2);
            $q->where('deadline', '>', $toDay);
        })->with(['jobs' => function ($q) use ($toDay) {
            $q->where('job_listing_type_id', 2);
            $q->where('status', 2);
            $q->where('deadline', '>', $toDay);
        }])->whereStatus(1)
            ->get();

        $tenders = Company::whereHas('jobs', function ($q) use ($toDay) {
            $q->where('job_listing_type_id', 3);
            $q->where('status', 2);
            $q->where('deadline', '>', $toDay);
        })->with(['jobs' => function ($q) use ($toDay) {
            $q->where('job_listing_type_id', 3);
            $q->where('status', 2);
            $q->where('deadline', '>', $toDay);
        }])
            ->whereStatus(1)
            ->get();

        $data['divisions'] = $divisions;
        $data['organization_types'] = CommonService::organizationTypes();
        $data['govt_jobs'] = $govtJobs->split(ceil($govtJobs->count() / 3))->toArray();
        $data['total_govt_jobs'] = $govtJobs->count();


        $data['hot_jobs'] = $hotJobs;
        $data['tenders'] = $tenders;

        $data['courses'] = TrainingType::whereHas('courses', function ($q) use ($toDay) {
            $q->where('end_date', '>', $toDay);
        })->with(['courses' => function ($q) use ($toDay) {
            $q->where('end_date', '>', $toDay);
        }])->whereIn('id', [1, 2])
            ->get();

        $data['ads'] = $this->getAds('LANDING');

        return view('pages.index', compact('data'));
    }

    public function jobList(Request $request, CategoryWiseJobFilters $filters)
    {
        $toDay = Carbon::now()->toDateTimeString();

        $records = Post::with('company')
            ->with('postDegrees', 'postAreas')
            ->filter($filters)
            ->orderBy('created_at', 'DESC')
            ->where('status', 2)
            ->where('deadline', '>', $toDay)
            ->paginate(HelperService::getMAxItemLimit(20));

        $totalRecords = $records->total();

        if ($request->ajax()) {
            $html = view('pages.jobList.content', compact('records'))->render();

            return compact('html', 'totalRecords');
        }

        $categories = Category::select('categories.id', 'categories.category_type_id', 'categories.title_en', 'categories.title_bn', 'categories.tag_id',
            DB::raw("COUNT(posts.category_id) AS job_count"))
            ->leftJoin('posts', function ($join) use ($toDay) {
                $join->on('posts.category_id', 'categories.id');
                $join->where('posts.status', 2);
                $join->where('deadline', '>', $toDay);
            })
            ->groupBy('categories.id')
            //->havingRaw('job_count > 0')
            ->get()
            ->groupBy('category_type_id');

        $data['categories'] = @$categories[1] ? collect($categories[1])->where('tag_id', 1) : [];
        $data['categories_special_skilled'] = @$categories[2] ?? [];
        $data['industry_types'] = CommonService::industryTypes();
        $data['organization_types'] = CommonService::organizationTypes();
        $data['job_natures'] = CommonService::jobNatures();
        $data['job_levels'] = CommonService::jobLevels();
        $data['divisions'] = Area::select('id', 'title_en', 'title_bn', 'parent_id', 'slug')
            ->with(['subAreas' => function ($q) {
                $q->select('id', 'title_en', 'title_bn', 'parent_id', 'slug');
            }])->whereNull('parent_id')
            ->whereCountryId(1)
            ->get();
        $data['outside_bd'] = Area::select('id', 'title_en', 'title_bn', 'parent_id', 'slug')
            ->whereNull('parent_id')
            ->whereCountryId(2)
            ->get();

        $data['exp_range'] = [
            ['id' => 'below_1_year', 'title_en' => 'Below 1 year', 'title_bn' => '১ বছরের চেয়ে কম'],
            ['id' => '1_to_3', 'title_en' => '1 - < 3 years', 'title_bn' => '১  -  < ৩ বছর'],
            ['id' => '3_to_5', 'title_en' => '3 - < 5 years', 'title_bn' => '৩  -  < ৫ বছর'],
            ['id' => '5_to_10', 'title_en' => '5 - < 10 years', 'title_bn' => '৫  -  < ১০ বছর'],
            ['id' => 'over_10_years', 'title_en' => 'Over 10 years', 'title_bn' => '১০ বছরের চেয়ে বেশি'],
        ];
        $data['age_range'] = [
            ['id' => 'below_20_years', 'title_en' => 'Below 20 years', 'title_bn' => '২০ বছরের চেয়ে কম'],
            ['id' => '20_to_30', 'title_en' => '20 - < 30 years', 'title_bn' => '২০  -   < ৩০ বছর'],
            ['id' => '30_to_40', 'title_en' => '30 - < 40 years', 'title_bn' => '৩০  -   < ৪০ বছর'],
            ['id' => '40_to_50', 'title_en' => '40 - < 50 years', 'title_bn' => '৪০  -  < ৫০ বছর'],
            ['id' => 'over_50_years', 'title_en' => 'Over 50 years', 'title_bn' => '৫০ বছরের চেয়ে বেশি'],
        ];
        $data['post_date_range'] = [
            ['id' => 'today', 'title_en' => 'Today', 'title_bn' => 'আজ'],
            ['id' => 'last_2_days', 'title_en' => 'Last 2 days', 'title_bn' => 'বিগত ২ দিন'],
            ['id' => 'last_3_days', 'title_en' => 'Last 3 days', 'title_bn' => 'বিগত ৩ দিন'],
            ['id' => 'last_4_days', 'title_en' => 'Last 4 days', 'title_bn' => 'বিগত ৪ দিন'],
            ['id' => 'last_5_days', 'title_en' => 'Last 5 days', 'title_bn' => 'বিগত ৫ দিন'],
        ];
        $data['deadline_range'] = [
            ['id' => 'today', 'title_en' => 'Today', 'title_bn' => 'আজ'],
            ['id' => 'tomorrow', 'title_en' => 'Tomorrow', 'title_bn' => 'আগামীকাল'],
            ['id' => 'next_2_days', 'title_en' => 'Next 2 days', 'title_bn' => 'পরবর্তী ২ দিন'],
            ['id' => 'next_3_days', 'title_en' => 'Next 3 days', 'title_bn' => 'পরবর্তী ৩ দিন'],
            ['id' => 'next_4_days', 'title_en' => 'Next 4 days', 'title_bn' => 'পরবর্তী ৪ দিন'],
        ];

        $data['ads'] = $this->getAds('JOB_List');

        return view('pages.jobList.index', compact('records', 'data', 'totalRecords'));
    }

    public function postDetails($id)
    {
        $post = Post::with('category')
            ->with('postNatures', 'postSkills')
            ->with('postLevels', 'postWorkspaces', 'postAreas')
            ->with('postDegrees', 'postInstitutes', 'postTrainings', 'postCertificates', 'postAreaExperiences', 'postGenders')
            ->with('postCompanyIndustryTypes', 'postIndustryTypes')
            ->with('postMatchingCriteria')
            ->with('company')
            ->findOrFail($id);
        $post->responsibilities = HelperService::nl2li($post->responsibilities);
        $post->job_context = HelperService::nl2li($post->job_context);
        $post->additional_requirements = HelperService::nl2li($post->additional_requirements);

        $post->postDegrees->map(function ($item) {
            if (@$item->pivot->major) {
                $item->title = $item->title . " in " . $item->pivot->major;
            }
            return $item;
        });

        $post['ads'] = $this->getAds('JOB_DETAILS');

        return view('pages.jobList.job-details', compact('post'));
    }

    public function checkApplied($id)
    {
        $isApplied = false;
        $isShortlisted = false;
        if (Auth::id()) {
            $isApplied = PostApplicant::where('post_id', $id)->where('user_id', Auth::id())->exists();
            $isShortlisted = UserFavPost::where('post_id', $id)->where('user_id', Auth::id())->exists();
        }

        return response()->json([
            'success' => true,
            'data' => [
                'is_applied' => $isApplied,
                'is_shortlisted' => $isShortlisted,
            ]
        ]);
    }

    public function applyOnline($id)
    {
        $data = Post::with('company')->findOrFail($id);

        return view('pages.jobList.online-apply', compact('data'));
    }

    public function submitJobApplication(Request $request, $id)
    {
        $this->validate($request, [
            'expected_salary' => 'required|numeric'
        ]);

        $user = AuthService::getAuthUser();

        if ($user->getAttributes()['user_type'] != 2) {
            return $this->errorResponse('Only employee can able to apply');
        }

        $post = Post::with(['postMatchingCriteriaMandatory' => function ($q) {
            $q->whereNotIn('matching_criteria.id', [8]);
        }])
            ->with('postGenders', 'postSkills')
            ->findOrFail($id);

        if (count($post->postMatchingCriteriaMandatory) > 0) {
            $user = User::with('profile', 'jobExperiences', 'userSkills')->findOrFail(AuthService::getAuthUserId());

            $mandatoryCriterias = $post->postMatchingCriteriaMandatory->map(function ($item) use ($user, $post, $request) {
                $item['matched'] = false;

                if ($item->id == 1) { //1=age
                    $dob = $user->profile->dob ? Carbon::parse($user->profile->dob) : Carbon::now();
                    $age = $dob->diffInYears(Carbon::now());

                    $item['matched'] = $age >= $post->age_min && $age <= $post->age_max;
                    $item['expected'] = $post->age_min . ' - ' . $post->age_max . ' year(s)';
                    $item['user_info'] = $age;

                } elseif ($item->id == 2) {//2=location

                } elseif ($item->id == 3) {//3=year of experience
                    $jobExperiences = $user->jobExperiences->map(function ($item) {
                        $item['exp_duration'] = Carbon::parse($item['from'])->diff(Carbon::parse($item['to']))->format('%y years %m months');
                        $item['exp_duration_in_days'] = Carbon::parse($item['from'])->diffInDays(Carbon::parse($item['to']));
                        return $item;
                    });

                    $jobExpInTotalDays = $jobExperiences->sum('exp_duration_in_days');
                    $exp = floor($jobExpInTotalDays / 365);

                    $item['matched'] = $exp >= $post->experience_min && $exp <= $post->experience_max;
                    $item['expected'] = $post->experience_min . ' - ' . $post->experience_max . ' year(s)';
                    $item['user_info'] = $exp;

                } elseif ($item->id == 4) {//4=salary
                    $salary = $request->expected_salary;

                    $item['matched'] = $salary <= $post->salary_max;
                    $item['expected'] = $post->salary_min . ' - ' . $post->salary_max . ' year(s)';
                    $item['user_info'] = $salary;

                } elseif ($item->id == 5) {//4=gender
                    $gender = $user->profile->gender;

                    $item['matched'] = in_array($gender->id, $post->postGenders->pluck('id')->toArray());
                    $item['expected'] = implode(', ', $post->postGenders->pluck('title')->toArray());
                    $item['user_info'] = $gender->title;

                } elseif ($item->id == 7) {//7=area of exp skills
                    $userSkills = $user->userSkills ?? collect([]);
                    $postSkills = $post->postAreaExperiences ?? collect([]);

                    $item['matched'] = array_diff($postSkills->pluck('id')->toArray(), $userSkills->pluck('id')->toArray()) == [];
                    $item['expected'] = implode(', ', $postSkills->pluck('title')->toArray());
                    $item['user_info'] = implode(', ', $userSkills->pluck('title')->toArray());
                } elseif ($item->id == 9) {//9=skills
                    $userSkills = $user->userSkills ?? collect([]);
                    $postSkills = $post->postSkills ?? collect([]);

                    $item['matched'] = array_diff($postSkills->pluck('id')->toArray(), $userSkills->pluck('id')->toArray()) == [];
                    $item['expected'] = implode(', ', $postSkills->pluck('title')->toArray());
                    $item['user_info'] = implode(', ', $userSkills->pluck('title')->toArray());
                }

                return $item;
            });

            $isMatchedAllCriteria = $mandatoryCriterias->every(function ($value, $key) {
                return $value->matched == true;
            });

            if (!$isMatchedAllCriteria) {
                return $this->errorResponse('Sorry You information didn\'t matched all criteria', $mandatoryCriterias);
            }
        }

        $prevRecordsCount = $post->applicants()->where('user_id', AuthService::getAuthUserId())->count();
        if ($prevRecordsCount > 0) {
            return $this->errorResponse('You already applied.');
        }

        try {
            $post->applicants()->create([
                'user_id' => AuthService::getAuthUserId(),
                'expected_salary' => $request->expected_salary,
                'status' => 0
            ]);

            return $this->successResponse('Application submitted successfully');

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function categoryJobSummary(Request $request)
    {
        $categories = Category::select('categories.id', 'categories.category_type_id', 'categories.title_en', 'categories.tag_id',
            DB::raw("COUNT(posts.category_id) AS job_count"))
            ->leftJoin('posts', function ($join) use ($request) {
                $join->on('posts.category_id', 'categories.id');

                if ($request->post_within) {
                    $join->whereDate('posts.created_at', Carbon::now()->toDateString());
                } elseif ($request->deadline) {
                    $join->whereDate('deadline', Carbon::now()->addDay()->toDateString());
                } elseif ($request->job_nature) {
                    $join->join('post_nature', function ($join) use ($request) {
                        $join->on('post_nature.post_id', 'posts.id')->where('post_nature.job_nature_id', $request->job_nature);;
                    });
                }
            })
            ->groupBy('categories.id')
            ->get()
            ->groupBy('category_type_id');

        $data['categories_functional'] = @$categories[1] ? collect($categories[1])->where('tag_id', 1) : [];
        $data['categories_industrial'] = @$categories[1] ? collect($categories[1])->where('tag_id', 2) : [];
        $data['categories_special_skilled'] = @$categories[2] ?? [];

        $data['category_types'] = [
            ['id' => 1, 'title' => 'Functional Category'],
            ['id' => 2, 'title' => 'Industrial Category'],
            ['id' => 3, 'title' => 'স্পেশাল স্কিল্‌ড বিভাগ'],
        ];

        $totalRecords = collect($data['categories_functional'])->sum('job_count') + collect($data['categories_industrial'])->sum('job_count') + collect($data['categories_special_skilled'])->sum('job_count');

        $title = "Jobs";
        if ($request->has('post_within')) {
            $title = "New " . $title;
        } else if ($request->has('deadline')) {
            $title = "Deadline Tomorrow " . $title;
        } else if ($request->has('job_nature')) {
            $title = "Contractual " . $title;
        }

        $params = $request->all();

        return view('pages.jobList.index-category-summary', compact('data', 'totalRecords', 'title', 'params'));
    }

    public function example($fileName)
    {
        return view('pages/' . $fileName);
    }

    private function getAds($page = 'LANDING')
    {
        return Ad::select('id', 'position_id', 'image', 'url')
            ->where('page', $page)
            ->where('status', 1)
            ->orderBy('view_order', 'asc')
            ->inRandomOrder()
            ->get()
            ->groupBy('position_id');
    }
}
