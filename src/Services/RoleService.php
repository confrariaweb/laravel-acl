<?php

namespace ConfrariaWeb\Acl\Services;

use ConfrariaWeb\Acl\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class RoleService
{
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }

    public function all()
    {
        return $this->role->all();
    }

    public function pluck($value = 'name', $key = 'id')
    {
        return $this->role->pluck($value, $key);
    }

    public function paginate($perpage = 15)
    {
        return $this->role->paginate($perpage);
    }

    public function find($id)
    {
        try {
            return $this->role->find($id);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function create(array $data, array $permissions)
    {
        DB::beginTransaction();
        try {
            //dd($data, $permissions);
            $role = $this->role->create($data);
            if (!empty($permissions)) {
                $role->permissions()->sync($permissions);
            }
            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new \Exception('Erro ao criar nova role.');
        }
    }

    public function update($id, array $data, array $permissions)
    {
        DB::beginTransaction();
        try {
            $role = $this->role->find($id);
            abort_unless($role, 404, 'Role not found');
            $role->update($data);
            if (empty($permissions)) {
                $role->permissions()->detach();
            }else{
                $role->permissions()->sync($permissions);
            }
            DB::commit();
            return $role;
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $role = $this->role->find($id);
            abort_unless($role, 404, 'Role not found');
            $role->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }
}
