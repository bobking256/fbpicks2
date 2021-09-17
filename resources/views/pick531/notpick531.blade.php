<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Not Yet Picked 5-3-1') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table table-auto" px-6 py-2">
                    <thead>
                        <tr>
                            <th class="px-4 py-1">Name</th>
                            <th class="px-4 py-1">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $u)
                        <tr>
                            <td class="px-4 py-1">{{ $u['name'] }}</td>
                            <td class="px-4 py-1">{{ $u['email']}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="container mx-auto">
            <a href="{{ route('pick531.emailnotpicked') }}"><button class="bg-red-200 font-bold hover:bg-red-500 px-4 py-2 border-2 border-gray-400 rounded-lg">Email Not Picked Users</button></a>
    </div>
</x-app-layout>
