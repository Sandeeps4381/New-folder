<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentIntives extends Model{
    use HasFactory;
    
    protected $table = 'assessment_invites';
    protected $fillable = ['candidate_id','assessment_id','invite_code','invited_by','status'];

    public function AssessmentCandidateList(){
        return $this->belongsTo(Candidates::class,'id','candidate_id');
    }
}
