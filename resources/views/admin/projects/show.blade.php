@extends('layouts.app')

@section('content')
<div class="container p-5">
  <div class="d-flex">

    <h2 class="my-4 fs-4 text-secondary">
      {{$project->title}}
    </h2>

    <div class="my-4 d-flex">
      {{-- Edit --}}
      <a href="{{route('admin.projects.edit', $project)}}" class="mx-2 btn btn-warning" title="Modifica"><i class="fa-solid fa-pencil"></i></a>


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
    </div>

  </div>

</div>

  <p>{{$date_formatted}}</p>
  <p>{!!$project->text!!}</p>
  <div>
    <img class="w-50" src="{{asset('storage/' . $project->image_path)}}" alt="{{$project->title}}">
  </div>

  <a href="{{route('admin.projects.index')}}" class="my-4 btn btn-secondary"><i class="fa-solid fa-rotate-left"></i></a>

</div>

@endsection
