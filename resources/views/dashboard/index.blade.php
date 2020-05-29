@extends('layouts.app')

@section('content')
<div class="container-fluid">

    @if(session()->get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session()->get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session()->get('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session()->get('warning'))

        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session()->get('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row row-cols-1 row-cols-lg-6 row-cols-md-4 row-cols-sm-3 row-cols-xs-1">
        @foreach($sensors as $sensor)
            <div class="col mb-4">
                @component('components.information-box', [
                    'id' => $sensor->equipment->id,
                    'name' => $sensor->equipment->name,
                    'image' => $sensor->equipment->image,
                    'value' => is_numeric($sensor->equipment->value) || $sensor->equipment->value || $sensor->equipment->value == 0 ? $sensor->equipment->value : 'Não Definido',
                    'metric' => $sensor->metric,
                    'updatedAt' => $sensor->updated_at,
                    'actions' => $sensor->equipment->actions])

                @endcomponent
            </div>
        @endforeach
        @foreach($actuators as $atuactor)
            <div class="col mb-4">
                @component('components.information-box', [
                    'id' => $atuactor->equipment->id,
                    'name' => $atuactor->equipment->name,
                    'image' => $atuactor->equipment->image,
                    'value' => isset($atuactor->state->text) ? $atuactor->state->text : 'Não Definido',
                    'metric' => $atuactor->metric,
                    'updatedAt' => $atuactor->updated_at,
                    'actions' => $atuactor->equipment->actions])

                @endcomponent
            </div>
        @endforeach
        @foreach($things as $thing)
            <div class="col mb-4">
                @component('components.information-box', [
                    'id' => $thing->equipment->id,
                    'name' => $thing->equipment->name,
                    'image' => $thing->equipment->image,
                    'value' => isset($thing->state->text)  ? $thing->state->text : 'Não Definido',
                    'metric' => $thing->metric,
                    'updatedAt' => $thing->updated_at,
                    'actions' => $thing->equipment->actions])

                @endcomponent
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function(){
            setInterval(updateValues, 2000);
         });

        function updateValues(){
            $.ajax({ url: '/api/equipments/values'})
            .done(function(data){
                data.forEach(function(value){
                    var elem_id = "#equipment_" + value.id + "_info";
                    $(elem_id).find('#value_info').html(value.value)
                    $(elem_id).find('#value_updated').html(value.updated_at)
                });
            });
        }
    </script>
@endpush
