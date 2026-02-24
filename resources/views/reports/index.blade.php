@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gerar Relatório</h1>
    <form action="{{ route('reports.generate') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="start_date">Data de Início:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="end_date">Data de Término:</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="report_type">Tipo de Relatório:</label>
            <select name="report_type" id="report_type" class="form-control" required>
                <option value="client">Clientes</option>
                <option value="machine">Máquinas</option>
                <option value="rental">Locações</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Gerar Relatório</button>
    </form>
</div>
@endsection
