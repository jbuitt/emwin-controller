<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __(config('app.name') . ' System Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                @if (preg_match('/npemwin/', config('emwin-controller.download_clients_enabled')))
                <livewire:process-control-panel />
                @endif

                <div class="p-6">
                    <livewire:syslog-table />
                </div>

            </div>
        </div>
    </div>

</x-app-layout>
