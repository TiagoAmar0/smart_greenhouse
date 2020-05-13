@extends('layouts.card-template')

@section('card-title')
    Adicionar novo sensor
@endsection

@section('card-content')
    <a href="{{ route('sensors.index') }}" class="btn btn-large btn-outline-dark mb-3">
        « Voltar à listagem
    </a>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
               {{ $error }}
        </div>
        @endforeach
    @endif

    <form method="POST" action="{{ route('equipments.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="sensor_name_help" required>
            <small id="sensor_name_help" class="form-text text-muted">Nome do sensor a adicionar.</small>
        </div>
        <div class="form-group">
            <label for="type">Tipo:</label>
            <select id="type" name="type" aria-describedby="equipment_type_help"  class="custom-select custom-select-sm" required>
                <option disabled selected value>Escolha o tipo de equipamento</option>
                <option value="1">Sensor</option>
                <option value="2">Atuador</option>
                <option value="3">Thing</option>
            </select>
            <small id="equipment_type_help" class="form-text text-muted">Tipo do equipamento a criar (Sensor, Atuador, Thing).</small>
        </div>
        <div class="form-group">
            <label for="image">Imagem:</label>
            <img id="image_preview" src=""
                 alt="preview image" style="max-height: 150px; display: none">
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*" aria-describedby="sensor_image_help" required>
            <small id="sensor_image_help" class="form-text text-muted">Imagem representativa do sensor.</small>
        </div>
        <button type="submit" class="btn btn-dark">Adicionar</button>
    </form>
@endsection

@push('scripts')
    <script>
        $('#image').change(function(){

            let reader = new FileReader();
            reader.onload = (e) => {
                $('#image_preview').attr('src', e.target.result);
                $('#image_preview').css('display', 'block');
            }
            reader.readAsDataURL(this.files[0]);

        });
    </script>
@endpush
