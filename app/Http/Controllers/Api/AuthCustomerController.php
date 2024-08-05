<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\GeneralTrait;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthCustomerController extends Controller
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

            $is_username = $customer = Customer::where('username', $request->username)->first();

            if ($is_username && $customer->password == $request->password) {

                $token = $customer->createToken('authToken')->plainTextToken;

                $data['token'] = $token;
                $data['info'] = $customer;

                return $this->successResponse($data, 'you have been logged in successfully.');
            } else {
                return $this->errorResponse('Invalid username or password', 400);
            }
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }

    public function  register(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:255|unique:customers',
                'phone_number' => 'required|string|max:20|unique:customers',
                'gender' => 'required|in:male,female',
                'date' => 'required|date',
                'country' => 'required|string|max:255',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 422);
            }
            $customer =  Customer::create($request->all());
            $token = $customer->createToken('authToken')->plainTextToken;
            $data['token'] = $token;
            $data['info'] = $customer;

            return $this->successResponse($data, 'your account has been created successfully.');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return $this->successResponse([],'You  have been logged out successfully.');
    }
}


 //  auth('sanctum')->user()->tokens()->delete();
 // $request->user()->currentAccessToken()->delete();
 // $request->user()->tokens()->delete();
 // return $request->user();
 // return Auth::user();
