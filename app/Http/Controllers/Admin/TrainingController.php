<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Trainer;
use App\Services\CommonService;
use App\Services\HelperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Course::with('trainer', 'trainingType', 'courseCategories')
            ->orderBy('created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit());

        return $this->response($data, 'Course list');
    }

    public function create()
    {
        $data['trainers'] = Trainer::get();
        $data['training_types'] = CommonService::trainingTypes();
        $data['training_categories'] = CommonService::trainingCategories();

        return $this->response($data, 'Initiate create/edit training');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'deadline' => 'required|date',
            'price' => 'required|numeric',

            'training_type_id' => 'required|integer',
            'trainer_id' => 'required|integer',
            'training_categories' => 'required|array|min:1',
        ]);


        try {
            DB::beginTransaction();

            if ($request->id) {
                $training = Course::findOrFail($request->id);
                $training->fill($request->except('id', 'training_categories'));
                $training->save();

                $training->courseCategories()->sync(collect($request->training_categories)->pluck('id')->toArray());
                $message = "Course updated successfully";
            } else {
                $training = Course::create($request->except('id', 'training_categories'));
                $training->courseCategories()->attach(collect($request->training_categories)->pluck('id')->toArray());
                $message = "Course created successfully";
            }

            DB::commit();
            return $this->successResponse($message, $training);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }

    public function destroy($id): JsonResponse
    {
        $data = Course::findOrFail($id);

        try {
            $data->delete();
            return $this->successResponse('Training course has been deleted successfully!');

        } catch (\Exception $e) {
            return $this->errorResponse('Already used can\'t be deleted');
        }
    }
}
