<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-700 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table table-auto px-8 py-4">
                    <thead>
                        <th class="px-2 py-1">Id</th>
                        <th class="px-2 py-1">Name</th>
                        <th class="px-2 py-1">eMail</th>
                        <th class="px-2 py-1">Pick 5-3-1</th>
                        <th class="px-2 py-1">Pick All</th>
                        <th class="px-2 py-1">Admin</th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td class="px-2 py-1"><a class="underline text-blue-700" href="{{ route('admin.edituser', $u->id) }}">{{ $u->id }}</a</td>
                            <td class="px-2 py-1">{{ $u->name }}</td>
                            <td class="px-2 py-1">{{ $u->email }}</td>
                            <th class="px-2 py-1"><input disabled type="checkbox" {{ $u->pick531 ? 'checked' : '' }}></th>
                            <th class="px-2 py-1"><input disabled type="checkbox" {{ $u->pickall ? 'checked' : '' }}></th>
                            <th class="px-2 py-1"><input disabled type="checkbox" {{ $u->admin ? 'checked' : '' }}></th>
                            <td class="px-2 py-1"><a href="{{ route('admin.pick531', $u->id) }}" class="underline text-blue-500 hover:text-red-700">Pick 5-3-1</a></td>
                            <td class="px-2 py-1"><a href="{{ route('admin.pickall', $u->id) }}" class="underline text-blue-500 hover:text-red-700">Pick All</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
