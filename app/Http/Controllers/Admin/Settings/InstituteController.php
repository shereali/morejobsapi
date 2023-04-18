<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Filters\InstituteFilters;
use App\Http\Controllers\Controller;
use App\Models\Institute;
use App\Models\Skill;
use App\Services\HelperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstituteController extends Controller
{
    public function index(InstituteFilters $filters): JsonResponse
    {
        $data = Institute::select('id', 'title', 'updated_at')
            ->filter($filters)
            ->latest()
            ->paginate(HelperService::getMAxItemLimit());

        return $this->response($data, 'Institute list');
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'title' => $request->id ? 'required|unique:institutes,title,' . $request->id : 'required|unique:institutes',
        ]);

        try {
            if ($request->id) {
                $skill = Institute::findOrFail($request->id);
                $skill->fill($request->only('title'))->save();

                $message = 'Institute updated successfully';
            } else {
                $skill = Institute::create($request->all());

                $message = 'Institute created successfully';
            }

            return $this->successResponse($message, $skill);

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }


    public function show($id): JsonResponse
    {
        $data = Institute::select('id', 'title', 'updated_at')->findOrFail($id);

        return $this->response($data, 'Institute details');
    }


    public function destroy($id): JsonResponse
    {
        $data = Institute::findOrFail($id);

        try {
            $data->delete();
            return $this->successResponse('Institute has been deleted successfully');

        } catch (\Exception $e) {
            return $this->errorResponse("Already used can\t be deleted");
        }
    }
}
