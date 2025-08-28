<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Branches</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @include('partials.flash')

            <div class="mb-4 flex justify-between items-center">
                <a href="{{ route('branches.create') }}" class="px-4 py-2 bg-blue-600 text-black rounded">+ New Branch</a>

                <form method="GET" action="{{ route('branches.index') }}" class="flex items-center gap-2">
                    <select name="school_id" class="border rounded p-2">
                        <option value="">All Schools</option>
                        @foreach ($schools as $s)
                            <option value="{{ $s->id }}" @selected(request('school_id') == $s->id)>{{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                    <button class="px-3 py-2 border rounded">Filter</button>
                </form>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-4">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Name</th>
                            <th class="py-2">School</th>
                            <th class="py-2">Code</th>
                            <th class="py-2">Phone</th>
                            <th class="py-2">Timezone</th>
                            <th class="py-2 w-40">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($branches as $branch)
                            <tr class="border-b">
                                <td class="py-2">{{ $branch->name }}</td>
                                <td class="py-2">{{ $branch->school?->name }}</td>
                                <td class="py-2">{{ $branch->code }}</td>
                                <td class="py-2">{{ $branch->phone }}</td>
                                <td class="py-2">{{ $branch->timezone }}</td>
                                <td class="py-2 space-x-2">
                                    <a href="{{ route('branches.edit', $branch) }}" class="text-blue-600">Edit</a>
                                    <form class="inline" action="{{ route('branches.destroy', $branch) }}"
                                        method="POST" onsubmit="return confirm('Delete this branch?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-500">No branches yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $branches->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
