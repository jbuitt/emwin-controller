<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('View Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (preg_match('/\.(JPG|GIF|PNG)/', $product->name))
            <div class="flex w-full justify-center items-center">
                <img src="{{ asset('storage/products/emwin/' . strtolower(substr($product->name, 8, 4)) . '/' . $product->name) }}" />
            </div>
            @else
            <div class="bg-gray dark:bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                <div class="whitespace-pre">{{ file_get_contents(storage_path(config('emwin-controller.archive_directory')) . '/' . strtolower(substr($product->name, 8, 4)) . '/' . $product->name) }}</div>
            </div>
            @endif
        </div>
    </div>

</x-app-layout>
