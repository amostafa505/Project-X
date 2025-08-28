<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Dashboard</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <div class="text-gray-500">Schools</div>
                    <div class="text-3xl font-bold">{{ $schoolsCount }}</div>
                    <div class="mb-4 flex justify-between">
                        <a href="{{ route('schools.create') }}" class="px-4 py-2 bg-blue-600 text-Black rounded">+ New
                            School</a>
                    </div>
                </div>
                <div class="bg-white shadow sm:rounded-lg p-6">
                    <div class="text-gray-500">Branches</div>
                    <div class="text-3xl font-bold">{{ $branchesCount }}</div>
                    <a href="{{ route('branches.create') }}" class="px-4 py-2 bg-blue-600 text-black rounded">+ New
                        Branch</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
