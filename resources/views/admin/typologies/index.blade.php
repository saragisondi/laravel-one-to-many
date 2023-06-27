@extends('layouts.app')

@section('content')

<div class="container p-5 ">

  @if (session('deleted'))
    <div class="alert alert-success" role="alert">
      {{ session('deleted') }}
    </div>
  @endif



  <h2 class="my-4 fs-4 text-secondary fw-bold">
    Elenco Tipologie
  </h2>

  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col"><a href="#" class="text-black">Id</a></th>
        <th scope="col">Tipo</th>
        <th scope="col">Numero progetti</th>
        <th scope="col">Azioni</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($typologies as $type)
        <tr>
          <td>{{$type->id}}</td>
          <td>{{$type->name}}</td>
          <td>{{count($type->projects)}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>





@endsection
