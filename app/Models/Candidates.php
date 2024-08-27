<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidates extends Model
{
    use HasFactory;
    
    protected $table = 'candidates';
    protected $fillable = ['first_name','last_name','email','status'];

    // public function assessmentProjectId(){
    //     return $this->belongsTo(ProjectAssessment::class,'id','assessment_id')->with('projectDetails');
    // }
}
