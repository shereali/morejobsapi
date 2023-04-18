<?php

namespace App\Http\Controllers\Admin;

use App\Filters\PostFilters;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\JobListingType;
use App\Models\Post;
use App\Services\CommonService;
use App\Services\FileHandleService;
use App\Services\HelperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function initiateListSummary()
    {
        $summary = Post::select(
            DB::raw("COUNT(CASE WHEN status = 1 THEN 1 END) AS pending"),
            DB::raw("COUNT(CASE WHEN status = 2 THEN 1 END) AS published"),
            DB::raw("COUNT(CASE WHEN status = 3 THEN 1 END) AS archived"))
            ->first();

        return $this->response([
            'summary' => $summary,
            'initial_data' => [
                'organization_types' => CommonService::organizationTypes()
            ]
        ], 'posr list summary');
    }

    public function index(PostFilters $filters)
    {
        $data = Post::with('category', 'company.organizationType')
            ->where('status', '>', 0)
            ->filter($filters)
            ->orderBy('created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit(50));

        return $this->response($data, 'Post list for admin');
    }

    public function show($id)
    {
        $post = Post::with('category', 'serviceType')
            ->with('postNatures', 'postAreas.parent')
            ->with('postLevels', 'postWorkspaces')
            ->with('postDegrees', 'postInstitutes', 'postTrainings', 'postCertificates', 'postAreaExperiences', 'postGenders', 'postSkills')
            ->with('postCompanyIndustryTypes', 'postIndustryTypes')
            ->with('postMatchingCriteria')
            ->with('company')
            ->findOrFail($id);

        return $this->response($post, 'Post details for admin');
    }

    public function create()
    {
        $data['listing_types'] = JobListingType::select('id', 'title')->where('id', '!=', 1)->get();;
        $data['companies'] = Company::select('id', 'title_en', 'title_bn', 'organization_type_id')->whereStatus(1)->get();;
        $data['categories'] = CommonService::jobCategories();

        return $this->response($data, 'Admin job post listing types');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'id'=> 'nullable',
            'title' => 'required|string',
            'category_id' => 'required|integer',
            'job_listing_type_id' => 'required_if:id,null|integer',
            'company_id' => 'required|integer',
            'file' => 'required_if:id,null|file',
            'source' => 'required_if:id,null',
            'publish_date' => 'required_if:id,null|date',
            'deadline' => 'required|date|after:publish_date',
        ]);

        $company = Company::whereStatus(1)->findOrFail($request->company_id);

        try {
            DB::beginTransaction();

            if ($request->id) {
                $post = Post::findOrFail($request->id);

                $path = null;
                if ($request->has('file') && $request->file) {
                    FileHandleService::delete($post->image);
                    $path = FileHandleService::upload($request->file, FileHandleService::getCompanyPath($company->id) . '/posts');
                }

                $post->fill($request->except('file', 'id'));
                if ($path) {
                    $post->image = $path;
                }
                $post->save();

                $message = 'Post updated successfully';

            } else {
                $path = FileHandleService::upload($request->file, FileHandleService::getCompanyPath($company->id) . '/posts');

                $post = Post::create($request->except('file', 'id') + [
                        'company_name' => $company->title_en,
                        'image' => $path,
                        'status' => 2,
                    ]);

                $message = 'Post created successfully';
            }


            DB::commit();

            return $this->successResponse($message, $post);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $this->validate($request, [
            'status' => 'required|integer|in:1,2,3'
        ]);

        $post = Post::findOrFail($id);

        try {
            $post->fill($request->only('status'));
            $post->save();

            return $this->successResponse('Post status changed successfully', $post);

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }
}
