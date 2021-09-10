<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Week Schedule') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                <form method='post' action='{{ route('weeknos.updateweeknos') }}'>
                    @csrf

                     Week Time is the date and time that starts a ends a week and begins the next.  Typically this is a Wednesday 9am or noon time where the point spread is entered for the next week and users can begin selecting picks.
                     <br>
                     Pick Time is the dead line for getting picks in.
                     <br>
                    <table class="table table-fixed">
                        <thead>
                            <tr>
                                <th>Wk No</th>
                                <th valign="middle" align="center">Week Time</th>
                                <th valign="middle" align="center">Pick Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($weeknos as $i=>$w)

                            <tr>
                                <td valign="middle" align="center">
                                @php
                                    echo $i+1;
                                @endphp
                                </td>
                                <td align="left" valign="middle">
                                @php
                                    $name="weektime".$i;
                                @endphp
                                <input type="datetime-local" name="{{ $name }}" value="{{ $w[$name] }}"
                            //    	echo $form->input($name,array('label'=>false,'size'=>'25', 'maxlength'=>'25'));
                                    echo $this->Form->dateTime($name,array('label'=>false,'value'=>$week[$name]));
                                ?>
                                </td>
                                <td align="left" valign="middle">
                                <?php $name="picktime".$i;
                                //	echo $form->input($name,array('label'=>false,'size'=>'25', 'maxlength'=>'25'));
                                    echo $this->Form->dateTime($name,array('label'=>false,'value'=>$week[$name]));
                                ?>
                                </td>
                            </tr>
                            <?php
                            }
                    ?>
                      <tr>
                          <td colspan="10">&nbsp;</td>
                      </tr>
                      <tr>
                          <td align="center" colspan="3"><button type="submit">Submit</button></td>
                      </tr>
                        </tbody>
                    </table>
                    <?php echo $this->Form->end(); ?>



            </div>
        </div>
    </div>
</x-app-layout>


