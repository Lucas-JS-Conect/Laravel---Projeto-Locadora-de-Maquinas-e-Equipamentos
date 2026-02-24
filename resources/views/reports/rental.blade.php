@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Relatório de Locações</h1>
    <p>Período: {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} a {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</p>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuário</th>
                <th>Cliente</th>
                <th>Máquina</th>
                <th>Início</th>
                <th>Término</th>
                <th>Valor Total</th>
                <th>Pagamentos</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rentals as $rental)
            <tr>
                <td>{{ $rental->id }}</td>
                <td>{{ $rental->user->name }}</td>
                <td>{{ $rental->client->name }}</td>
                <td>{{ $rental->machine->name }}</td>
                <td>{{ \Carbon\Carbon::parse($rental->start_date)->format('d-m-Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($rental->end_date)->format('d-m-Y') }}</td>
                <td>R${{ number_format($rental->total_amount, 2, ',', '.') }}</td>
                <td>
                    @foreach ($rental->payments as $payment)
                    <p>Pagamento ID: {{ $payment->id }} - Valor: R${{ number_format($payment->amount, 2, ',', '.') }} - Status: 
                        @if ($payment->status == 0)
                            Pago
                        @elseif ($payment->status == 1)
                            A Receber
                        @endif
                        - Data: {{ \Carbon\Carbon::parse($payment->created_at)->format('d-m-Y') }}
                    </p>
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('reports.index') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection
