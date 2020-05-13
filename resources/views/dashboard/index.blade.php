@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row row-cols-1 row-cols-lg-6 row-cols-md-4 row-cols-sm-3 row-cols-xs-1">
        @foreach($sensors as $sensor)
            <div class="col mb-4">
                @component('components.information-box', [
                    'id' => $sensor->id,
                    'name' => $sensor->equipment->name,
                    'image' => $sensor->equipment->image,
                    'value' => $sensor->equipment->value ? $sensor->equipment->value : 'Não Definido',
                    'metric' => $sensor->metric,
                    'updatedAt' => $sensor->updated_at,
                    'actions' => $sensor->equipment->actions])

                @endcomponent
            </div>
        @endforeach
        @foreach($actuators as $atuactor)
            <div class="col mb-4">
                @component('components.information-box', [
                    'id' => $atuactor->id,
                    'name' => $atuactor->equipment->name,
                    'image' => $atuactor->equipment->image,
                    'value' => $atuactor->equipment->value ? $sensor->equipment->value : 'Não Definido',
                    'metric' => $atuactor->metric,
                    'updatedAt' => $atuactor->updated_at,
                    'actions' => $atuactor->equipment->actions])

                @endcomponent
            </div>
        @endforeach
        @foreach($things as $thing)
            <div class="col mb-4">
                @component('components.information-box', [
                    'id' => $thing->id,
                    'name' => $thing->equipment->name,
                    'image' => $thing->equipment->image,
                    'value' => $thing->equipment->value ? $sensor->equipment->value : 'Não Definido',
                    'metric' => $thing->metric,
                    'updatedAt' => $thing->updated_at,
                    'actions' => $thing->equipment->actions])

                @endcomponent
            </div>
        @endforeach
    </div>
</div>
@endsection

