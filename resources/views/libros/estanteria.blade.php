@extends('plantilla.app')

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

                {{-- Bloque de Estado y Puntuación --}}
                <form action="{{ route('libros.actualizar', $book->id) }}" method="POST" class="w-full bg-orange-100 rounded-lg p-3 mb-4 border border-orange-200">
                    @csrf
                    @method('PUT')

                    <div class="flex justify-between items-center mb-2">
                        <label class="text-xs font-bold text-orange-800 uppercase">Estado:</label>
                        <select name="estado" onchange="this.form.submit()" class="text-xs border-none bg-transparent font-semibold text-gray-700 focus:ring-0 cursor-pointer">
                            <option value="por_leer" {{ $book->pivot->estado == 'por_leer' ? 'selected' : '' }}>Por leer</option>
                            <option value="leyendo" {{ $book->pivot->estado == 'leyendo' ? 'selected' : '' }}>Leyendo</option>
                            <option value="leido" {{ $book->pivot->estado == 'leido' ? 'selected' : '' }}>Leído</option>
                        </select>
                    </div>

                    <div class="flex justify-between items-center">
                        <label class="text-xs font-bold text-orange-800 uppercase">Nota:</label>
                        <select name="puntuacion" onchange="this.form.submit()" class="text-xs border-none bg-transparent font-bold text-orange-600 focus:ring-0 cursor-pointer">
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ $book->pivot->puntuacion == $i ? 'selected' : '' }}>
                                {{ $i }} 🥔
                                </option>
                                @endfor
                        </select>
                    </div>
                </form>

                <form action="{{ route('libros.eliminar', $book) }}" method="POST" class="w-full mt-auto" onsubmit="return confirm('¿Seguro que quieres borrar este libro?')">
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