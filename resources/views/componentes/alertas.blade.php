@if(session('success'))
<div class="max-w-7xl mx-auto mb-4 px-4 sm:px-6 lg:px-8">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center">
        <p class="font-bold">✨ {{ session('success') }}</p>
        <button onclick="this.parentElement.parentElement.style.display='none'" class="text-green-500 hover:text-green-800">×</button>
    </div>
</div>
@endif

@if(session('error'))
<div class="max-w-7xl mx-auto mb-4 px-4 sm:px-6 lg:px-8">
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm flex justify-between items-center">
        <p class="font-bold">⚠️ {{ session('error') }}</p>
        <button onclick="this.parentElement.parentElement.style.display='none'" class="text-red-500 hover:text-red-800">×</button>
    </div>
</div>
@endif