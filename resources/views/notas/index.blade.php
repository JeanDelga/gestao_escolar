@extends('adminlte::page')

@section('title', 'Notas')

@section('content_header')
    <h1>Notas</h1>
@stop

@section('content')
    <p>Bem-vindo ao módulo de lançamento de notas.</p>
    <a href="{{ route('notas.create') }}" class="btn btn-primary">Lançar Notas</a>
@stop
