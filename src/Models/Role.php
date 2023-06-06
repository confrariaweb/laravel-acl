<?php

namespace ConfrariaWeb\Acl\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    protected $table = 'acl_roles';

    protected $fillable = [
        'slug',
        'name',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'acl_role_user');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'acl_permission_role');
    }
}