@extends('layouts.app')

@section('content')
<div class="py-5 mx-5 container-fluid ">
  <h2 class="my-4 fs-4 text-secondary fw-bold">
      Home Dashboard
  </h2>

  <h4 class="fw-bold">Numero Progetti: {{ $n_project }} </h4>
  <a href="{{route('admin.projects.create')}}" class="mx-2 my-3 btn btn-primary fw-bold">Nuovo Progetto</a>

  <div class="row justify-content-center">

    <h4 class="my-5">Ultimo Progetto: <span class="fw-bold">{{ $last_project->title }}</span> </h4>

    <div>
      <h5 class="fw-bold">{{ $last_project->title }}</h5>
      <img class="w-50" src="{{asset('storage/' . $project->image_path)}}" alt="{{$project->title}}">
      <p>{!! $last_project->text !!}</p>
    </div>

  </div>
</div>
@endsection

