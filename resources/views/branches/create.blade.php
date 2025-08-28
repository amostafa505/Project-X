<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Create Branch</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @include('partials.flash')

            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('branches.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block">School</label>
                        <select name="school_id" class="w-full border rounded p-2" required>
                            <option value="">Select school</option>
                            @foreach ($schools as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block">Name</label>
                        <input name="name" class="w-full border rounded p-2" required />
                    </div>
                    <div>
                        <label class="block">Code</label>
                        <input name="code" class="w-full border rounded p-2" />
                    </div>
                    <div>
                        <label class="block">Phone</label>
                        <input name="phone" class="w-full border rounded p-2" />
                    </div>
                    <div>
                        <label class="block">Address</label>
                        <input name="address" class="w-full border rounded p-2" />
                    </div>
                    <div>
                        <label class="block">Timezone</label>
                        <input name="timezone" class="w-full border rounded p-2" placeholder="Africa/Cairo" />
                    </div>
                    <div class="pt-4">
                        <button class="px-4 py-2 bg-blue-600 text-black rounded">Save</button>
                        <a href="{{ route('branches.index') }}" class="ms-2">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
