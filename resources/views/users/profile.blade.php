@extends('layouts.card-template')

@section('card-title')
    Perfil
@endsection

@section('card-content')
    <div class="container">
        <div class="row">

            <div class="col-md-2">
                <img src="{{ Auth::user()->avatar }}" style="width: 150px; heigth:150px; float:left; border-radius:50%;margin-rigth:25px ">
            </div>

            <div class="col-md-10">
                <h2>{{ Auth::user()->name }}</h2>
                <h5>Email: {{ Auth::user()->email }} </h5><br><br>
                <div class="col-md-10">
                    <form enctype="multipart/form-data" action="/profile" method="POST">
                        @csrf
                        <h4> Trocar Imagem: </h4><br>
                        <input type="file" name="avatar">
                        <br>
                        <input type="submit" class="pull-rigth btn btn-sm btn-dark mt-2">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
