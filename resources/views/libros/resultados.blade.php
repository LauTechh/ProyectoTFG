@extends('plantilla.app')

@section('content')
<div class="container mx-auto p-6">

    {{-- Contenedor para alertas dinámicas --}}
    <div id="alerta-ajax" class="hidden max-w-7xl mx-auto mb-8">
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center italic">
            <p id="alerta-mensaje" class="font-bold"></p>
        </div>
    </div>

    {{-- --- EL NUEVO BUSCADOR DE LA PÁGINA (ARMONIZADO) --- --}}
    <div class="contenedor-buscador-pagina">
        <form action="{{ route('libros.buscar') }}" method="GET" class="formulario-buscador-ancho">
            <input type="text" name="query" placeholder="Busca otro tesoro para tu estantería..."
                class="input-buscador-ancho"
                value="{{ request('query') }}">
            <button type="submit" class="btn-buscador-ancho">
                🔍 Buscar
            </button>
        </form>
    </div>

    {{-- --- LA LISTA DE LIBROS COMPACTA Y ARMONIZADA --- --}}
    <div class="lista-libros-busqueda" style="gap: 0.75rem;">
        @forelse($libros as $libro)
        @php
        $info = $libro['volumeInfo'] ?? [];
        $titulo = $info['title'] ?? 'Sin título';
        $autor = implode(', ', $info['authors'] ?? ['Desconocido']);

        /* Portada con placeholder si no existe */
        $portada = isset($info['imageLinks']['thumbnail'])
        ? $info['imageLinks']['thumbnail']
        : 'https://via.placeholder.com/150x225/f97316/ffffff?text=Libro+sin+Portada';

        $genero = isset($info['categories']) ? $info['categories'][0] : 'Lectura';
        @endphp

        <div class="fila-libro-compacta">
            {{-- Portada --}}
            <img src="{{ $portada }}" class="img-portada-compacta" alt="Portada de {{ $titulo }}">

            {{-- Info Central --}}
            <div class="info-libro-compacta">
                <h3 class="libro-titulo-compacto">{{ $titulo }}</h3>
                <p class="libro-autor-compacto">{{ $autor }}</p>
            </div>

            {{-- Género --}}
            <span class="genero-etiqueta-compacta">
                {{ $genero }}
            </span>

            {{-- Acciones --}}
            <div class="acciones-libro">
                @auth
                <button type="button"
                    class="btn-compacto-add"
                    onclick="añadirLibroSinRecargar(this)"
                    data-title="{{ $titulo }}"
                    data-author="{{ $autor }}"
                    data-genre="{{ $genero }}"
                    data-cover="{{ $portada }}">
                    + Añadir
                </button>
                @else
                <button type="button"
                    class="btn-compacto-add btn-compacto-invitado"
                    onclick="alertaInvitado()">
                    + Añadir
                </button>
                @endauth
            </div>
        </div>
        @empty
        <div class="text-center py-10">
            <p class="text-gray-500 italic text-lg">No hay resultados para tu búsqueda. 🥔💨</p>
        </div>
        @endforelse
    </div>
</div>

<script>
    function alertaInvitado() {
        alert("¡Hola, patata! 🥔\n\nPara añadir libros a tu biblioteca personal necesitas una cuenta.");
    }

    function añadirLibroSinRecargar(btn) {
        btn.disabled = true;
        btn.innerText = "Guardando...";
        const datos = {
            title: btn.getAttribute('data-title'),
            author: btn.getAttribute('data-author'),
            genre: btn.getAttribute('data-genre'),
            cover_url: btn.getAttribute('data-cover'),
            _token: '{{ csrf_token() }}'
        };
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
                    const alertaDiv = document.getElementById('alerta-ajax');
                    const alertaMensaje = document.getElementById('alerta-mensaje');
                    alertaMensaje.innerText = "✨ " + data.message;
                    alertaDiv.classList.remove('hidden');
                    btn.innerText = "✅ Guardado";
                    btn.className = "btn-compacto-add bg-green-500";
                    setTimeout(() => {
                        alertaDiv.classList.add('hidden');
                    }, 3000);
                }
            });
    }
</script>
@endsection