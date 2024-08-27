<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRolePermission extends Model
{
    use HasFactory;
    protected $table = 'user_roles_permission';
    protected $fillable = ['role_title', 'module_id'];
}


?>