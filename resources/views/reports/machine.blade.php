@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Relatório de Máquinas</h1>
    <p>Período: {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} a {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</p>
    <table class="table">
        <thead>
            <tr>
                <th>Máquina</th>
                <th>Depreciações</th>
                <th>Manutenções</th>
                <th>Locações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($machines as $machine)
            <tr>
                <td>{{ $machine->name }}</td>
                <td>
                    @foreach ($machine->depreciations()->whereBetween('created_at', [$startDate, $endDate])->get() as $depreciation)
                    <p>Data: {{ \Carbon\Carbon::parse($depreciation->created_at)->format('d-m-Y') }} - Valor: R${{ number_format($depreciation->amount, 2, ',', '.') }}</p>
                    @endforeach
                </td>
                <td>
                    @foreach ($machine->maintenances()->whereBetween('start_date', [$startDate, $endDate])->get() as $maintenance)
                        <p>Manutenção ID: {{ $maintenance->id }} - Descrição: {{ $maintenance->description }}</p>
                    @endforeach
                </td>
                <td>
                    @foreach ($machine->rentals()->whereBetween('start_date', [$startDate, $endDate])->get() as $rental)
                        <p>Locação ID: {{ $rental->id }} - Cliente: {{ $rental->client->name }}</p>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('reports.index') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection
