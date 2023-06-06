<?php

namespace ConfrariaWeb\Acl\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->role;
        return [
            'slug' => "required|string|unique:acl_roles,slug,$id",
            'name' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}

