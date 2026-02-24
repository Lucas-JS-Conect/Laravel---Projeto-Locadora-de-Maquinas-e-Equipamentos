@extends('layouts.main')

@section('title', 'Cadastrar Máquina')

@section('content')

<div id="machine-create-container" class="col-md-6 offset-md-3">

    <h1> Cadastre uma Máquina </h1>

    <form action="/machines" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="image"> Imagem da Máquina </label>
            <input type="file" id="image" name="image" class="form-control-file">
        </div>

        <div class="form-group">
            <label for="name"> Nome: </label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nome da Máquina e/ou Equipamento">
        </div>

        <div class="form-group">
            <label for="type"> Tipo: </label>
            <input type="text" class="form-control" id="type" name="type" placeholder="Tipo da Máquina e/ou Equipamento">
        </div>

        <div class="form-group">
            <label for="model"> Modelo: </label>
            <input type="text" class="form-control" id="model" name="model" placeholder="Modelo da Máquina e/ou Equipamento">
        </div>

        <div class="form-group">
            <label for="brand"> Marca: </label>
            <input type="text" class="form-control" id="brand" name="brand" placeholder="Marca da Máquina e/ou Equipamento">
        </div>

        <div class="form-group">
            <label for="manufacture_year"> Ano de Fabricação: </label>
            <input type="text" class="form-control" id="manufacture_year" name="manufacture_year" placeholder="Ano de Fabricação da Máquina e/ou Equipamento">
        </div>

        <div class="form-group">
            <label for="acquisition_year"> Ano de Aquisição: </label>
            <input type="text" class="form-control" id="acquisition_year" name="acquisition_year" placeholder="Ano de Aquisição da Máquina e/ou Equipamento">
        </div>

        <div class="form-group">
            <label for="serial_number"> Número de Série: </label>
            <input type="text" class="form-control" id="serial_number" name="serial_number" placeholder="Número de Série da Máquina e/ou Equipamento">
        </div>

        <div class="form-group">
            <label for="hourly_rate">Valor por Hora:</label>
            <input type="text" name="hourly_rate" id="hourly_rate" class="form-control">
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary mr-2">Cadastrar</button>           
            <a href="{{ route('machines.dashboard') }}" class="btn btn-secondary mt-3">Voltar</a>
        </div>

    </form>

</div>

@endsection