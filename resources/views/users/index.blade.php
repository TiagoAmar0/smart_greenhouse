@extends('layouts.card-template')

@section('card-title')
    Utilizadores
@endsection

@section('card-content')
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
            <th>Nome do Utilizador</th>
            <th>Email</th>
            <th>Permição</th>
            <th>Criado em</th>
            <th>Atualizado em</th>
            <th colspan="2">Ações</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)

            <tr>

                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email}}</td>
                <td>{{ $user->role}}</td>
                <td>{{ $user->created_at }}</td>
                <td>{{ $user->updated_at }}</td>
                <td>
                    <a href="{{ route('sensors.edit', $user->id) }}" class="btn btn-success btn-block">⠀Editar⠀</a>
                </td>
                <td>

                    <form action="{{ '/dashboard/users/togglePermissions/' . $user->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-primary btn-block">⠀{{$user->role=='admin'?'Tornar User':'Tornar Admin'}}⠀</button>
                    </form>
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
