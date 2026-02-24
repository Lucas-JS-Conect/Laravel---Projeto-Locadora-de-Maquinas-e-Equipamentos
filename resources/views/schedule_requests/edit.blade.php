@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Solicitação de Agendamento</h1>
    <form action="{{ route('schedule_requests.update', $scheduleRequest->id) }}" method="POST">
        @csrf
        @method('PUT')
        @include('schedule_requests.form')
        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</div>
@endsection
