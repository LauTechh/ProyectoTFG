{{-- Cambia el principio por esto --}}
@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-6">
        <div class="welcome-text-container">
            <h2 class="text-2xl font-bold">🔍 Buscar Libros para mi Colección</h2>
            <form action="{{ route('books.search') }}" method="GET" class="mt-4">
                <input type="text" name="query" placeholder="Ej: Harry Potter..." 
                       class="rounded-lg p-2 border-2 border-pink-200 text-black">
                <button type="submit" class="btn-primary">Buscar</button>
            </form>
        </div>
    </div>
@endsection {{-- Y el final por esto --}}