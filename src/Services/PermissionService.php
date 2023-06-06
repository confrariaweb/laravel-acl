<?php

namespace ConfrariaWeb\Acl\Services;

use App\Exceptions\NotFoundException;
use ConfrariaWeb\Acl\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionService
{

    protected $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function all()
    {
        return $this->permission->all();
    }

    public function paginate($perPage = 15)
    {
        return $this->permission->paginate($perPage);
    }

    public function find($id)
    {
        return $this->permission->find($id);
    }
    
    public function create(array $data): Permission
    {
        try {
            DB::beginTransaction();

            $permission = Permission::create($data);

            DB::commit();

            return $permission;
        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    public function update(int $id, array $data): Permission
    {
        try {
            DB::beginTransaction();

            $permission = $this->find($id);
            abort_unless($permission, 404, 'Role not found');
            $permission->update($data);

            DB::commit();

            return $permission;
        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }

    public function delete(int $id): bool
    {
        try {
            DB::beginTransaction();

            $permission = $this->find($id);
            abort_unless($permission, 404, 'Permission not found');
            $permission->delete();

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    public function attachToRoles(int $permissionId, array $roleIds): Permission
    {
        try {
            DB::beginTransaction();

            $permission = $this->find($permissionId);

            $permission->roles()->sync($roleIds);

            DB::commit();

            return $permission;
        } catch (\Exception $exception) {
            DB::rollBack();

            throw $exception;
        }
    }
}
