<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $direction = 'asc';
      $projects = Project::orderBy('id',$direction)->paginate(10);
      return view('admin.projects.index', compact('projects', 'direction'));
    }


    public function orderBy($direction){
      $direction = $direction === 'asc' ? 'desc' : 'asc';
      $projects = Project::orderBy('id',$direction)->paginate(10);
      return view('admin.projects.index', compact('projects', 'direction'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
      return view('admin.projects.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
         // dd($request->all());
        $form_data = $request->all();

        // dd($form_data);

        $form_data['slug'] = Project::generateSlug($form_data['title']);
        $form_data['date'] = date('Y-m-d');

        if(array_key_exists('image',$form_data)){

          $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();

          $form_data['image_path'] = Storage::put('uploads', $form_data['image']);

          // dd($form_data);


        }

        $new_project = new Project();
        $new_project ->fill($form_data);
        $new_project->save();

        return redirect()->route('admin.projects.show', $new_project);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
      $date = date_create($project->date);
      $date_formatted = date_format($date, 'd/m/Y' );
      return view('admin.projects.show', compact('project', 'date_formatted'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
      return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request,Project $project)
    {
      $form_data=$request->all();

      $project->update($form_data);



      $form_data['slug'] = Project::generateSlug($form_data['title']);
      $form_data['date'] = date('Y-m-d');

      if(array_key_exists('image',$form_data)){

        if($project->image){
          Storage::disk('public')->delete($project->image_path);
        }

        $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();

        $form_data['image_path'] = Storage::put('uploads', $form_data['image']);

      }


      return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

      if($project->image){
        Storage::disk('public')->delete($project->image_path);
      }

      $project->delete();
      return redirect()->route('admin.projects.index')->with('deleted', "Il progetto $project->title è stato eliminato correttamente");
    }
}