{{-- Mensaje de Éxito --}}
@if(session('success'))
<div class="alerta-contenedor alerta-exito">
    <div class="alerta-contenido">
        <span>✨ {{ session('success') }}</span>
        <button onclick="this.parentElement.parentElement.style.display='none'" class="alerta-cerrar">×</button>
    </div>
</div>
@endif

{{-- Mensaje de Error --}}
@if(session('error'))
<div class="alerta-contenedor alerta-error">
    <div class="alerta-contenido">
        <span>⚠️ {{ session('error') }}</span>
        <button onclick="this.parentElement.parentElement.style.display='none'" class="alerta-cerrar">×</button>
    </div>
</div>
@endif

{{-- Alerta para AJAX --}}
<div id="alerta-ajax" class="alerta-ajax-flotante" style="display: none;">
    <div id="alerta-mensaje">
        {{-- El JS escribirá aquí --}}
    </div>
</div>