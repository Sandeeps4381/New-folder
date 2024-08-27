<?php

namespace App\Models;  // Adjust the namespace as per your application structure

use Illuminate\Database\Eloquent\Model;

class Projects extends Model
{
    protected $table = 'project';  // Specify the table name

    protected $fillable = [
        'project_title',
        'project_type',
        'project_image',
        'project_description',
        'project_guideline',
        'created_at',
        'updated_at',
    ];

    // Optionally, if you want timestamps managed by Laravel automatically
    // public $timestamps = true;

    // If you want to explicitly define the format of your timestamps
    // protected $dateFormat = 'Y-m-d H:i:s';

    public function assessments() {
        return $this->hasMany(ProjectAssessment::class, 'project_id', 'id');
    }

    public function userDetail() {
        return $this->hasMany(User::class, 'created_by', 'id');
    }
}

?>
