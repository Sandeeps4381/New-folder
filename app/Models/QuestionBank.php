<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBank extends Model
{
    use HasFactory;


    
    protected $table = 'question_bank';
    protected $fillable = [
        'question_type',
        'question_title',
        'question_option1',
        'question_option2',
        'question_option3',
        'question_option4',
        'question_option5',
        'question_option6',
        'question_image',
        'question_video',
        'question_file',
        'question_guidlines',
        'assessment_only',
        'score_required',
        'score_type',
        'score_option',
        'status',
        'question_require'
    ];


}

