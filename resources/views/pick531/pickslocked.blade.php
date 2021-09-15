<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pick 5-3-1') }}  for Week No. {{ $weekno }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-4">


            <table class="table table-striped table-condensed">
                <thead>
                    <tr>
                        <th class="px-4 py-1">Name</th>
                        <th class="px-4 py-1">5 Pt</th>
                        <th class="px-4 py-1">3 Pt</th>
                        <th class="px-4 py-1">1 Pt</th>
                        <th class="px-4 py-1">Bonus</th>
                        <th class="px-4 py-1">Bonus Remaining</th>
                        <th class="px-4 py-1">Total Points</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($x as $i)
                    <tr>
                        @foreach($i as $k)
                        <td class="px-4 py-1">{{ $k }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>

            </div>
        </div>
    </div>
</x-app-layout>
