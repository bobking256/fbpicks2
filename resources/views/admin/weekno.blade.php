<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Weekly Schedule') }}
            <div class="mt-4 text-lg">
                Week Time is the date and time that starts a ends a week and begins the next.  Typically this is a Wednesday 9am or noon time where the point spread is entered for the next week and users can begin selecting picks.
            </div>
            <div class="mt-4 text-lg">
                Pick Time is the dead line for getting picks in.
            </div>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">


                <form method="post" action="{{ route('admin.storeweekno') }}">
                    @csrf
                    <table class="table table-auto">
                        <thead>
                            <tr>
                                <th class="px-2 py-1">Wk No</th>
                                <th class="px-2 py-1"">Week Time</th>
                                <th class="px-2 py-1">Pick Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            for($i=0;$i<18;$i++){
                                $weekname = "weektime".$i;
                                $pickname = "picktime".$i;

                            @endphp
                            <tr>
                                <td class="px-2 py-1" align="center">{{ $i + 1 }}</td>
                                <td class="px-2 py-1">
                                    <input type="datetime-local" name="{{ $weekname }}" value="{{ date('Y-m-d\TH:i', strtotime($weekno[$weekname])) }}">
                                </td>
                                <td class="px-2 py-1">
                                    <input type="datetime-local" name="{{ $pickname }}" value="{{ date('Y-m-d\TH:i', strtotime($weekno[$pickname])) }}">
                                </td>
                            </tr>
                            @php
                                }
                            @endphp
                            <tr>
                                <td colspan="10">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center" colspan="3"><button class="px-4 py-2 text-blue-800 border-2 border-gray-400 hover:bg-red-400 font-bold rounded-lg" type="submit" >Submit</button></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
