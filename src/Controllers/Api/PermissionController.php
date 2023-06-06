<?php

namespace ConfrariaWeb\Acl\Controllers\Api;

use App\Http\Controllers\Controller;
use ConfrariaWeb\Acl\Requests\PermissionRequest;
use ConfrariaWeb\Acl\Requests\PermissionStoreRequest;
use ConfrariaWeb\Acl\Requests\PermissionUpdateRequest;
use ConfrariaWeb\Acl\Resources\PermissionResource;
use ConfrariaWeb\Acl\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    protected $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        try {
            $permissions = $this->service->all();
            return PermissionResource::collection($permissions);
            //return response()->json(['data' => $permissions], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function store(PermissionStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $permission = $this->service->create($request->all());
            DB::commit();
            //return response()->json(['data' => $permission], Response::HTTP_CREATED);
            return new PermissionResource($permission);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function show($id)
    {
        try {
            $permission = $this->service->find($id);
            //return response()->json(['data' => $permission], Response::HTTP_OK);
            return new PermissionResource($permission);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(PermissionUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $permission = $this->service->update($id, $request->all());
            DB::commit();
            //return response()->json(['data' => $permission], Response::HTTP_OK);
            return new PermissionResource($permission);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->service->delete($id);
            DB::commit();
            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
