<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\BlogFilters;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Services\FileHandleService;
use App\Services\HelperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index(Request $request, BlogFilters $filters): JsonResponse
    {
        $data = Blog::filter($filters)->orderBy('created_at', 'DESC')->paginate(HelperService::getMAxItemLimit());

        return $this->response($data, 'Blog list');
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'subtitle' => 'required',
            'description' => 'required',
            'blog_type' => 'required|string',
        ]);

        if ($request->blog_type == 'articles') {
            $this->validate($request, [
                'file' => 'file',
            ]);
        } else {
            $this->validate($request, [
                'file' => 'required_if:id,null|file',
            ]);
        }


        try {
            DB::beginTransaction();

            if ($request->id) {
                $blog = Blog::findOrFail($request->id);
                $blog->fill($request->except('id'));

                if ($request->has('file') && $request->file) {
                    FileHandleService::delete($blog->cover_image);
                    $blog->cover_image = FileHandleService::upload($request->file, FileHandleService::getBlogStoragePath());
                }

                $blog->save();

                $message = "Blog  updated successfully";
            } else {
                $path = null;
                if ($request->has('file') && $request->file) {
                    $path = FileHandleService::upload($request->file, FileHandleService::getBlogStoragePath());
                }

                $map = ['admissions' => 1, 'events' => 2, 'scholarships' => 3, 'articles' => 4];

                $blog = Blog::create($request->except('id', 'blog_type') + [
                        'type' => @$map[$request->blog_type],
                        'cover_image' => $path
                    ]);
                $message = "Blog created successfully";
            }

            DB::commit();
            return $this->successResponse($message, $blog);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }

    public function destroy($id): JsonResponse
    {
        $data = Blog::findOrFail($id);

        try {
            $data->delete();
            return $this->successResponse('Blog has been deleted successfully!');

        } catch (\Exception $e) {
            return $this->errorResponse('Already used can\'t be deleted');
        }
    }
}
