@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Relatório de Clientes</h1>
    <p>Período: {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} a {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</p>
    <table class="table">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Locações</th>
                <th>Pagamentos</th>
                <th>Total Pago</th>
                <th>Total a Pagar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->name }}</td>
                    <td>
                        @foreach ($client->rentals()->whereBetween('created_at', [$startDate, $endDate])->get() as $rental)
                            <p>Locação ID: {{ $rental->id }} - {{ \Carbon\Carbon::parse($rental->created_at)->format('d-m-Y') }}</p>
                        @endforeach
                    </td>
                    <td>
                        @php
                            $totalPaid = 0;
                            $totalToPay = 0;
                        @endphp
                        @foreach ($client->rentals()->whereBetween('created_at', [$startDate, $endDate])->get() as $rental)
                            @foreach ($rental->payments as $payment)
                                <p>Pagamento ID: {{ $payment->id }} - Valor: {{ $payment->amount }} - Status: 
                                    @if ($payment->status == 0)
                                        Pago
                                    @elseif ($payment->status == 1)
                                        A Receber
                                    @endif
                                    - Data: {{ \Carbon\Carbon::parse($payment->created_at)->format('d-m-Y') }}
                                </p>
                                @if ($payment->status == 0)
                                    @php
                                        $totalPaid += $payment->amount;
                                    @endphp
                                @elseif ($payment->status == 1)
                                    @php
                                        $totalToPay += $payment->amount;
                                    @endphp
                                @endif
                            @endforeach
                        @endforeach
                    </td>
                    <td>R${{ $totalPaid }}</td>
                    <td>R${{ $totalToPay }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('reports.index') }}" class="btn btn-secondary mt-3">Voltar</a>
</div>
@endsection
