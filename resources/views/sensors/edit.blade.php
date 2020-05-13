@extends('layouts.card-template')

@section('card-title')
    Editar informações do sensor ID({{ $sensor->id }})
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

    <form method="POST" action="{{ route('sensors.update', $sensor->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group">
            <label for="metric">Unidade:</label>
            <input type="text" class="form-control" id="metric" name="metric" aria-describedby="sensor_metric_help" value="{{ $sensor->metric }}" required>
            <small id="sensor_metric_help" class="form-text text-muted">Unidade representativa dos dados do sensor.</small>
        </div>
        <button type="submit" class="btn btn-dark">Atualizar</button>
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
