@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Criar Solicitação de Agendamento</h1>
    <form action="{{ route('schedule_requests.store') }}" method="POST">
        @csrf
        @include('schedule_requests.form')
        <button type="submit" class="btn btn-primary">Criar</button>
    </form>
</div>
@endsection
