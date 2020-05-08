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

    <form method="POST" action="{{ route('sensors.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" class="form-control" id="name" name="name" aria-describedby="sensor_name_help" required>
            <small id="sensor_name_help" class="form-text text-muted">Nome do sensor a adicionar.</small>
        </div>
        <div class="form-group">
            <label for="image">Imagem:</label>
            <img id="image_preview" src=""
                 alt="preview image" style="max-height: 150px; display: none">
            <input type="file" class="form-control-file" id="image" name="image" accept="image/*" aria-describedby="sensor_image_help" required>
            <small id="sensor_image_help" class="form-text text-muted">Imagem representativa do sensor.</small>
        </div>
        <div class="form-group">
            <label for="metric">Unidade:</label>
            <input type="text" class="form-control" id="metric" name="metric" aria-describedby="sensor_metric_help" required>
            <small id="sensor_metric_help" class="form-text text-muted">Unidade representativa dos dados do sensor.</small>
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
