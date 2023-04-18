<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OauthAccessToken;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OauthTokenControl extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $currentTokenId = AuthService::getCurrentTokenId(AuthService::getAuthToken($request));

        $data = OauthAccessToken::select('id', 'ip_address', 'json_data', 'device_type', 'created_at', 'expires_at')
            ->whereUserId(Auth::id())
            ->where('revoked', 0)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->map
            ->format($currentTokenId);

        return $this->response($data, 'Auth token list');
    }

    public function destroy(Request $request, $id)
    {
        $currentTokenId = AuthService::getCurrentTokenId(AuthService::getAuthToken($request));

        $token = OauthAccessToken::whereUserId(Auth::user()->id)
            ->with('oauthRefreshToken')
            ->findOrFail($id)
            ->format($currentTokenId);

        if ($token->current_token) {
            return $this->errorResponse('Current token can\'t be deleted!');
        }

        try {
            DB::beginTransaction();

            if ($token->oauthRefreshToken) {
                $token->oauthRefreshToken->delete();
            }
            $token->delete();

            DB::commit();
            return $this->successResponse('Token deleted successfully');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse();
        }
    }

    public function signOutFormAllDevices(Request $request)
    {
        try {
            DB::beginTransaction();

            $tokens = OauthAccessToken::whereUserId(Auth::user()->id)
                ->where('revoked', 0)
                ->with('oauthRefreshToken')
                ->get();

            foreach ($tokens as $token) {
                $token->oauthRefreshToken->delete();
                $token->delete();
            }

            DB::commit();
            return $this->successResponse('You have successfully logged out from all devices');

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->exception($e);
        }
    }
}
