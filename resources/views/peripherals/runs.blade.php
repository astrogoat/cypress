<x-fab::lists.two-column title="Test Results">
    @foreach($runs as $run)
        <x-fab::lists.two-column.column
            title="Test Run #{{ $run->id }}"
            class="cursor-pointer group"
            style="background-color: {{ $failedCount = $run->tests()->failed()->count() > 0 ? '#ebcdcc' : 'inherit' }};"
            x-on:click="$modal.open('astrogoat.cypress.modals.run', {{ json_encode(['run' => $run->id]) }})"
        >
            <x-slot name="title">
                @if ($run->tests()->failed()->count() === 0)
                    Passed
                @else
                    Failed
                @endif
            </x-slot>

            <x-slot name="description">
                #{{ $run->id }}&nbsp;&nbsp;|&nbsp;
                Passed: <span class="font-bold">{{ $run->tests()->passed()->count() }}</span>
                Failed: <span class="font-bold">{{ $run->tests()->failed()->count() }}</span>&nbsp;&nbsp;&nbsp;
                <span>Ran {{ $run->created_at->diffForHumans() }} on {{ $run->created_at->toDayDateTimeString() }}</span>
            </x-slot>

            <x-slot name="icon">
                <x-fab::elements.icon :icon="Helix\Fabrick\Icon::EYE" class="hidden group-hover:block h-5 w-5 text-gray-500 dark:text-slate-300 mr-4" type="solid" />
                @if($run->allHasPassed())
                    <x-fab::elements.icon :icon="Helix\Fabrick\Icon::CHECK" class="h-5 w-5 text-gray-500 dark:text-slate-300" type="solid" />
                @else
                    <x-fab::elements.icon :icon="Helix\Fabrick\Icon::EXCLAMATION" class="h-5 w-5 text-gray-500 dark:text-slate-300" type="solid" />
                @endif
            </x-slot>
        </x-fab::lists.two-column.column>
    @endforeach
</x-fab::lists.two-column>
