@extends('layouts.app')

@section('content')

<div class="container p-5 overflow-auto">

  @if (session('deleted'))
    <div class="alert alert-success" role="alert">
      {{ session('deleted') }}
    </div>
  @endif



  <h2 class="my-4 fs-4 text-secondary fw-bold">
    Elenco Tipologie e Progetti
  </h2>


  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col">Nome</th>
        <th scope="col">Progetti</th>

      </tr>
    </thead>
    <tbody>
      @foreach ($typologies as $type)
        <tr>
          <td>{{$type->name}}</td>
          <td>
            <ul>
              @forelse ($type->projects as $project)
                <li><a href="{{route('admin.projects.show', $project)}}">{{$project->title}}</a></li>
              @empty
                <li>non sono presenti progetti</li>
              @endforelse
            </ul>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>


@endsection
