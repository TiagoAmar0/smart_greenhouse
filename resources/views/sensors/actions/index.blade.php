@extends('layouts.card-template')

@section('card-title')
    Sensores
@endsection

@section('card-content')
    <a href="{{ route('actions.create') }}" class="btn btn-large btn-outline-dark mb-3">
        Adicionar nova ação
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
            <th>Sensor</th>
            <th>Texto</th>
            <th>Route</th>
            <th>Valor</th>
            <th colspan="2">Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($actions as $action)
            <tr>
                <td>{{ $action->id }}</td>
                <td>{{ $action->sensor_id }}</td>
                <td>{{ $action->text }}</td>
                <td>{{ $action->route }}</td>
                <td>{{ $action->value }}</td>
                <td>
                    <a href="{{ route('actions.edit', $action->id) }}" class="btn btn-success btn-block">⠀Editar⠀</a>
                </td>
                <td>
                    <form action="{{ route('actions.destroy', $action->id) }}" method="POST">
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
