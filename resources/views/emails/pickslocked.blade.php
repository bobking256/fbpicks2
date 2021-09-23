<html>
    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <!-- Fonts -->
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

            <!-- Styles -->
            <link rel="stylesheet" href="https://fbpicks.bobking256.com/css/app.css">

            <!-- Scripts -->
            <script src="https://fbpics.bobking256.com/js/app.js" defer></script>
        </head>
        <body class="font-sans antialiased">
            <h1 class="font-bold text-2xl">Paulie's Football Picks for Week: {{ $weekno }}.</h1>
        <br/>
        <br/>
        <br/>
        @if ($pick531)
            <table class="table table-auto">
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
            <br/>
            <br/>
            <br/>
        @endif
        @if($pickall)
            <table class="table table-auto text-sm">
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
                        for($i=0;$i<sizeof($y);$i++){
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
        @endif

    </body>
</html>
