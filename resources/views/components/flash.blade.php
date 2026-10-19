{{-- Message de confirmation affiché après une action (redirect()->with('success', '...')). --}}
@if (session('success'))
    <div x-data="{ visible: true }" x-show="visible" role="status"
         class="mb-6 flex items-start justify-between gap-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-900">
        <p>{{ session('success') }}</p>
        <button type="button" class="rounded text-green-800 hover:text-green-950 focus-visible:outline-2 focus-visible:outline-green-700" @click="visible = false">
            <span class="sr-only">Fermer le message</span>
            <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" /></svg>
        </button>
    </div>
@endif

@if (session('error'))
    <div role="alert" class="mb-6 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900">
        <p>{{ session('error') }}</p>
    </div>
@endif
