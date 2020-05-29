@extends('layouts.card-template')

@section('card-title')
    Estados dos equipamentos
@endsection

@section('card-content')
    <a href="{{ route('states.create') }}" class="btn btn-large btn-outline-dark mb-3">
        Adicionar novo estado
    </a>

    @if(session()->get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif


    <table class="table table-striped table-bordered text-center">
        <thead>
        <tr>
            <th>ID</th>
            <th>Equipamento</th>
            <th>Estado</th>
            <th>Texto</th>
            <th>Criado em</th>
            <th>Atualizado em</th>
            <th colspan="2">Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($states as $state)
            <tr>
                <td>{{ $state->id }}</td>
                <td>{{ $state->equipment->name }}</td>
                <td>{{ $state->value  }}</td>
                <td>{{ $state->text  }}</td>
                <td>{{ $state->created_at }}</td>
                <td>{{ $state->updated_at }}</td>
                <td>
                    <a href="{{ route('states.edit', $state->id) }}" class="btn btn-success btn-block">⠀Editar⠀</a>
                </td>
                <td>
                    <form action="{{ route('states.destroy', $state->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-block">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
