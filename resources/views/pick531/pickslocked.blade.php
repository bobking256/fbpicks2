<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pick 5-3-1') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-4">


            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>5 Pt</th>
                        <th>3 Pt</th>
                        <th>1 Pt</th>
                        <th>Bonus</th>
                        <th>Bonus Remaining</th>
                        <th>Total Points</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($x as $i)
                    <tr>
                        @foreach($i as $k)
                        <td><{{ $k }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>

            </div>
        </div>
    </div>
</x-app-layout>
