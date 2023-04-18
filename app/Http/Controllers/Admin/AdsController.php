<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdsPage;
use App\Models\AdsPosition;
use App\Services\FileHandleService;
use App\Services\HelperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdsController extends Controller
{
    public function index()
    {
        $data = Ad::with('position')
            ->orderBy('view_order', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit(50));

        return $this->response($data, 'Ads list');
    }


    public function create()
    {
        $data['positions'] = AdsPosition::select('id', 'title', 'key')->get();

        $pagesData = AdsPage::select('id', 'title', 'key', 'ad_position_id')->get()->groupBy('key');
        $adsPages = [];
        foreach ($pagesData as $key => $page) {
            array_push($adsPages, [
                'title' => @collect($page)->first()->title,
                'key' => $key,
                'position_ids' => $page->pluck('ad_position_id')->values()->toArray()
            ]);
        }

        $data['pages'] = $adsPages;

        return $this->response($data, 'Ads create initiate');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'position_id' => 'required|',
            'file' => 'required_if:id,null|file',
        ]);

        try {
            DB::beginTransaction();

            if ($request->id) {
                $ads = Ad::findOrFail($request->id);
                $ads->fill($request->except('id'));

                if ($request->has('file') && $request->file) {
                    FileHandleService::delete($ads->image);
                    $ads->image = FileHandleService::upload($request->file, FileHandleService::getAdsStoragePath());
                }

                $ads->save();

                $message = "Ads  updated successfully";
            } else {
                $path = FileHandleService::upload($request->file, FileHandleService::getAdsStoragePath());

                $ads = Ad::create($request->except('id') + [
                        'image' => $path
                    ]);
                $message = "Ads created successfully";
            }

            DB::commit();
            return $this->successResponse($message, $ads);

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'status' => 'required|integer|in:0,1'
        ]);

        $ads = Ad::findOrFail($id);

        try {
            $ads->fill($request->only('status'));
            $ads->save();

            return $this->successResponse('Ads status changed successfully', $ads);

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }


    public function destroy($id): JsonResponse
    {
        $data = Ad::findOrFail($id);

        try {
            $data->delete();
            return $this->successResponse('Ads has been deleted successfully!');

        } catch (\Exception $e) {
            return $this->errorResponse('Already used can\'t be deleted');
        }
    }
}
