<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Filters\Admin\IndustryTypeFilters;
use App\Http\Controllers\Controller;
use App\Models\IndustryType;
use App\Services\HelperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndustryTypeController extends Controller
{
    public function initiateFilters()
    {
        return $this->response([
            'parents' => IndustryType::whereNull('parent_id')->get(),
        ], 'Initiate filters');
    }

    public function index(IndustryTypeFilters $filters): JsonResponse
    {
        $data = IndustryType::withCount('subIndustryTypes')->whereNull('parent_id')
            ->filter($filters)
            ->latest()
            ->paginate(HelperService::getMAxItemLimit());

        return $this->response($data, 'Industry type list');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title_en' => $request->id ? 'required|unique:industry_types,title_en,' . $request->id : 'required|unique:industry_types',
            'title_bn' => $request->id ? 'required|unique:industry_types,title_bn,' . $request->id : 'required|unique:industry_types',
            'sub_industry_types' => 'required|array|min:1',
            'sub_industry_types.*.title_en' => 'required',
            'sub_industry_types.*.title_bn' => 'required',
        ]);

        try {
            DB::beginTransaction();

            if ($request->id) {
                $industryType = IndustryType::with('subIndustryTypes')->findOrFail($request->id);
                $industryType->fill($request->only('title_en', 'title_bn'))->save();

                $new = collect($request->sub_industry_types)->where('id', null);
                $updated = collect($request->sub_industry_types)->where('id', '!=', null)->filter();
                $exists = $industryType->subIndustryTypes->pluck('id')->toArray();
                $deleted = array_diff($exists, $updated->pluck('id')->toArray());

                $industryType->subIndustryTypes()->createMany($new);
                $industryType->subIndustryTypes()->upsert($updated->toArray(), ['title_en', 'title_bn']);
                $industryType->subIndustryTypes()->whereIn('id', $deleted)->delete();

                $message = 'Industry type updated successfully';
            } else {
                $industryType = IndustryType::create($request->only('title_en', 'title_bn'));
                $industryType->subIndustryTypes()->createMany($request->sub_industry_types);

                $message = 'Industry type created successfully';
            }

            DB::commit();
            return $this->successResponse($message, $industryType);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    public function edit($id)
    {
        $industryType = IndustryType::with('subIndustryTypes')->findOrFail($id);

        return $this->response($industryType, "Industry edit initiate");
    }

    public function destroy($id): JsonResponse
    {
        $data = IndustryType::with('subIndustryTypes')->findOrFail($id);

        try {
            DB::beginTransaction();

            $data->subIndustryTypes()->delete();
            $data->delete();

            DB::commit();
            return $this->successResponse('Industry & its sub-industry types has been deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse("Already used can\t be deleted");
        }
    }
}
