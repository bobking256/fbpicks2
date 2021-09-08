<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pick 5-3-1') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                Your picks have been saved.  You selected:
                <br/>
                <br/>
                <ul>
                    <li>5 pts - {{ $teams[$pick5-1]->name }}</li>
                    <li>3 pts - {{ $teams[$pick3-1]->name }}</li>
                    <li>1 pts - {{ $teams[$pick1-1]->name }}</li>
                    @if($bonus != 0)
                    <li>Bonus - {{ $teams[$bonus-1]->name }}</li>
                    @endif
                </ul>
                <br/>
                Remaining Bonus Pick(s): {{ $rembonus }}

            </div>
        </div>
    </div>
</x-app-layout>
