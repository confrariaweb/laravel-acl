<?php

namespace ConfrariaWeb\Acl\Controllers\Api;

use App\Models\User;
use ConfrariaWeb\Acl\Requests\RoleStoreRequest;
use ConfrariaWeb\Acl\Requests\RoleUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use ConfrariaWeb\Acl\Services\RoleService;
use ConfrariaWeb\Acl\Resources\RoleResource;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct(RoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function index()
    {
        try {
            $roles = $this->roleService->all();
            return RoleResource::collection($roles);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Error creating permission'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(RoleStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $role = $this->roleService->create($request->all(), $request->permissions?? []);
            DB::commit();
            return new RoleResource($role);
        } catch (QueryException $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Error creating permission'
            ], 500);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $role = $this->roleService->find($id);
            return new RoleResource($role);
        } catch (QueryException $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Error creating permission'
            ], 500);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Permission not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            $role = $this->roleService->update($id, $request->all(), $request->permissions?? []);
            DB::commit();
            return new RoleResource($role);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Permission not found'
            ], 404);
        } catch (QueryException $e) {
            return response()->json([
                'error' => 'Error updating permission'
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $this->roleService->delete($id);
            DB::commit();
            return response()->json(['message' => 'Role deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Permission not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
