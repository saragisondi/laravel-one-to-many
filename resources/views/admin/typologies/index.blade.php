@extends('layouts.app')

@section('content')

<div class="container p-5 ">

  @if (session('message'))
    <div class="alert alert-success" role="alert">
      {{ session('message') }}
    </div>
  @endif



  <h2 class="my-4 fs-4 text-secondary fw-bold">
    Gestione Tipologie
  </h2>

  <div class="w-50">

    <div class="mb-3 input-group">
      <input type="text" class="form-control" placeholder="Nuova Tipologia" aria-label="Nuova Tipologia" aria-describedby="basic-addon2">
      <div class="input-group-append">
        <button class="mx-3 btn btn-outline-primary" type="button"> <i class="fa-solid fa-plus"></i> Add </button>
      </div>
    </div>

    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">Tipo</th>
          <th scope="col">Num progetti</th>
          <th scope="col">Azioni</th>

        </tr>
      </thead>
      <tbody>
        @foreach ($typologies as $type)
          <tr>
            <td>

              <form action="{{route('admin.types.update', $type)}}"
              method="POST"
              id="edit-form">
                @csrf
                @method('PUT')

                <input class="border-0" name="name" value="{{$type->name}}">
              </form>
            </td>

            <td>{{count($type->projects)}}</td>

            <td>

              <button
              class="btn btn-success"
              title="Salva"
              onclick="submitEditForm()">
                <i class="fa-solid fa-floppy-disk"></i>
              </button>


              <button
              class="btn btn-danger"
              title="Elimina">
                <i class="fa-solid fa-trash-can"></i>
              </button>

            </td>

          </tr>
          @endforeach
        </tbody>
      </table>

  </div>


<script>
  function submitEditForm(){
    const form = document.getElementById('edit-form');
    form.submit();
  }
</script>


@endsection
