@extends('layouts.app')

@section('title', 'Nuevo Transporte')

@section('content_header')
    <h1>Nuevo Transporte</h1>
@stop

@section('content')
<div class="col-md-6">
    <div class="card card-primary">
        <div class="card-header"><h3 class="card-title">Alta de Transporte</h3></div>
        <form action="{{ route('transportes.store') }}" method="POST">
            @csrf
            <div class="card-body">
                <label>Razón Social</label>
                <input name="razon_social" class="form-control" required>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">Guardar</button>
                <a href="{{ route('transportes.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@stop
