<?php

namespace App\Http\Controllers\Home;

use App\Filters\Home\CourseFilters;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\TrainingCategory;
use App\Services\CommonService;
use App\Services\HelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingCoursesController extends Controller
{
    public function index(Request $request, CourseFilters $filters)
    {
        $records = Course::with('trainer')
            ->filter($filters)
            ->orderBy('created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit(10));

        $totalRecords = $records->total();

        if ($request->ajax()) {
            $html = view('pages.trainings.content', compact('records'))->render();

            return compact('html', 'totalRecords');
        }

        $categories = TrainingCategory::select('training_categories.id', 'training_categories.title',
            DB::raw("COUNT(course_category.id) AS course_count"))
            ->leftJoin('course_category', 'course_category.training_category_id', 'training_categories.id')
            ->groupBy('training_categories.id')
            ->get();

        $data['course_categories'] = CommonService::trainingCategories();
        $data['course_category_summary'] = $categories;

        return view('pages.trainings.index', compact('records', 'data', 'totalRecords'));
    }

    public function show($id)
    {
        $course = Course::with('trainer', 'trainingType', 'courseCategories')->findOrFail($id);

        $relatedCatIds = $course->courseCategories->pluck('id')->toArray();

        $relatedCourses = Course::whereHas('courseCategories', function ($q) use ($relatedCatIds) {
            $q->whereIn('training_category_id', $relatedCatIds);
        })
            ->with('courseCategories')
            ->with('trainer')
            ->where('id', '!=', $course->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('pages.trainings.show', compact('course', 'relatedCourses'));
    }

    public function courseList(Request  $request, CourseFilters $filters)
    {
        $records = Course::with('courseCategories')
            ->with('trainer')
            ->filter($filters)
            ->paginate(HelperService::getMAxItemLimit(12));

        $totalRecords = $records->total();

        if ($request->ajax()) {
            $html = view('pages.trainings.course-list-content', compact('records'))->render();

            return compact('html', 'totalRecords');
        }

        $data = [
            'industry_types' => CommonService::industryTypes(),
            'course_category' => CommonService::trainingCategories(),
            'course_types' => CommonService::trainingTypes(),
        ];

        return view('pages.trainings.course-list', compact('records', 'data', 'totalRecords'));
    }
}
