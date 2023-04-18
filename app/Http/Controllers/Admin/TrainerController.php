<?php

namespace App\Http\Controllers\Admin;

use App\Events\AuthEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Category;
use App\Models\Trainer;
use App\Models\User;
use App\Services\AccountService;
use App\Services\HelperService;
use App\Services\StaticValueService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TrainerController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Trainer::orderBy('created_at', 'DESC')
            ->paginate(HelperService::getMAxItemLimit(20));

        return $this->response($data, 'Trainer list');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'designation' => 'required',
            'about' => 'required',
        ]);

        $isPresent = Trainer::where(function ($q) use ($request) {
            $q->where('first_name', $request->first_name);
            $q->where('last_name', $request->last_name);
        })->when($request->id, function ($q) use ($request) {
            $q->where('id', '!=', $request->id);
        })->exists();

        if ($isPresent) {
            return $this->errorResponse('The trainer is already exists');
        }

        try {
            if ($request->id) {
                $trainer = Trainer::findOrFail($request->id);
                $trainer->fill($request->except('id'));
                $trainer->save();

                $message = "Trainer updated successfully";
            } else {
                $trainer = Trainer::create($request->all());

                $message = "Trainer created successfully";
            }

            return $this->successResponse($message, $trainer);

        } catch (\Exception $e) {
            return $this->exception($e);
        }
    }

    public function destroy($id): JsonResponse
    {
        $trainer = Trainer::findOrFail($id);

        try {
            $trainer->delete();
            return $this->successResponse('Trainer has been deleted successfully!');

        } catch (\Exception $e) {
            return $this->errorResponse('Already used can\'t be deleted');
        }
    }
}
