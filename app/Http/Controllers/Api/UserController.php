<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EditUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return UserResource::collection(User::paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        //
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role_id = $request->role_id;
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'User created successfully.',
                'user' => new UserResource($user),
            ], 201);
        } catch (Exception $e) {
            //throw $e;
            return response()->json([
                'status' => 'error',
                'message' => 'User creation failed.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return new UserResource($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditUserRequest $request, User $user)
    {
        //
        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = $request->role_id;
            $user->update();

            return response()->json([
                'status' => 'success',
                'message' => 'User updated successfully.',
                'user' => new UserResource($user),
            ], 200);
        } catch (Exception $e) {
            //throw $e;
            return response()->json([
                'status' => 'error',
                'message' => 'User update failed.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
        try {
            $user->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'User deleted successfully.',
            ], 200);
        } catch (Exception $e) {
            //throw $e;
            return response()->json([
                'status' => 'error',
                'message' => 'User deletion failed.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (! $user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found.',
                ], 404);
            }
            if (! auth()->attempt($request->only('email', 'password'))) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid login credentials.',
                ], 401);
            }
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully.',
                'token' => $token,
            ], 200);
        } catch (Exception $e) {
            //throw $e;
            return response()->json([
                'status' => 'error',
                'message' => 'User login failed.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }
}
