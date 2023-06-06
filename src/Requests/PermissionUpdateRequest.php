<?php

namespace ConfrariaWeb\Acl\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->permission;
        return [
            'slug' => "required|string|unique:acl_permissions,slug,$id",
            'name' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}

