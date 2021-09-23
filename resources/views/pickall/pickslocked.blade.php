<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pick All') }}  for Week No. {{ $weekno }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 sm:text-xs md:text-xs lg:text-sm">
            <div class="bg-white overflow-x-auto shadow-xl sm:rounded-lg px-6 py-4">
                <table class="table table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-2 py-1">Name</th>
                            <th class="px-2 py-1">P1</th>
                            <th class="px-2 py-1">P2</th>
                            <th class="px-2 py-1">P3</th>
                            <th class="px-2 py-1">P4</th>
                            <th class="px-2 py-1">P5</th>
                            <th class="px-2 py-1">P6</th>
                            <th class="px-2 py-1">P7</th>
                            <th class="px-2 py-1">P8</th>
                            <th class="px-2 py-1">P9</th>
                            <th class="px-2 py-1">P10</th>
                            <th class="px-2 py-1">P11</th>
                            <th class="px-2 py-1">P12</th>
                            <th class="px-2 py-1">P13</th>
                            <th class="px-2 py-1">P14</th>
                            <th class="px-2 py-1">P15</th>
                            <th class="px-2 py-1">P16</th>
                            <th class="px-2 py-1">MNF Total</th>
                            <th class="px-2 py-1">Yr Tot</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            for($i=0;$i<sizeof($x);$i++){
                        @endphp
                            <tr>
                            @php
                                for($k=0;$k<19;$k++){
                            @endphp
                                <td class="px-2 py-1">{{ $x[$i][$k] }}</td>
                            @php
                                }
                            @endphp
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
