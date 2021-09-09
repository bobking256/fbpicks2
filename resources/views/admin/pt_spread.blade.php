<x-app-layout>
    @isset($success)
    <div class="text-green-800">$success</div>
    @endisset
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Point Spreads') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
                <div class="font-bold py-6 px-4">
                    Week No.: {{ $weekno }}
                </div>
                <form method="post" action="{{ route('admin.updatepointspread') }}">
                    @csrf
                    <table class="table table-auto">
                        <thead>
                            <tr>
                                <th>Default</th>
                                <th>No<br>Line</th>
                                <th valign="middle" align="center">Away Team</th>
                                <th valign="middle" align="center">F A V</th>
                                <th valign="middle" align="center">Final<br>Score</th>
                                <th valign="middle" align="center">Point<br>Spread</th>
                                <th valign="middle" align="center">F A V</th>
                                <th valign="middle" align="center">Home Team</th>
                                <th valign="middle" align="center">Final<br>Score</th>
                                <th valign="middle" align="center">Game Date</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($schedule as $i=>$s)
                            <tr>
                                <td valign="middle" align="right">
                                @php
                                    $name = "default_game".$i;
                                @endphp
                                    <select name="{{ $name }}">
                                        <option value="0" {{ $data[$name] == "0" ? 'selected' : '' }}>0</option>
                                        <option value="5" {{ $data[$name] == "5" ? 'selected' : '' }}>5</option>
                                        <option value="3" {{ $data[$name] == "3" ? 'selected' : '' }}>3</option>
                                        <option value="1" {{ $data[$name] == "1" ? 'selected' : '' }}>1</option>
                                    </select>
                                </td>
                                <td align="center" valign="middle">
                                @php
                                    $name="noline".$i;
                                @endphp
                                    <input name="{{ $name }}" type="checkbox" {{ $data[$name] ? 'checked' : '' }} }}" />
                                </td>
                                <td align="left" valign="middle">
                                @php
                                    $name="awayteam_id".$i;
                                @endphp
                                    <select name="{{ $name }}">
                                        @foreach($teams as $t)
                                            <option value="{{ $t['id'] }}" {{ $t['id'] == $data[$name] ? 'selected' : '' }}>{{ $t['name'] }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td align="center" valign="middle">
                                @php
                                    $awayteam = "awayteam_id".$i;
                                    $name="favteam_id".$i;
                                @endphp
                                    <input type="radio" name="{{ $name }}" value="{{ $data[$awayteam] }}" {{ $data[$awayteam] == $data[$name] ? 'checked' : '' }}>
                                </td>
                                <td align="center" valign="middle">
                                @php
                                    $name="awayteam_pts".$i;
                                @endphp
                                    <input name="{{ $name }}" type="text" value="{{ $data[$name] }}" size="4">
                                </td>
                                <td align="center" valign="middle">
                                @php
                                    $name="point_spread".$i;
                                @endphp
                                    <input name="{{ $name }}" type="text" value="{{ $data[$name] }}" size="4">
                                </td>
                                <td align="center" valign="middle">
                                @php
                                    $hometeam = "hometeam_id".$i;
                                    $name="favteam_id".$i;
                                @endphp
                                    <input type="radio" name="{{ $name }}" value="{{ $data[$hometeam] }}" {{ $data[$hometeam]  == $data[$name] ? 'checked' : '' }}>
                                </td>
                                <td align="left" valign="middle">
                                @php
                                    $name = "hometeam_id".$i;
                                @endphp
                                    <select name="{{ $name }}">
                                        @foreach($teams as $t)
                                        <option value="{{ $t['id'] }}" {{ $t['id'] == $data[$name] ? 'selected' : '' }}>{{ $t['name'] }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td align="center" valign="middle">
                                @php
                                    $name="hometeam_pts".$i;
                                @endphp
                                    <input name="{{ $name }}" type="text" value="{{ $data[$name] }}" size="4">
                                </td>
                                <td align="center" valign="middle">
                                @php
                                    $name="gamedate".$i;
                                @endphp
                                    <input name="{{ $name }}" type="datetime" value="{{ $s['gamedate'] }}">
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td colspan="10">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="10">Current Weekly State</td>
                            </tr>

                            <tr>
                                <td colspan="10">

                                    <div class="mt-2">
                                        <div>
                                            <label class="inline-flex items-center">
                                                <input class="form-radio" type="radio" name="state" value="0" {{ $state == "0" ? 'checked' : '' }}>
                                                <span class="ml-2">Initial State, Schedule Entered, No Point Spread</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="inline-flex items-center">
                                                <input class="form-radio" type="radio" name="state" value="1" {{ $state == "1" ? 'checked' : '' }}>
                                                <span class="ml-2">Point Spread Added, Users Can Enter Picks</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="inline-flex items-center">
                                                <input class="form-radio" type="radio" name="state" value="2" {{ $state == "2" ? 'checked' : '' }}>
                                                <span class="ml-2">Lock Picks, Process Default Picks</span>
                                            </label>
                                        </div>
                                        <div>
                                            <label class="inline-flex items-center">
                                                <input class="form-radio" type="radio" name="state" value="3" {{ $state == "3" ? 'checked' : '' }}>
                                                <span class="ml-2">Picks are Locked</span>
                                            </label>
                                        </div>
                                        <div>
                                                <label class="inline-flex items-center">
                                                    <input class="form-radio" type="radio" name="state" value="4" {{ $state == "4" ? 'checked' : '' }}>
                                                    <span class="ml-2">Final Scores Entered, Process Results</span>
                                                </label>
                                        </div>
                                        <div>
                                                <label class="inline-flex items-center">
                                                    <input class="form-radio" type="radio" name="state" value="5" {{ $state == "5" ? 'checked' : '' }}>
                                                    <span class="ml-2">Results Processed</span>
                                                </label>
                                        </div>
                                        <div>
                                                <label class="inline-flex items-center">
                                                    <input class="form-radio" type="radio" name="state" value="6" {{ $state == "6" ? 'checked' : '' }}>
                                                    <span class="ml-2">Delete Weekly Default Picks</span>
                                                </label>
                                        </div>
                                        <div>
                                            <label class="inline-flex items-center">
                                                <input class="form-radio" type="radio" name="state" value="7" {{ $state == "7" ? 'checked' : '' }}>
                                                <span class="ml-2">Delete Weekly Results</span>
                                            </label>
                                        </div>
                                        </div>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="10">&nbsp;</td>
                            </tr>
                            <tr>
                                <td align="center" colspan="10"><button type="submit" class="border-gray-500 rounded-lg px-4 py-2 text-black hover:bg-red-500">Submit</button></td>
                            </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
