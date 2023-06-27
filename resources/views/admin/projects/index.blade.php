@extends('layouts.app')

@section('content')

<div class="container p-5 ">

  @if (session('deleted'))
    <div class="alert alert-success" role="alert">
      {{ session('deleted') }}
    </div>
  @endif



  <h2 class="my-4 fs-4 text-secondary fw-bold">
    Elenco Progetti
  </h2>

  <table class="table table-hover">
    <thead>
      <tr>
        <th scope="col"><a href="{{route('admin.orderBy',['direction' => $direction ] )}}" class="text-black">Id</a></th>
        <th scope="col">Titolo</th>
        <th scope="col">Data</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($projects as $project)
        <tr>
          <td>{{$project ->id}}</td>
          <td>{{$project ->title}}</td>
          @php
            $date = date_create($project->date);
          @endphp
          <td>{{date_format($date, 'd/m/Y')}}</td>
          <td><a href="{{route('admin.projects.show', $project)}}" class="btn btn-success" title="Vai"><i class="fa-solid fa-eye"></i></a></td>
          <td><a href="{{route('admin.projects.edit', $project)}}" class="btn btn-warning" title="Modifica"><i class="fa-solid fa-pencil"></i></a></td>
          <td>

            <!-- Button trigger modal -->
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
              <i class="fa-solid fa-trash-can"></i>
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5 text-danger fw-bold" id="exampleModalLabel"> Attenzione </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    Sei sicuro di voler eliminare {{ $project->title}}?
                  </div>

                  {{-- Delete --}}
                  <form
                    action="{{route('admin.projects.destroy', $project)}}"
                    method="POST">
                      @csrf
                      @method('DELETE')

                    <div class="modal-footer">
                      <button
                      type="submit"
                      class="btn btn-danger fw-bold">
                      Elimina
                      </button>

                      <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">Annulla</button>
                  </form>

                </div>
              </div>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div>
    {{$projects->links()}}
  </div>

</div>

@endsection
