<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Schools</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @include('partials.flash')

            <div class="mb-4 flex justify-between">
                <a href="{{ route('schools.create') }}" class="px-4 py-2 bg-blue-600 text-Black rounded">+ New School</a>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-4">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Name</th>
                            <th class="py-2">Code</th>
                            <th class="py-2">Phone</th>
                            <th class="py-2">Status</th>
                            <th class="py-2 w-40">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($schools as $school)
                            <tr class="border-b">
                                <td class="py-2">{{ $school->name }}</td>
                                <td class="py-2">{{ $school->code }}</td>
                                <td class="py-2">{{ $school->phone }}</td>
                                <td class="py-2">{{ $school->status }}</td>
                                <td class="py-2 space-x-2">
                                    <a href="{{ route('schools.edit', $school) }}" class="text-blue-600">Edit</a>
                                    <form class="inline" action="{{ route('schools.destroy', $school) }}" method="POST"
                                        onsubmit="return confirm('Delete this school?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-4 text-center text-gray-500">No schools yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $schools->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
