<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Filters\SkillFilters;
use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Services\HelperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index(SkillFilters $filters): JsonResponse
    {
        $data = Skill::select('id', 'title', 'updated_at')
            ->filter($filters)
            ->orderBy('created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit(50));

        return $this->response($data, 'Skill list');
    }

    public function store(Request $request): JsonResponse
    {
        $this->validate($request, [
            'title' => $request->id ? 'required|unique:skills,title,' . $request->id : 'required|unique:skills',
        ]);

        try {
            if ($request->id) {
                $skill = Skill::findOrFail($request->id);
                $skill->fill($request->only('title'))->save();

                $message = 'Skill updated successfully';
            } else {
                $skill = Skill::create($request->all());

                $message = 'Skill created successfully';
            }

            return $this->successResponse($message, $skill);

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }


    public function show($id): JsonResponse
    {
        $data = Skill::select('id', 'title', 'updated_at')->findOrFail($id);

        return $this->response($data, 'Skill details');
    }


    public function destroy($id): JsonResponse
    {
        $data = Skill::findOrFail($id);

        try {
            $data->delete();
            return $this->successResponse('Skill has been deleted successfully');

        } catch (\Exception $e) {
            return $this->errorResponse("Already used can\t be deleted");
        }
    }
}
