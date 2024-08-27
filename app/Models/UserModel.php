<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;
    protected $table = 'assessment_invites';
    protected $fillable = ['candidate_id','assessment_id','invite_code','invited_by','status'];

    public function assessments() {
        return $this->hasMany(ProjectAssessment::class, 'project_id', 'id');
    }
}

?>