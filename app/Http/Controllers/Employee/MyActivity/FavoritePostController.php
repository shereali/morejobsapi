<?php

namespace App\Http\Controllers\Employee\MyActivity;

use App\Filters\Employees\FavoritePostFilters;
use App\Http\Controllers\Controller;
use App\Models\UserFavPost;
use App\Services\AuthService;
use App\Services\HelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoritePostController extends Controller
{
    public function index(FavoritePostFilters $filters)
    {
        $data = UserFavPost::with('post.company')
            ->whereUserId(AuthService::getAuthUserId())
            ->filter($filters)
            ->orderBy('created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit());

        return $this->response($data, 'Employee favorite posts');
    }

    public function jobShortlist($id)
    {
        $user = AuthService::getAuthUser();
        if ($user->getAttributes()['user_type'] != 2) {
            return $this->errorResponse('Forbidden action. Only employee can shortlist jobs');
        }

        try {
            $data = UserFavPost::whereUserId($user->id)->wherePostId($id)->first();
            if ($data) {
                $data->delete();

                $message = 'You have removed this job from shortlist';
            } else {
                $user->favPosts()->attach($id);

                $message = 'This job has been successfully shortlisted';
            }

            return $this->successResponse($message);

        } catch (\Exception $e) {
            return $this->exception($e);
        }

    }

    public function destroy(Request $request)
    {
        $this->validate($request, [
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer',
        ]);

        try {
            DB::beginTransaction();

            UserFavPost::whereUserId(AuthService::getAuthUserId())->whereIn('id', $request->ids)->delete();

            DB::commit();
            return $this->successResponse('Favorite post removed successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }
}
