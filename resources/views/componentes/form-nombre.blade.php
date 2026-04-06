<div class="bg-white/70 backdrop-blur-md p-6 rounded-2xl border border-orange-100 shadow-sm mb-6">
    <h3 class="libro-titulo-compacto mb-4">Cambiar nombre de usuario</h3>

    <form action="{{ route('perfil.actualizarNombre') }}" method="POST" class="flex flex-col gap-4">
        @csrf
        <div>
            <label class="text-stone-500 text-sm font-bold italic mb-1 block">¿Cómo te llamamos ahora?</label>
            <input type="text" name="name"
                value="{{ auth()->user()->name }}"
                class="input-buscador-ancho w-full !text-base !py-2"
                required>
            @error('name')
            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="btn-compacto-add">
                💾 Actualizar Nombre
            </button>
        </div>
    </form>
</div>