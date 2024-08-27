<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $table = 'assessments';
    protected $fillable = ['title','project_type','scoring','administration_schedule','description'];

    public function assessmentProjectId(){
        return $this->belongsTo(ProjectAssessment::class,'id','assessment_id')->with('projectDetails');
    }
}
