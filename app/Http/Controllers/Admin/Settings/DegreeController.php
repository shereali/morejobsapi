<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Filters\DegreeFilters;
use App\Http\Controllers\Controller;
use App\Models\Degree;
use App\Models\EducationLevel;
use App\Services\CommonService;
use App\Services\HelperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DegreeController extends Controller
{
    public function initiateFilters()
    {
        return $this->response([
            'education_levels' => CommonService::educationLevels(),
        ], 'Initiate filters');
    }

    public function index(DegreeFilters $filters): JsonResponse
    {
        $data = Degree::with('educationLevel')
            ->filter($filters)
            ->latest()
            ->paginate(HelperService::getMAxItemLimit());

        return $this->response($data, 'Degree list');
    }

    public function create(): JsonResponse
    {
        $educationLevels = EducationLevel::select('id', 'title')->orderBy('view_order', 'ASC')->get();

        return $this->response([
            'education_levels' => $educationLevels
        ], 'Degree initial data for create/edit');
    }


    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'title' => $request->id ? 'required|unique:degrees,title,' . $request->id : 'required|unique:degrees',
            'education_level_id' => 'required|integer',
        ]);

        try {
            if ($request->id) {
                $degree = Degree::findOrFail($request->id);
                $degree->fill($request->except('id'))->save();
                $message = 'Degree updated successfully';
            } else {
                $degree = Degree::create($request->all());
                $message = 'Degree created successfully';
            }

            $degree->load('educationLevel');

            return $this->successResponse($message, $degree);

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }


    public function show($id): JsonResponse
    {
        $data = Degree::select('id', 'title', 'education_level_id', 'updated_at')
            ->with('educationLevel')
            ->findOrFail($id);

        return $this->response($data, 'Degree details');
    }


    public function destroy($id): JsonResponse
    {
        $data = Degree::findOrFail($id);

        try {
            $data->delete();
            return $this->successResponse('Degree has been deleted successfully');

        } catch (\Exception $e) {
            return $this->errorResponse("Already used can\t be deleted");
        }
    }

    public function sort(Request $request): JsonResponse
    {
        try {
            foreach ($request->all() as $index => $value) {
                $data = Degree::find($value['id']);
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
