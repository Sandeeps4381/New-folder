<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Projects;
use PhpParser\Node\Stmt\Return_;

class ScoreController extends Controller
{
    public function index()
    {
      
         // This should be dynamically set based on your logic
    
        // Return the view and pass the score variable
        return view('scoremanagement.index');
    }
    
    public function assessment_result()
{
    // Render the ass.blade.php view
    return view('scoremanagement.assessment_result');
}
public function feedback()
{
    // Render the feedback.blade.php view
    return view('scoremanagement.feedback');
}
public function view_feedback()
{
    // Render the view_feedback.blade.php view
    return view('scoremanagement.view_feedback');
    }
 

}
