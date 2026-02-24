@extends('layouts.main')

@section('title', 'Lista de Manutenções')

@section('content')
<div class="container">
    <h1>Manutenções</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(count($maintenances) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Máquina</th>
                    <th>Data de Início</th>
                    <th>Descrição</th>
                    <th>Status da Máquina</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($maintenances as $maintenance)
                    <tr>
                        <td>{{ $maintenance->machine->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($maintenance->start_date)->format('d/m/Y H:i') }}</td>
                        <td>{{ $maintenance->description }}</td>
                        <td>{{ $maintenance->machine->status }}</td>
                        <td>{{ $maintenance->status }}</td>
                        <td>
                            @if(!$maintenance->end_date && $maintenance->machine->status != 'Alugada')
                                <form action="{{ route('maintenances.finish', ['maintenance' => $maintenance->id]) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Tem certeza que deseja finalizar esta manutenção?')">Finalizar</button>
                                </form>
                            @else
                                <span class="text-success">Finalizado</span>
                            @endif

                            <a href="{{ route('maintenances.show', ['maintenance' => $maintenance->id]) }}" class="btn btn-info btn-sm">Ver</a>
                            <a href="{{ route('maintenances.edit', ['maintenance' => $maintenance->id]) }}" class="btn btn-primary btn-sm">Editar</a>
                            <form action="{{ route('maintenances.destroy', ['maintenance' => $maintenance->id]) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir esta manutenção?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            Não há manutenções registradas.
        </div>
    @endif

    <a href="{{ route('maintenances.create') }}" class="btn btn-primary">Adicionar Manutenção</a>
</div>
@endsection
