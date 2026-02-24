@extends('layouts.main')

@section('title', 'Editar Máquina')

@section('content')
<div id="machine-edit-container" class="col-md-6 offset-md-3">
    <h1>Editando: {{ $machine->name }}</h1>
    <form action="{{ route('machines.update', ['machine' => $machine->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div id="img-container" class="col-md-6">
            <img src="/img/machine/{{ $machine->image }}" class="img-fluid" alt="{{ $machine->name }}">
        </div>

        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $machine->name }}">
        </div>

        <div class="form-group">
            <label for="type">Tipo:</label>
            <input type="text" class="form-control" id="type" name="type" value="{{ $machine->type }}">
        </div>

        <div class="form-group">
            <label for="model">Modelo:</label>
            <input type="text" class="form-control" id="model" name="model" value="{{ $machine->model }}">
        </div>

        <div class="form-group">
            <label for="brand">Marca:</label>
            <input type="text" class="form-control" id="brand" name="brand" value="{{ $machine->brand }}">
        </div>

        <div class="form-group">
            <label for="manufacture_year">Ano de Fabricação:</label>
            <input type="text" class="form-control" id="manufacture_year" name="manufacture_year" value="{{ $machine->manufacture_year }}">
        </div>

        <div class="form-group">
            <label for="acquisition_year">Ano de Aquisição:</label>
            <input type="text" class="form-control" id="acquisition_year" name="acquisition_year" value="{{ $machine->acquisition_year }}">
        </div>

        <div class="form-group">
            <label for="serial_number">Número de Série:</label>
            <input type="text" class="form-control" id="serial_number" name="serial_number" value="{{ $machine->serial_number }}">
        </div>

        <div class="form-group">
            <label for="hourly_rate">Valor por Hora:</label>
            <input type="text" class="form-control" id="hourly_rate" name="hourly_rate" value="{{ $machine->hourly_rate }}">
        </div>

        <button type="submit" class="btn btn-primary">Atualizar</button>
        <a href="{{ route('machines.dashboard') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
