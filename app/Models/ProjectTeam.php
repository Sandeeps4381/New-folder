<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\UserRole;

class ProjectTeam extends Model{
    use HasFactory;

    protected $table = 'project_team';
    protected $fillable = [
        'product_id',
        'user_id',
        'ismanger',
    ];

    public function userDetail(){
       return $this->belongsTo(User::class,'user_id','id')->with(['userRoleDetail']);
    }

}
