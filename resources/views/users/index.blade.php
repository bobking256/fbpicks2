<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pick 5-3-1') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table table-auto px-8 py-4">
                    <thead>
                        <th>Id</th>
                        <th>Name</th>
                        <th>eMail</th>
                        <th>Pick 5-3-1</th>
                        <th>Pick All</th>
                        <th>Admin</th>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <th class="px-2 py-1">{{ $u->id }}</th>
                            <th class="px-2 py-1">{{ $u->name }}</th>
                            <th class="px-2 py-1">{{ $u->email }}</th>
                            <th class="px-2 py-1"><input disabled type="checkbox" {{ $u->pick531 ? 'checked' : '' }}></th>
                            <th class="px-2 py-1"><input disabled type="checkbox" {{ $u->pickall ? 'checked' : '' }}></th>
                            <th class="px-2 py-1"><input disabled type="checkbox" {{ $u->admin ? 'checked' : '' }}></th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
