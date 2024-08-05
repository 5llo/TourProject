<?php

namespace App\Http\Controllers\Api;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designer;

class AuthDesignerController extends Controller
{
    use GeneralTrait;
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:10',
                'password' => 'required|string|max:8|min:4',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 422);
            }

            $is_username = $designer = Designer::where('username', $request->username)->first();

            if ($is_username && $designer->password == $request->password) {

                $token = $designer->createToken('authToken')->plainTextToken;

                $data['token'] = $token;
                $data['info'] = $designer;

                return $this->successResponse($data, 'you have been logged in successfully.');
            } else {
                return $this->errorResponse('Invalid username or password', 400);
            }
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->successResponse([], 'You  have been logged out successfully.');
    }
}
