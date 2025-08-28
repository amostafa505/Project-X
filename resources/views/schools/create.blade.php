<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Create School</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @include('partials.flash')

            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('schools.store') }}" class="space-y-4">
                    @csrf
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
                        <label class="block">Status</label>
                        <select name="status" class="w-full border rounded p-2">
                            <option value="active" selected>active</option>
                            <option value="inactive">inactive</option>
                        </select>
                    </div>
                    <div class="pt-4">
                        <button class="px-4 py-2 bg-blue-600 text-black rounded">Save</button>
                        <a href="{{ route('schools.index') }}" class="ms-2">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
