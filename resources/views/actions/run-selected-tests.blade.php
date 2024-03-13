<div>
    <div class="px-4 py-4 sm:px-6 flex flex-col {{ $this->batchJobIsRunning() ? 'hidden' : '' }}"
         x-on:added-item="$wire.call('selectTest', $event.detail[1].key)"
         x-on:removed-item="$wire.call('deselectTest', $event.detail[1].key)"
    >
        <div class="fab-text-sm fab-font-medium fab-text-gray-700 dark:fab-text-slate-200 fab-truncate pb-2">Run selected tests</div>
        <div class="flex">
            <div class="flex-1">
                <x-fab::forms.combobox :items="$this->getTestSpecFiles()" />
            </div>

            <x-fab::elements.button
                primary
                size="sm"
                class="ml-4 self-start"
                :disabled="empty($this->selectedTestPaths)"
                wire:click="runSelectedJobs"
            >
                <span wire:target="runSelectedJobs" wire:loading.remove>Run</span>
                <svg
                    wire:target="runSelectedJobs"
                    wire:loading
                    xmlns="http://www.w3.org/2000/svg"
                    class="animate-spin h-5 w-5 text-white"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </x-fab::elements.button>
        </div>
    </div>
    @includeWhen($this->batchJobIsRunning(), 'lego::batch-jobs.batch-job')
</div>
