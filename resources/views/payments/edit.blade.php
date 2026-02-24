@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ isset($payment) ? 'Editar Pagamento' : 'Novo Pagamento' }}</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ isset($payment) ? route('payments.update', $payment->id) : route('payments.store') }}" method="POST">
        @csrf
        @if (isset($payment))
        @method('PUT')
        @endif

        <div class="form-group">
            <label for="rental_id">Aluguel:</label>
            <select name="rental_id" id="rental_id" class="form-control" required>
                <option value="">Selecione um aluguel</option>
                @foreach ($rentals as $rental)
                <option value="{{ $rental->id }}" {{ old('rental_id', isset($payment) && $payment->rental_id == $rental->id ? 'selected' : '') }}>
                    {{ $rental->client->name }} - {{ $rental->machine->name }} - {{ $rental->start_date->format('d-m-Y H:i') }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="amount">Valor Pago:</label>
            <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount', isset($payment) ? $payment->amount : '') }}" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="paid_at">Data do Pagamento:</label>
            <input type="datetime-local" name="paid_at" id="paid_at" class="form-control" value="{{ old('paid_at', isset($payment) ? $payment->paid_at->format('Y-m-d\TH:i') : '') }}">
        </div>

        <button type="submit" class="btn btn-primary">{{ isset($payment) ? 'Atualizar' : 'Registrar' }} Pagamento</button>
    </form>
</div>
@endsection
