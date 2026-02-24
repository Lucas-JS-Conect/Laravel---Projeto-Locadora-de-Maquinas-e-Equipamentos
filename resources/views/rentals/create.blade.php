@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Realizar Locação</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form action="{{ route('rentals.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="machine_id">Selecione a Máquina:</label>
            <select name="machine_id" id="machine_id" class="form-control">
                @foreach ($machines as $machine)
                    <option value="{{ $machine->id }}" {{ old('machine_id') == $machine->id ? 'selected' : '' }}>
                        {{ $machine->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="client_id">Selecione o Cliente:</label>
            <select name="client_id" id="client_id" class="form-control">
                @foreach ($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="payment_method">Forma de Pagamento:</label>
            <select name="payment_method" id="payment_method" class="form-control">
                <option value="dinheiro">Dinheiro</option>
                <option value="cartao_credito">Cartão de Crédito</option>
                <option value="cartao_debito">Cartão de Débito</option>
                <option value="cheque">Cheque</option>
                <option value="pix">PIX</option>
            </select>
        </div>

        <div id="cartao_credito_options" style="display: none;">
            <div class="form-group">
                <label for="installments">Número de Parcelas:</label>
                <select name="installments" id="installments" class="form-control">
                    @for ($i = 1; $i <= 5; $i++) 
                        <option value="{{ $i }}">{{ $i }} vezes</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="start_date">Data de Início:</label>
            <input type="datetime-local" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
        </div>

        <div class="form-group">
            <label for="end_date">Data de Término:</label>
            <input type="datetime-local" name="end_date" id="end_date" class="form-control" value="{{ old('end_date') }}">
        </div>

        <div class="form-group">
            <label for="hours_rented">Horas de Locação:</label>
            <input type="number" name="hours_rented" id="hours_rented" class="form-control" value="{{ old('hours_rented', '1') }}" min="1">
        </div>

        <div class="form-group">
            <label for="total_amount">Valor Total:</label>
            <input type="text" name="total_amount" id="total_amount" class="form-control" value="{{ old('total_amount', '0.00') }}" readonly>
        </div>

        <div class="form-group">
            <label for="paid">Pagamento Realizado:</label>
            <select name="paid" id="paid" class="form-control">
                <option value="1">Sim</option>
                <option value="0">Não</option>
            </select>
        </div>

        <div class="form-group">
            <label for="returned">Máquina Devolvida:</label>
            <select name="returned" id="returned" class="form-control">
                <option value="1">Sim</option>
                <option value="0" selected>Não</option>
            </select>
        </div>

        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

        <div class="row">
            <div class="col">
                <button type="submit" class="btn btn-primary btn-block">Salvar Locação</button>
            </div>
            <div class="col">
                <a href="{{ route('machines.dashboard') }}" class="btn btn-secondary btn-block">Voltar para Tela de Registros de Máquinas</a>
            </div>
        </div>

        @if ($machines->where('available', true)->isEmpty())
            <a href="{{ route('schedule_requests.create') }}" class="btn btn-warning mt-3 btn-block">Solicitar Agendamento</a>
        @endif
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentMethod = document.getElementById('payment_method');
        const cartaoCreditoOptions = document.getElementById('cartao_credito_options');

        paymentMethod.addEventListener('change', function() {
            if (paymentMethod.value === 'cartao_credito') {
                cartaoCreditoOptions.style.display = 'block';
            } else {
                cartaoCreditoOptions.style.display = 'none';
            }
        });


        const machineSelect = document.getElementById('machine_id');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const hoursRentedInput = document.getElementById('hours_rented');
        const totalAmountInput = document.getElementById('total_amount');

        machineSelect.addEventListener('change', updateTotalAmount);
        startDateInput.addEventListener('change', updateTotalAmount);
        endDateInput.addEventListener('change', updateTotalAmount);
        hoursRentedInput.addEventListener('input', updateTotalAmount);

        function updateTotalAmount() {
            const machineId = machineSelect.value;
            const startDate = startDateInput.value;
            const endDate = endDateInput.value;
            const hoursRented = hoursRentedInput.value;

            // Realiza uma requisição AJAX para obter o valor total com base na máquina, data de início, término e horas locadas
            fetch(`/calculate-total/${machineId}?start_date=${startDate}&end_date=${endDate}&hours_rented=${hoursRented}`)
                .then(response => response.json())
                .then(data => {
                    totalAmountInput.value = data.total_amount.toFixed(2);
                })
                .catch(error => {
                    console.error('Erro ao calcular o valor total:', error);
                });
        }
    });
</script>
@endsection
