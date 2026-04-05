@extends('plantilla.app')

@section('content')
<div class="container mx-auto p-6">

    {{-- Contenedor para alertas dinámicas de JavaScript --}}
    <div id="alerta-ajax" class="hidden max-w-7xl mx-auto mb-4">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center">
            <p id="alerta-mensaje" class="font-bold"></p>
        </div>
    </div>

    {{-- El buscador de la vista --}}
    <div class="mb-10 max-w-2xl mx-auto">
        <form action="{{ route('libros.buscar') }}" method="GET" class="flex gap-2">
            <input type="text" name="query" placeholder="Busca otro libro..."
                class="flex-1 p-3 rounded-lg border-2 border-orange-200 focus:border-orange-500 outline-none"
                value="{{ request('query') }}">
            <button type="submit" class="bg-orange-500 text-white px-6 py-3 rounded-lg font-bold hover:bg-orange-600 transition">
                🔍 Buscar
            </button>
        </form>
    </div>

    <div class="lista-resultados-busqueda">
        @forelse($libros as $libro)
        @php
        $info = $libro['volumeInfo'] ?? [];
        $titulo = $info['title'] ?? 'Sin título';
        $autor = implode(', ', $info['authors'] ?? ['Desconocido']);
        $portada = $info['imageLinks']['thumbnail'] ?? 'https://via.placeholder.com/150';
        $genero = isset($info['categories']) ? $info['categories'][0] : 'General';
        @endphp

        <div class="fila-libro">
            <img src="{{ $portada }}" class="img-portada-libro">

            <div class="info-libro-caja">
                <h3 class="titulo-libro">{{ $titulo }}</h3>
                <p class="autor-libro">{{ $autor }}</p>
            </div>

            <span class="genero-libro-etiqueta">{{ $genero }}</span>

            <div class="acciones-libro">
                @auth
                {{-- CAMBIO: Ya no es un FORM, ahora es un botón con DATA-ATTRIBUTES --}}
                <button type="button"
                    class="btn-añadir-estanteria"
                    onclick="añadirLibroSinRecargar(this)"
                    data-title="{{ $titulo }}"
                    data-author="{{ $autor }}"
                    data-genre="{{ $genero }}"
                    data-cover="{{ $portada }}">
                    + Añadir
                </button>
                @endauth
            </div>
        </div>
        @empty
        <p class="text-center text-gray-500 italic">No hay resultados para tu búsqueda. 🥔</p>
        @endforelse
    </div>
</div>

{{-- SCRIPT PARA LA MAGIA SIN RECARGA --}}
<script>
    function añadirLibroSinRecargar(btn) {
        // 1. Deshabilitar el botón para evitar clics dobles
        btn.disabled = true;
        btn.innerText = "Guardando...";

        // 2. Preparar los datos
        const datos = {
            title: btn.getAttribute('data-title'),
            author: btn.getAttribute('data-author'),
            genre: btn.getAttribute('data-genre'),
            cover_url: btn.getAttribute('data-cover'),
            _token: '{{ csrf_token() }}' // El token de seguridad de Laravel
        };

        // 3. Petición silenciosa a Laravel
        fetch("{{ route('libros.guardar') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(datos)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Mostrar la alerta sin recargar
                    const alertaDiv = document.getElementById('alerta-ajax');
                    const alertaMensaje = document.getElementById('alerta-mensaje');

                    alertaMensaje.innerText = "✨ " + data.message;
                    alertaDiv.classList.remove('hidden');

                    // Cambiar aspecto del botón
                    btn.innerText = "✅ En estantería";
                    btn.style.backgroundColor = "#10b981"; // Verde
                    btn.style.color = "white";

                    // Ocultar alerta después de 3 segundos
                    setTimeout(() => {
                        alertaDiv.classList.add('hidden');
                    }, 3000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.disabled = false;
                btn.innerText = "+ Añadir";
                alert("Algo salió mal al guardar el libro.");
            });
    }
</script>
@endsection