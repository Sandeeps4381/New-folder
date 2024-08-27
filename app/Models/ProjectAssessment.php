<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAssessment extends Model
{
    use HasFactory;
    protected $table = 'project_assessment';
    protected $fillable = ['assessment_id', 'project_id'];

    public function projectDetails(){
        return $this->belongsTo(Projects::class,'project_id','id');
    }
}

?>
