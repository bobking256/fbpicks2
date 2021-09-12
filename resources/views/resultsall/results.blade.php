<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pick 5-3-1 Results') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <table class="table table-auto">
                    <thead>
                        <tr>
                            <th class="px-2 py-1">Name</th>
                            <th class="px-2 py-1">Points</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                          for($i=0;$i<sizeof($res);$i++){

                              if(empty($res[$i]['name'])) continue;

                        @endphp
                        <tr>
                            <td class="px-2 py-1">{{ $res[$i]['name'] }}</td>
                            <td class="px-2 py-1">{{ $res[$i]['tot'] }}</td>
                        </tr>
                        @php
                          }
                        @endphp
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
