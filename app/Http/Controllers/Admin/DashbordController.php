<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use Illuminate\Http\Request;


class DashbordController extends Controller
{
  public function index(Project $project ){

    $n_project = Project::all()->count();

    $last_project = Project::orderby('id', 'desc')->first();


      return view('admin.home', compact('n_project', 'last_project', 'project'));
  }
}