<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pick All Standings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <table class="table table-striped table-condensed">
                    <thead>
                        <tr>
                        <th class="px-2 py-1">Name</th>
                        <th class="px-2 py-1">Wk1</th>
                        <th class="px-2 py-1">Wk2</th>
                        <th class="px-2 py-1">Wk3</th>
                        <th class="px-2 py-1">Wk4</th>
                        <th class="px-2 py-1">Wk5</th>
                        <th class="px-2 py-1">Wk6</th>
                        <th class="px-2 py-1">Wk7</th>
                        <th class="px-2 py-1">Wk8</th>
                        <th class="px-2 py-1">Wk9</th>
                        <th class="px-2 py-1">Wk10</th>
                        <th class="px-2 py-1">Wk11</th>
                        <th class="px-2 py-1">Wk12</th>
                        <th class="px-2 py-1">Wk13</th>
                        <th class="px-2 py-1">Wk14</th>
                        <th class="px-2 py-1">Wk15</th>
                        <th class="px-2 py-1">Wk16</th>
                        <th class="px-2 py-1">Wk17</th>
                        <th class="px-2 py-1">Wk18</th>
                        <th class="px-2 py-1">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                          for($i=0;$i<sizeof($x);$i++){
                    @endphp
                   <tr>
                      <td class="px-2 py-1"  align="left"><?php echo $x[$i]['name'];?></td>
                       <?php for($j=1;$j<=18;$j++){ ?>
                      <td class="px-2 py-1"  align="center"><?php
                              if (!empty($x[$i][$j])) echo $x[$i][$j]->tot;?></td>
                      <?php } ?>
                      <td class="px-2 py-1"  align="right"><?php echo $x[$i][$j];?></td>
                   </tr>
                    <?php

                  }
                  /******************/
                  ?>

                  </table>

            </div>
        </div>
    </div>
</x-app-layout>
