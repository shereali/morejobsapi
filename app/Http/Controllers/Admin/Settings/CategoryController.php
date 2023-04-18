<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Filters\CategoryFilters;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CommonService;
use App\Services\HelperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function initiateFilters()
    {
        return $this->response([
            'category_types' => CommonService::jobCategoryTypes(),
            'tags' => CommonService::tags()
        ], 'Initiate filters');
    }

    public function index(CategoryFilters $filters): JsonResponse
    {
        $data = Category::withCount('posts')
            ->with('categoryType', 'tag')
            ->filter($filters)
            ->orderBy('created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit(50));

        return $this->response($data, 'Category list');
    }

    public function create()
    {
        return $this->response([
            'category_types' => CommonService::jobCategoryTypes(),
            'tags' => CommonService::tags()
        ], 'Initiate create');
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'title_en' => 'required',
            'title_bn' => 'required',
            'id' => 'sometimes:required'
        ]);

        $isPresent = Category::where(function ($q) use ($request) {
            $q->where('title_en', $request->title_en);
            $q->orWhere('title_bn', $request->title_bn);
        })->when($request->id, function ($q) use ($request) {
            $q->where('id', '!=', $request->id);
        })->exists();

        if ($isPresent) {
            return $this->errorResponse('The Category is already exists');
        }

        $request->request->add([
            'slug' => Str::slug(trim($request->title_en))
        ]);

        try {
            if ($request->id) {
                $category = Category::findOrFail($request->id);
                $category->fill($request->except('id'));
                $category->save();

                $message = "category updated successfully";
            } else {
                $category = Category::create($request->all());

                $message = "category created successfully";
            }

            return $this->successResponse($message, $category);

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $data = Category::with('creator', 'editor')->findOrFail($id);
            return $this->successResponse('Category info', $data);
        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function destroy($id): JsonResponse
    {
        $category = Category::withCount('posts')->findOrFail($id);

        if ($category->posts_count > 0) {
            return $this->errorResponse("This category can't be deleted as ($category->posts_count) resources using the category");
        }

        try {
            $category->delete();
            return $this->successResponse('Category has been deleted successfully!');
        } catch (\Exception $e) {
            return $this->errorResponse();
        }
    }

    public function sort(Request $request): JsonResponse
    {
        try {
            foreach ($request->all() as $index => $value) {
                $data = Category::find($value['id']);
                $data->timestamps = false;
                $data->view_order = $index;
                $data->save();
            }
            return $this->successResponse('Sorting done successfully');
        } catch (\Exception $e) {
            return $this->exception($e);
        }

    }
}
