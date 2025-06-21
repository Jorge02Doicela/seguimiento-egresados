<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.app')

@section('content')
<h1>Panel de Administración</h1>
<p>Bienvenido, {{ auth()->user()->name }}. Estás en la zona de admins.</p>
@endsection
