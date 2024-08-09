<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Import') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session()->has('message'))
                @include('invoices.alert')
            @endif

            <form action="{{ route('invoices.importStore') }}" method="POST" class="bg-white rounded p-8 shadow"
                enctype="multipart/form-data">
                @csrf
                <x-validation-errors class="mb-4" />
                <div>
                    <h1 class="text-2xl font-semibold mb-4">
                        Por favor seleccione el archivo que quiere importar
                    </h1>
                    <input type="file" name="file" accept=".csv,.xlsx">
                </div>
                <x-button class="mt-4">
                    Importar archivo
                </x-button>
            </form>
        </div>
    </div>
</x-app-layout>
