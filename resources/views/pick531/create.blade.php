<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pick 5-3-1') }}
        </h2>
    </x-slot>

    @if($errors->any())
    <div class="text-red-800 font-bold px-4 py-4">
        {{ $errors->first() }}
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <table class="table table-fixed">
                    <thead>
                        <tr>
                            <th ></th>
                            <th colspan="2">Favored Team</th>
                            <th >Pt Spread</th>
                            <th colspan="2">Underdog Team</th>
                            <th ></th>
                            <th >Game Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form method="post" action="{{ route('pick531.store') }}">
                            @csrf
                        @php
                            $gp = $picks;
                        @endphp
                        @foreach($scheds as $i=>$s)
                        @php
                            if($s['awayteam_id']==$s['favoriteteam_id']) {
                                $und = strtoupper($teams[$s['hometeam_id']-1]['name']);
                                $undhelm = $teams[$s['hometeam_id']-1]['gif'];
                                $fav = $teams[$s['awayteam_id']-1]['name'];
                                $favhelm = $teams[$s['awayteam_id']-1]['gif'];
                                $uc=$s['hometeam_id'];
                                $fc=$s['awayteam_id'];
                            } else {
                                $und = $teams[$s['awayteam_id']-1]['name'];
                                $undhelm = $teams[$s['awayteam_id']-1]['gif'];
                                $fav = strtoupper($teams[$s['hometeam_id']-1]['name']);
                                $favhelm = $teams[$s['hometeam_id']-1]['gif'];
                                $uc=$s['awayteam_id'];
                                $fc=$s['hometeam_id'];
                            }

                            if($s['default_game']==5) $fav.=' [5]';
                            if($s['default_game']==3) $fav.=' [3]';
                            if($s['default_game']==1) $fav.=' [1]';
                        @endphp
                        <tr>
                            <td class="px-2 py-1"  valign="middle" align="right">
                                @php
                                    if($s['noline'] == 0) {
                                        $name = "sela".$i;
                                        if($fc == $gp['pt5']) $seld='5';
                                        else if($fc == $gp['pt3']) $seld='3';
                                        else if($fc == $gp['pt1']) $seld='1';
                                        else $seld = '0';
                                @endphp
                                <select name="{{ $name }}">
                                    <option value='0' {{ $seld == '0' ? 'selected' : ''}}>0</option>
                                    <option value='5' {{ $seld == '5' ? 'selected' : ''}}>5</option>
                                    <option value='3' {{ $seld == '3' ? 'selected' : ''}}>3</option>
                                    <option value='1' {{ $seld == '1' ? 'selected' : ''}}>1</option>
                                </select>
                                @php
                                    }
                                @endphp
                            </td>
                            <td class="px-2 py-1" align="center" valign="middle"><img src="/images/nfl/{{ $favhelm }}" /></td>
                            <td class="px-2 py-1" align="left" valign="middle" ><div align="left" class="style2">{{ $fav }}</div></td>
                            <td class="px-2 py-1" align="center" valign="middle"><div align="center" class="style2"> {{ $s['point_spread'] }}</div></td>
                            <td class="px-2 py-1" align="right" valign="middle"><div align="right" class="style2">{{ $und }}</div></td>
                            <td class="px-2 py-1" align="center" valign="middle"><img src="/images/nfl/{{ $undhelm }}" /></td>
                            <td class="px-2 py-1"  align="left" valign="middle">
                                @php
                                if($s['noline'] == 0) {
                                    $name = "selb".$i;
                                    if($uc == $gp['pt5']) $seld='5';
                                    else if($uc == $gp['pt3']) $seld='3';
                                    else if($uc == $gp['pt1']) $seld='1';
                                     else $seld = '0';
                                @endphp
                                <select name="{{ $name }}">
                                    <option value='0' {{ $seld == '0' ? 'selected' : ''}}>0</option>
                                    <option value='5' {{ $seld == '5' ? 'selected' : ''}}>5</option>
                                    <option value='3' {{ $seld == '3' ? 'selected' : ''}}>3</option>
                                    <option value='1' {{ $seld == '1' ? 'selected' : ''}}>1</option>
                                </select>
                                @php
                                    }
                                @endphp
                            </td>
                            <td class="px-2 py-1" >
                                {{ date('l, M j @  g:i a',strtotime($s['gamedate'])) }}
                            </td>
                        </tr>
                        @endforeach

                        <tr class="my-2">
                            <td colspan="3" align="right" valign="top"><span class="style2">Bonus Pick: </span></td>
                            <td colspan="2" valign="top">
                            @php
                                $a = array();
                                $a[0]='';
                                for($i=0;$i< sizeof($teams);$i++){
                                    $a[$i+1] = $teams[$i]['name'];
                                }
                                if($weekno > 2 && $weekno < 18) {
                            @endphp
                                <select name="bonus">
                                @foreach($teams as $t)
                                    <option value="{{ $t['id'] }}" {{ $gp['bonus'] == $t['id'] ? 'selected' : ''}}>{{ $t['name'] }}</option>
                                @endforeach
                            @php
                                } else {
                            @endphp
                                    Not Available.
                            @php
                                }
                            @endphp
                            </td>
                            <td>&nbsp;</td>
                            <td colspan="2" valign="middle"><span class="style2">Current Bonus Remaining:&nbsp;&nbsp; {{ $rembonus }} </span></td>
                          </tr>
                          <tr class="my-2">
                              <td align="center" colspan="8"><button class="font-bold rounded-lg border-2 text-black bg-red-800 hover:bg-red-500 px-4 py-2" type="submit">Submit</button></td>
                          </tr>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
