@extends('layouts.main')

@section('title', 'Painel Máquinas')

@section('content')

<div class="col-md-10 offset-md-1 dashboard-title-container">
    <h1>Minhas Máquinas</h1>
</div>

<div class="col-md-10 offset-md-1 dashboard-machines-container">
    @if(isset($machines) && count($machines) > 0)
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Status</th>
                <th scope="col">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($machines as $machine)
            <tr>
                <td scope="row">{{ $loop->index + 1 }}</td>
                <td><a href="/machines/{{ $machine->id }}">{{ $machine->name }}</a></td>
                <td>{{ $machine->status }}</td>
                <td>
                    <a href="/machines/edit/{{ $machine->id }}" class="btn btn-info edit-btn">
                        <ion-icon name="create-outline"></ion-icon> Editar
                    </a>
                    <form action="/machines/{{ $machine->id }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger delete-btn">
                            <ion-icon name="trash-outline"></ion-icon> Deletar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

<div class="col-md-10 offset-md-1">
    <a href="{{ route('machines.create') }}" class="btn btn-primary">Cadastrar Nova Máquina</a>
</div>

@endsection
