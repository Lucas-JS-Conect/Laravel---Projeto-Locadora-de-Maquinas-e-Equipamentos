@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalhes do Pagamento</h1>

    <div class="form-group">
        <label for="client">Cliente:</label>
        <p>{{ $payment->rental->client->name }}</p>
    </div>

    <div class="form-group">
        <label for="machine">Máquina:</label>
        <p>{{ $payment->rental->machine->name }}</p>
    </div>

    <div class="form-group">
        <label for="start_date">Data de Início:</label>
        <p>{{ $payment->rental->start_date->format('d-m-Y H:i') }}</p>
    </div>

    <div class="form-group">
        <label for="end_date">Data de Término:</label>
        <p>{{ $payment->rental->end_date->format('d-m-Y H:i') }}</p>
    </div>

    <div class="form-group">
        <label for="amount">Valor Pago:</label>
        <p>R$ {{ number_format($payment->amount, 2, ',', '.') }}</p>
    </div>

    <div class="form-group">
        <label for="paid_at">Data do Pagamento:</label>
        <p>{{ $payment->paid_at ? $payment->paid_at->format('d-m-Y H:i') : '-' }}</p>
    </div>

    <a href="{{ route('payments.index') }}" class="btn btn-secondary">Voltar</a>
</div>
@endsection
