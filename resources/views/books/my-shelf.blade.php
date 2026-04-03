@extends('layouts.app')

@section('content')
<div class="py-12 bg-orange-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-orange-900 mb-6 border-b-2 border-orange-200 pb-2">
            Mi Estantería de Patatas 🥔
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            {{-- RECUERDA: El @forelse es el que crea la variable $book --}}
            @forelse($books as $book)
                <div class="bg-white rounded-xl shadow-lg border border-orange-200 p-5 flex flex-col items-center transform hover:scale-105 transition duration-300">
                    <div class="mb-4 bg-gray-100 rounded-lg p-2 shadow-inner">
                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="w-32 h-48 object-cover rounded shadow-md">
                    </div>
                    
                    <div class="text-center flex-grow w-full">
                        <h3 class="text-lg font-extrabold text-gray-900 leading-tight mb-1">{{ $book->title }}</h3>
                        <p class="text-sm font-medium text-orange-700 italic mb-4">{{ $book->author }}</p>
                    </div>

                    <form action="{{ route('books.destroy', $book) }}" method="POST" class="w-full mt-auto" onsubmit="return confirm('¿Seguro que quieres borrar este libro?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-lg text-xs font-bold hover:bg-red-600 shadow-sm transition">
                            Eliminar de mi red
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full text-center py-10 bg-white rounded-xl border-2 border-dashed border-orange-200">
                    <p class="text-gray-400">Tu estantería está vacía... ¡Busca una patata-libro para empezar!</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection