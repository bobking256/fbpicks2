<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pick 5-3-1 Results By Week No.') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                Week No.:
                @php
                    for($i=1;$i<19;$i++){
                @endphp
                        <a href="{{ route('results.resultsbyweek',$i) }}">{{ $i }}</a> &nbsp; &nbsp;
                @php
                    }
                @endphp
                <br>
                <br>
                As of Week #{{ $week_no }}
                <br>
                <table class="table table-auto">
                    <thead>
                        <tr>
                            <th class="px-2 py-1">Name</th>
                            <th class="px-2 py-1">Cummulative Week Total</th>
                            <th class="px-2 py-1">Overall Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                        for($i=0;$i<sizeof($res);$i++){
                            if(empty($res[$i]['username'])) continue;

                            if (empty($res[$i]['weektot'])) {
                        @endphp
                            <tr>
                                <td class="px-2 py-1">{{ $res[$i]['username'] }}</td>
                                <td class="px-2 py-1">0</td>
                                <td class="px-2 py-1">{{ $res[$i]['tot'] }}</td>
                            </tr>

                        @php
                            } else {
                        @endphp
                            <tr>
                                <td class="px-2 py-1">{{ $res[$i]['username'] }}</td>
                                <td class="px-2 py-1">{{ $res[$i]['weektot']->tot }}</td>
                                <td class="px-2 py-1">{{ $res[$i]->tot }}</td>
                            </tr>
                        @php
                            }
                        }
                        @endphp
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</x-app-layout>
