<?php

namespace ConfrariaWeb\Acl\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;

    protected $table = 'acl_permissions';

    protected $fillable = [
        'slug',
        'name',
        'description',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'acl_permission_role');
    }

    protected function dtCreated(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => isset($attributes['created_at']) ? Carbon::parse($attributes['created_at'])->format('d/m/Y') : NULL,
            set: fn ($value) => $value,
        );
    }

    protected function dtUpdated(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => isset($attributes['updated_at']) ? Carbon::parse($attributes['updated_at'])->format('d/m/Y') : NULL,
            set: fn ($value) => $value,
        );
    }
}
