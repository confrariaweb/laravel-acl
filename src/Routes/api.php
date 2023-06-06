<?php

use ConfrariaWeb\Acl\Controllers\Api\PermissionController;
use ConfrariaWeb\Acl\Controllers\Api\RoleController;
use Illuminate\Support\Facades\Route;

Route::apiResource('acl/roles', RoleController::class);
Route::apiResource('acl/permissions', PermissionController::class);
