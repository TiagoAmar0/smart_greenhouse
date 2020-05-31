@extends('layouts.app')

@push('styles')
    <style>
        ul.timeline {
            list-style-type: none;
            position: relative;
            padding-left: 1.5rem;
        }

        /* Timeline vertical line */
        ul.timeline:before {
            content: ' ';
            background: #c2c2c2;
            display: inline-block;
            position: absolute;
            left: 16px;
            width: 4px;
            height: 100%;
            z-index: 400;
            border-radius: 1rem;
        }

        li.timeline-item {
            margin: 20px 0;
        }

        /* Timeline item arrow */
        .timeline-arrow {
            border-top: 0.5rem solid transparent;
            border-right: 0.5rem solid #fff;
            border-bottom: 0.5rem solid transparent;
            display: block;
            position: absolute;
            left: 2rem;
        }

        /* Timeline item circle marker */
        li.timeline-item::before {
            content: ' ';
            background: #ddd;
            display: inline-block;
            position: absolute;
            border-radius: 50%;
            border: 3px solid #fff;
            left: 11px;
            width: 14px;
            height: 14px;
            z-index: 400;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
    </style>
@endpush

@section('content')
    <div class="container py-5">

        <!-- For demo purpose -->
        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <h1 class="display-4">Histórico do equipamento "{{ $equipment->name }}"</h1>
            </div>
        </div><!-- End -->


        <div class="row">
            <div class="col-lg-7 mx-auto">

                <!-- Timeline -->
                <ul class="timeline">
                    @if($equipment->name == 'Webcam')
                        @foreach($equipment->histories as $history)
                            <li class="timeline-item bg-white rounded ml-3 p-4 shadow">
                                <div class="timeline-arrow"></div>
                                <h2 class="h5 mb-0">Imagem registada:</h2>
                                <div class="container">
                                    <img src="{{ $history->value }}" alt="Webcam history" style="max-width: 300px; height: auto"/>
                                </div>
                                <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i>{{ $history->created_at }}</span>
                            </li>
                        @endforeach
                    @else
                        @if($equipment->type == 1)
                            @foreach($equipment->histories as $history)
                                <li class="timeline-item bg-white rounded ml-3 p-4 shadow">
                                    <div class="timeline-arrow"></div>
                                    <h2 class="h5 mb-0">Valor registado: {{ $history->value }} {{ $equipment->sensor->metric }}</h2>
                                    <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i>{{ $history->created_at }}</span>
                                </li>
                            @endforeach
                        @else
                            @foreach($equipment->histories as $history)
                                <li class="timeline-item bg-white rounded ml-3 p-4 shadow">
                                    <div class="timeline-arrow"></div>
                                    <h2 class="h5 mb-0">Estado do equipamento alterado para "{{ $history->state }}"</h2>
                                    <span class="small text-gray"><i class="fa fa-clock-o mr-1"></i>{{ $history->created_at }}</span>
                                </li>
                            @endforeach
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endsection

