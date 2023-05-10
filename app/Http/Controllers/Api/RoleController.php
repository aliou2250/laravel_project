<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Exception;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return RoleResource::collection(Role::paginate(10));
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
    public function store(RoleRequest $request)
    {
        //
        try {
            $role = Role::create($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Role created successfully.',
                'role' => new RoleResource($role),
            ], 201);
        } catch (Exception $e) {
            //throw $e;
            return response()->json([
                'status' => 'error',
                'message' => 'Role creation failed.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
        return new RoleResource($role);
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
    public function update(RoleRequest $request, Role $role)
    {
        //
        try {
            $role->update($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Role updated successfully.',
                'role' => new RoleResource($role),
            ], 200);
        } catch (Exception $e) {
            //throw $e;
            return response()->json([
                'status' => 'error',
                'message' => 'Role update failed.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
        try {
            $role->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Role deleted successfully.',
            ], 200);
        } catch (Exception $e) {
            //throw $e;
            return response()->json([
                'status' => 'error',
                'message' => 'Role deletion failed.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }
}
