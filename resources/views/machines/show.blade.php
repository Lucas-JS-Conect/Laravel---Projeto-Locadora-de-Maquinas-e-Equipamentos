@extends('layouts.main')

@section('title', 'Máquinas')

@section('content')
<div class="col-md-10 offset-md-1">
    <div class="row">
        <div id="img-container" class="col-md-6">
            <img src="/img/machine/{{ $machine->image }}" class="img-fluid" alt="{{ $machine->name }}">
        </div>
        <div id="info-container" class="col-md-6">
            <h1>{{ $machine->name }}</h1>
            <p class="machine-description">
                <ion-icon name="information-circle-outline"></ion-icon> {{ $machine->type }}
            </p>
            <p class="machine-model">
                <ion-icon name="pricetag-outline"></ion-icon> Modelo: {{ $machine->model }}
            </p>
            <p class="machine-brand">
                <ion-icon name="construct-outline"></ion-icon> Marca: {{ $machine->brand }}
            </p>
            <p class="machine-manufacture_year">
                <ion-icon name="calendar-outline"></ion-icon> Ano de Fabricação: {{ $machine->manufacture_year }}
            </p>
            <p class="machine-acquisition_year">
                <ion-icon name="calendar-outline"></ion-icon> Ano de Aquisição: {{ $machine->acquisition_year }}
            </p>
            <p class="machine-serial_number">
                <ion-icon name="barcode-outline"></ion-icon> Número de Série: {{ $machine->serial_number }}
            </p>
            <p class="machine-hourly_rate">
                <ion-icon name="cash-outline"></ion-icon> Valor por Hora: R$ {{ $machine->hourly_rate }}
            </p>
            <p class="machine-status">
                <ion-icon name="pulse-outline"></ion-icon> Status: {{ $machine->status }}
            </p>
            <p class="machine-maintenance">
                <ion-icon name="construct-outline"></ion-icon> Manutenção: {{ $machine->isUnderMaintenance() ? 'Em manutenção' : 'Disponível' }}
            </p>
        </div>

        <div class="mt-3">
            <a href="{{ route('machines.edit', ['machine' => $machine->id]) }}" class="btn btn-primary">Editar</a>
            <form action="{{ route('machines.destroy', ['machine' => $machine->id]) }}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta máquina/equipamento?')">Excluir</button>
            </form>
            <a href="{{ route('rentals.create', ['machine_id' => $machine->id]) }}" class="btn btn-success">Realizar Locação</a>
            <a href="{{ route('maintenances.create', ['machine_id' => $machine->id]) }}" class="btn btn-warning">Realizar Manutenção</a>
            <a href="{{ route('machines.dashboard') }}" class="btn btn-secondary">Voltar</a>
        </div>
    </div>
</div>
@endsection