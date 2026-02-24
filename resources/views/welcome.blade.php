@extends('layouts.main')

@section('title', 'Máquina')

@section('content')

<div id="search-container" class="col-md-12">

    <h1> Busque por uma Máquina </h1>

    <form action="/machines" method="GET"> 
        <input type="text" id="search" name="search" class="form-control" placeholder="Procurar">

    </form>

</div>

<div id="machines-container" class="col-md-12"> 
    @if('$search')

    <h2> Buscar por: {{ $search }} </h2>

    @else

    <h2> Máquinas </h2>

    <p class="subtitle"> Máquinas disponíveis </p>

    @endif

    <div id="cards-container" class="row">

        @foreach( $machines as $machine ) 
        <div class="card col-md-3">

            <img src="../img/machine/{{ $machine->image }}" alt="{{ $machine->name }}"> 
            <div class="card-body">

                <p class="card-date"> {{ date('d/m/Y', strtotime($machine->date)) }} </p>

                <h5 class="card-title"> {{ $machine->name }} </h5>

                <a href="/machines/{{ $machine->id }}" class="btn btn-primary"> Ver </a> 

            </div>

        </div>

        @endforeach

        @if(count($machines) == 0 && $search)

        <p> Não foi possível encontrar Máquina com: {{ $search }} ! <a href="/machines"> Ver todos.. </a> </p> 
        
        @elseif(count($machines) == 0)

        <p> Não há Máquina disponível </p>

        @endif

    </div>

</div>

@endsection
