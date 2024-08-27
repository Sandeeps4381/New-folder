<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentAttempts extends Model
{
    use HasFactory;
    protected $table = 'assessment_attempts';
    protected $fillable = ['candidate_id','assessment_id','question_id','answer1','answer2', 'answer_file', 'given_score'];
}
