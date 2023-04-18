<?php

namespace App\Http\Controllers\Admin\Settings;

use App\Filters\Admin\AreaFilters;
use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Services\CommonService;
use App\Services\HelperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AreaController extends Controller
{
    public function initiateFilters(): JsonResponse
    {
        return $this->response([
            'countries' => CommonService::countries(),
        ], 'areas initial filters');
    }

    public function index(Request $request, AreaFilters $filters): JsonResponse
    {
        try {
            $areas = Area::with('subAreas.subAreas.subAreas')
                ->whereNull('parent_id')
                ->filter($filters)
                ->when(!$request->country_id, function ($q) {
                    $q->whereCountryId(1);
                })
                ->orderBy('title_en', 'ASC')
                ->paginate(HelperService::getMAxItemLimit());

            return $this->response($areas, 'Area list');
        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title_en' => 'required|string',
            'title_bn' => 'required|string',
            'mode' => 'required|string|in:create,edit,add_sub_area',
            'country_id' => 'required_if:mode,create',
            'id' => 'required_unless:mode,create',
        ]);

        try {
            $msg = $data = null;
            $slug = Str::slug($request->title_en);

            if ($request->mode == 'create') {
                $data = Area::create($request->only('title_en', 'title_bn', 'country_id') + [
                        'slug' => $slug,
                        'level' => 0,
                    ]);

                $msg = 'Division created successfully';

            } else {
                $area = Area::findOrFail($request->id);

                if ($request->mode == 'edit') {
                    $data = $area->fill($request->only('title_en', 'title_bn'))->save();
                    $msg = 'Area updated successfully';

                } elseif ($request->mode == 'add_sub_area') {
                    $data = Area::create($request->only('title_en', 'title_bn') + [
                            'parent_id' => $area->id,
                            'country_id' => $area->country_id,
                            'slug' => $slug,
                            'level' => $area->level + 1,
                        ]);

                    $msg = 'Sub area added successfully';
                }
            }

            return $this->successResponse($msg, $data);

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function destroy($id)
    {
        $area = Area::findOrFail($id);

        try {
            $area->delete();

            if ($area->level == 0) {
                return $this->successResponse('Area has been deleted successfully!');
            } else {
                return $this->successResponse('Area & related data has been deleted successfully!');
            }

        } catch (\Exception $e) {
            return $this->errorResponse('Already used can\'t delete it');
        }
    }
}
