<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit Branch</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @include('partials.flash')

            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('branches.update', $branch) }}" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block">School</label>
                        <select name="school_id" class="w-full border rounded p-2" required>
                            @foreach ($schools as $s)
                                <option value="{{ $s->id }}" @selected($s->id == $branch->school_id)>{{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block">Name</label>
                        <input name="name" class="w-full border rounded p-2" value="{{ old('name', $branch->name) }}"
                            required />
                    </div>
                    <div>
                        <label class="block">Code</label>
                        <input name="code" class="w-full border rounded p-2"
                            value="{{ old('code', $branch->code) }}" />
                    </div>
                    <div>
                        <label class="block">Phone</label>
                        <input name="phone" class="w-full border rounded p-2"
                            value="{{ old('phone', $branch->phone) }}" />
                    </div>
                    <div>
                        <label class="block">Address</label>
                        <input name="address" class="w-full border rounded p-2"
                            value="{{ old('address', $branch->address) }}" />
                    </div>
                    <div>
                        <label class="block">Timezone</label>
                        <input name="timezone" class="w-full border rounded p-2"
                            value="{{ old('timezone', $branch->timezone) }}" />
                    </div>
                    <div class="pt-4">
                        <button class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                        <a href="{{ route('branches.index') }}" class="ms-2">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
