<?php

namespace ConfrariaWeb\Acl\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'slug' => 'required|string|unique:acl_roles',
            'name' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}

