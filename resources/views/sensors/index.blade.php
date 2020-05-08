@extends('layouts.card-template')

@section('card-title')
    Sensores
@endsection

@section('card-content')
    <a href="{{ route('sensors.create') }}" class="btn btn-large btn-outline-dark mb-3">
        Adicionar novo sensor
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
                <th>Nome</th>
                <th>Criado em</th>
                <th>Atualizado em</th>
                <th colspan="2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sensors as $sensor)
                <tr>
                    <td>{{ $sensor->id }}</td>
                    <td>{{ $sensor->name }}</td>
                    <td>{{ $sensor->created_at }}</td>
                    <td>{{ $sensor->updated_at }}</td>
                    <td>
                        <a href="{{ route('sensors.edit', $sensor->id) }}" class="btn btn-success btn-block">⠀Editar⠀</a>
                    </td>
                    <td>
                        <form action="{{ route('sensors.destroy', $sensor->id) }}" method="POST">
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
