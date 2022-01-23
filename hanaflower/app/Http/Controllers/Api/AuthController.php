<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except(['register', 'login']);
    }
    /**
     * register
     *
     * @param mixed $request
     * @return void
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers',
            'password' => 'required|confirmed',
            'province' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $customer = Customer::create([
            'nama' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'province_id' => $request->province,
            'city_id' => $request->city,
            'address' => $request->address
        ]);

        $token = JWTAuth::fromUser($customer);

        if ($customer) {
            return response()->json([
                'success' => true,
                'user' => $customer,
                'token' => $token
            ], 201);
        }
        return response()->json([
            'success' => false,
        ], 409);
    }
    /**
     * login
     *
     * @param mixed $request
     * @return void
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        // if (!$token = auth() -> attempt($credentials)) {
        if (!$token = auth()->guard('api')->attempt($validator->validated())) {
            return response()->json([
                'success' => false,
                'message' => 'Email or Password is incorrect'
            ], 401);
        }

        // return $this->respondWithToken($token);

        return response()->json([
            'success' => true,
            'user' => auth()->guard('api')->user(),
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ], 201);
    }
    /**
     * getUser
     *
     * @return void
     */
    public function getUser()
    {
        return response()->json([
            'success' => true,
            'user' => auth()->user()
        ], 200);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout'
        ], 200);
    }
}
