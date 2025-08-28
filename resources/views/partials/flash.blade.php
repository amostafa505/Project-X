@if (session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800">
        {{ session('success') }}
    </div>
@endif
@if (session('error'))
    <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
        {{ session('error') }}
    </div>
@endif
@if ($errors->any())
    <div class="mb-4 p-3 rounded bg-red-100 text-red-800">
        <strong>Validation errors:</strong>
        <ul class="list-disc ms-5 mt-2">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif
