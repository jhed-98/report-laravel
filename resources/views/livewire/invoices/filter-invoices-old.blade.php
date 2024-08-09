<div>
    <div class="overflow-hidden relative">

        {{-- FILTRO --}}
        <div class="bg-white rounded p-8 shadow mb-6">
            <h2 class="text-2xl font-semibold mb-4">
                Generar reportes
            </h2>

            <div class="mb-4">
                Serie:
                <select name="serie" wire:model.change="filters.serie"
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm w-32">
                    <option value="">All</option>
                    <option value="F001">F001</option>
                    <option value="B001">B001</option>
                </select>
            </div>

            <div class="flex space-x-4 mb-4">
                <div>
                    Desde el N°:
                    <x-input type="text" class="w-20" wire:model.live="filters.fromNumber" />
                </div>
                <div>
                    Hasta el N°:
                    <x-input type="text" class="w-20" wire:model.live="filters.toNumber" />
                </div>
            </div>
            <div class="flex space-x-4 mb-4">
                <div>
                    Desde fecha:
                    <x-input type="date" class="w-36" wire:model.live="filters.fromDate" />
                </div>
                <div>
                    Hasta fecha:
                    <x-input type="date" class="w-36" wire:model.live="filters.toDate" />
                </div>
            </div>
            <x-button wire:click="generarReport">
                Generar Reporte
            </x-button>
        </div>
        {{-- TABLE --}}
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Serie
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Correlativo
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Base
                        </th>
                        <th scope="col" class="px-6 py-3">
                            IGV
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Total
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Fecha
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $invoice->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $invoice->serie }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $invoice->correlative }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $invoice->base }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $invoice->igv }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $invoice->total }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $invoice->created_at }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $invoices->links() }}
        </div>

    </div>
</div>
