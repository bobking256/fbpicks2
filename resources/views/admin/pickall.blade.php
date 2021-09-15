<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pick All - Home Teams in Caps') }} For: {{ $user->name }}  for Week No. {{ $weekno }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-6 py-4">


                <table class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <th class="px-2 py-1" valign="middle" ></th>
                            <th class="px-2 py-1" valign="middle" colspan="2" valign="top"><span class="style1">Favorite</span></th>
                            <th class="px-2 py-1" valign="middle" valign="top"><div align="center" class="style1">Points</div></th>
                            <th class="px-2 py-1" valign="middle" colspan="2" valign="top"><div align="right" class="style1">Underdog</div></th>
                            <th class="px-2 py-1" valign="middle" ></th>
                            <th class="px-2 py-1" valign="middle" ><span class="style4">Picks must be entered by: {{ $picktime }}</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="post" action="{{ route('admin.storepickall', $user->id) }}">
                            @csrf
                    @php
                        $gp = $picks;
                    @endphp
                    @foreach($scheds as $i=>$s)
                    @php
                        if($i == sizeof($scheds)-1){
                            break;
                        }
                        if($s['awayteam_id']==$s['favoriteteam_id']) {
                            $und = strtoupper($teams[$s['hometeam_id']-1]['name']);
                            $und_id = $s['hometeam_id'];
                            $undhelm = $teams[$s['hometeam_id']-1]['gif'];
                            $fav = $teams[$s['awayteam_id']-1]['name'];
                            $fav_id = $s['awayteam_id'];
                            $favhelm = $teams[$s['awayteam_id']-1]['gif'];
                            $uc=$s['hometeam_id'];
                            $fc=$s['awayteam_id'];
                        } else {
                            $und = $teams[$s['awayteam_id']-1]['name'];
                            $und_id = $s['awayteam_id'];
                            $undhelm = $teams[$s['awayteam_id']-1]['gif'];
                            $fav = strtoupper($teams[$s['hometeam_id']-1]['name']);
                            $fav_id = $s['hometeam_id'];
                            $favhelm = $teams[$s['hometeam_id']-1]['gif'];
                            $uc=$s['awayteam_id'];
                            $fc=$s['hometeam_id'];
                        }
                    @endphp
                  <tr>
                    <td class="px-2 py-1" align="right" valign="middle">
                    @if($s['noline'] == 0)
                        @php
                            $name = "p".($i+1);
                            $pk = "p".($i+1);
                            if($gp[$pk]==$fc) $fck="checked"; else $fck="";
                            if($gp[$pk]==$uc) $uck="checked"; else $uck="";
                        @endphp
                        <input type="radio" value="{{ $fav_id }}" name="{{ $name }}" {{ $fck }}>
                    @endif
                    </td>
                    <td class="px-2 py-1" align="center" valign="middle"><img src='/images/nfl/{{ $favhelm }}'></td>
                    <td class="px-2 py-1" align="left" valign="middle">{{ $fav }}</td>
                    <td class="px-2 py-1" align="center" valign="middle">{{ $s['point_spread'] }}</td>
                    <td class="px-2 py-1" align="right" valign="middle">{{ $und }}</td>
                    <td class="px-2 py-1" align="center" valign="middle"><img src='/images/nfl/{{ $undhelm }}'></td>
                    <td class="px-2 py-1" align="left" valign="middle">
                    @if($s['noline'] == 0)
                            <input type="radio" value="{{ $und_id }}" name="{{ $name }}" {{ $uck }}>
                    @endif
                    </td>
                    <td class="px-2 py-1"></td>
                 </tr>
                 @endforeach
                  <tr>
                    <td height="16" colspan="8"></td>
                  </tr>
                  <tr>
                    <th height="25"></th>
                    <th colspan="8" align="center" valign="middle"><span class="style2">Monday Night</span></th>
                    </tr>
                  <tr>
                @php
                        if($s['awayteam_id']==$s['favoriteteam_id']) {
                            $und = strtoupper($teams[$s['hometeam_id']-1]['name']);
                            $und_id = $s['hometeam_id'];
                            $undhelm = $teams[$s['hometeam_id']-1]['gif'];
                            $fav = $teams[$s['awayteam_id']-1]['name'];
                            $fav_id = $s['awayteam_id'];
                             $favhelm = $teams[$s['awayteam_id']-1]['gif'];
                            $uc=$s['hometeam_id'];
                            $fc=$s['awayteam_id'];
                        } else {
                            $und = $teams[$s['awayteam_id']-1]['name'];
                            $und_id = $s['awayteam_id'];
                            $undhelm = $teams[$s['awayteam_id']-1]['gif'];
                            $fav = strtoupper($teams[$s['hometeam_id']-1]['name']);
                            $fav_id = $s['hometeam_id'];
                             $favhelm = $teams[$s['hometeam_id']-1]['gif'];
                            $uc=$s['awayteam_id'];
                            $fc=$s['hometeam_id'];
                        }
                @endphp
                  <tr>
                    <td align="right" valign="middle" >
                    @if($s['noline'] == 0)
                        @php
                            $name = "p16"; //always make monday nite fb p16
                            $pk = "p16";
                            if($gp[$pk]==$fc) $fck="checked"; else $fck="";
                            if($gp[$pk]==$uc) $uck="checked"; else $uck="";
                        @endphp
                        <input type="radio" value="{{ $fav_id }}" name="{{ $name }}" {{ $fck }}>
                    @endif
                    </td>
                    <td align="center" valign="middle"><img src='/images/nfl/{{ $favhelm }}'></td>
                    <td align="left" valign="middle">{{ $fav }}</td>
                    <td align="center" valign="middle">{{ $s['point_spread'] }}</td>
                    <td align="right" valign="middle">{{ $und }}</td>
                    <td align="center" valign="middle"><img src='/images/nfl/{{ $undhelm }}'></td>
                    <td align="left" valign="middle">@if($s['noline'] == 0)
                        <input type="radio" value="{{ $und_id }}" name="{{ $name }}" {{ $uck }}>
                    @endif
                    </td>
                    <td></td>
                 </tr>
                  <tr>
                    <td height="14" colspan="8"></td>
                  </tr>
                  <tr>
                    <td colspan="5" align="right" valign="middle"><span class="style2">Monday Night Football Total Pts </span></td>
                    <td align="left" valign="middle" colspan="3">
                        <input type="text" name="totpts" value="{{ $picks['totpts'] }}" size="4">
                    </td>
                  </tr>
                  <tr>
                    <td align="center" valign="top" colspan="8"><button class="text-black rounded-lg border-2 hover:bg-red-500 px-4 py-2">Submit</button></td>
                  </tr>
                </form>

                </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
