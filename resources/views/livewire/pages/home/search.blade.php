<div class="relative {{ $classes }}">
    <div>
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4  text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
            <span class="sr-only">Search icon</span>
        </div>
        <input type="text" id="search-navbar"
            class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
            placeholder="Search for supplier..." wire:model.live.debounce.150ms="search" list="suppliers"
            wire:focusout="resetSearch">
    </div>
    <div
        class="shadow-lg rounded-md py-2 border mt-1 max-h-64 w-100 overflow-y-auto bg-white absolute px-2 {{ $search ? 'block' : 'hidden' }}">
        @forelse ($suppliers as $key=> $supplier)
            <a href="{{ route('suppliers.index',['query' => 'supplier','id' => $key]) }}" wire:key="{{ $key }}"
                class="hover:bg-[#c4bcaf] hover:text-white rounded p-1">
                {{ $supplier }}
            </a>
            <br>
        @empty
            <button type="button">
                No Suppliers Found
            </button>
        @endforelse
    </div>

</div>
