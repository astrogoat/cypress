@php use Illuminate\Support\Str; @endphp
<x-fab::overlays.simple
    title="#{{ $run->id }}"
>
    <div class="bg-white p-4">
        <div class="space-y-10">
                @foreach($this->getGroupedTests() as $group => $tests)
                    <div>
                        <div class="text-sm font-semibold -ml-2 sticky top-0 bg-white py-2 pt-4 pb-2">
                            <span class="text-gray-400 ">{{ Str::of($group)->afterLast(tenant()->id . '/')->beforeLast('/') }}/</span>
                            <span class="text-gray-700">{{ Str::of($group)->afterLast('/')->before('.cy.js') }}</span>
                        </div>
                        <x-fab::lists.table>
                            <x-fab::lists.table.header>Title</x-fab::lists.table.header>
                            <x-fab::lists.table.header>Status</x-fab::lists.table.header>
                            <x-fab::lists.table.header hidden>Icon</x-fab::lists.table.header>

                            @foreach($tests as $test)
                                <x-fab::lists.table.row :odd="! $loop->odd" style="background-color: {{ $test->failed() ? '#ebcdcc' : 'inherit' }};">
                                    <x-fab::lists.table.column primary full>{{ $test->title }}</x-fab::lists.table.column>
                                    <x-fab::lists.table.column>{{ $test->status }}</x-fab::lists.table.column>
                                    <x-fab::lists.table.column slim>
                                        @if($test->passed())
                                            <x-fab::elements.icon :icon="Helix\Fabrick\Icon::CHECK" class="h-5 w-5 text-gray-500 dark:text-slate-300" type="solid" />
                                        @else
                                            <x-fab::elements.icon :icon="Helix\Fabrick\Icon::EXCLAMATION" class="h-5 w-5 text-gray-500 dark:text-slate-300" type="solid" />
                                        @endif
                                    </x-fab::lists.table.column>
                                </x-fab::lists.table.row>
                                @if($test->failed())
                                    <x-fab::lists.table.row style="background-color: '#ebcdcc';">
                                        <x-fab::lists.table.column colspan="3">
                                            <div style="white-space: normal;">
                                                {{ $test->error }}
                                            </div>
                                        </x-fab::lists.table.column>
                                    </x-fab::lists.table.row>
                                @endif
                            @endforeach
                        </x-fab::lists.table>
                    </div>
                @endforeach
        </div>
    </div>
</x-fab::overlays.simple>
