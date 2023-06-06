<?php

namespace ConfrariaWeb\Acl\Databases\Seeds;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [];
        
        $packages = ['users', 'roles', 'permissions'];
        $actions = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];
        
        foreach($packages as $package){
            foreach($actions as $action){
                $permissions[] = [
                    'slug' => $package . '-' . $action,
                    'name' => $action . ' ' . $package,
                    'description' => $action . ' ' . $package,
                ];
            }
        }

        foreach ($permissions as $permission) {
            if (DB::table('acl_permissions')->where('slug', $permission['slug'])->doesntExist()) {
                DB::table('acl_permissions')->insert($permission);
            }
        }
    }

}
