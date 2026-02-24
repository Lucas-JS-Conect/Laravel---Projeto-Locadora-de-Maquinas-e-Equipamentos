@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Depreciação</h1>

    <form action="{{ route('depreciations.update', $depreciation->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="machine_id">Máquina:</label>
            <select name="machine_id" id="machine_id" class="form-control" required>
                @foreach ($machines as $machine)
                    <option value="{{ $machine->id }}" {{ $depreciation->machine_id == $machine->id ? 'selected' : '' }}>{{ $machine->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="residual_value">Taxa de Depreciação:</label>
            <select name="residual_value" id="residual_value" class="form-control" required onchange="calculateDepreciation()">
                <option value="0.20" {{ $depreciation->residual_value == 0.20 ? 'selected' : '' }}>Equipamentos de informática (20%)</option>
                <option value="0.20" {{ $depreciation->residual_value == 0.20 ? 'selected' : '' }}>Equipamentos de comunicação (20%)</option>
                <option value="0.10" {{ $depreciation->residual_value == 0.10 ? 'selected' : '' }}>Móveis e utensílios (10%)</option>
                <option value="0.04" {{ $depreciation->residual_value == 0.04 ? 'selected' : '' }}>Edificações (4%)</option>
                <option value="0.15" {{ $depreciation->residual_value == 0.15 ? 'selected' : '' }}>Ferramentas (15%)</option>
                <option value="0.20" {{ $depreciation->residual_value == 0.20 ? 'selected' : '' }}>Veículos (20%)</option>
                <option value="0.10" {{ $depreciation->residual_value == 0.10 ? 'selected' : '' }}>Máquinas e equipamentos (10%)</option>
                <option value="0.25" {{ $depreciation->residual_value == 0.25 ? 'selected' : '' }}>Caminhões (25%)</option>
                <option value="0.10" {{ $depreciation->residual_value == 0.10 ? 'selected' : '' }}>Instalações (10%)</option>
            </select>
        </div>

        <div class="form-group">
            <label for="initial_value">Valor Inicial:</label>
            <input type="number" name="initial_value" id="initial_value" class="form-control" step="0.01" value="{{ $depreciation->initial_value }}" required onchange="calculateDepreciation()">
        </div>

        <div class="form-group">
            <label for="useful_life_years">Vida Útil (anos):</label>
            <input type="number" name="useful_life_years" id="useful_life_years" class="form-control" value="{{ $depreciation->useful_life_years }}" required onchange="calculateDepreciation()">
        </div>

        <div class="form-group">
            <label for="amount">Valor da Depreciação:</label>
            <input type="number" name="amount" id="amount" class="form-control" step="0.01" value="{{ $depreciation->amount }}" readonly>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>

<script>
    function calculateDepreciation() {
        let initial_value = parseFloat(document.getElementById('initial_value').value);
        let residual_value = parseFloat(document.getElementById('residual_value').value);
        let useful_life_years = parseInt(document.getElementById('useful_life_years').value);

        if (!isNaN(initial_value) && !isNaN(residual_value) && !isNaN(useful_life_years) && useful_life_years > 0) {
            let depreciation_amount = (initial_value - residual_value) / useful_life_years;
            document.getElementById('amount').value = depreciation_amount.toFixed(2);
        }
    }
</script>
@endsection
