<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;
class AuthOfferController extends Controller
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

            $is_username = $offer = Offer::where('username', $request->username)->first();

            if ($is_username && $offer->password == $request->password) {

                $token = $offer->createToken('authToken')->plainTextToken;

                $data['token'] = $token;
                $data['info'] = $offer;

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
