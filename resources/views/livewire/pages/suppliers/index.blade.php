<section class="container mx-auto px-3 lg:px-0">
    <div class="flex justify-between flex-wrap mb-3">
        <div class="search mb-2 sm:mb-0">
            <div class="relative">
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
                    placeholder="Search for supplier..." wire:model.live.debounce.150ms="search">
            </div>
        </div>
        <div class="selects flex items-center">
            <div class="me-3">
                <select id="categories" wire:model.live='category_id'
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option selected value="">Choose a category</option>
                    @foreach ($categories as $key => $category)
                        <option value="{{ $key }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div>

                <select id="categoryTypes" wire:model.live='category_type'
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option selected value="">Choose a category type</option>
                    @foreach (App\Enums\CategoryTypeEnum::toArray() as $key => $category_type)
                        <option value="{{ $key }}">{{ $category_type }}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>
    <div class="container px-2 py-3">
        <div class="flex flex-wrap -m-3">
            @forelse ($suppliers as $supplier)
                <div class="p-4 lg:w-1/3">
                    <div class="h-full bg-gray-100 bg-opacity-75 px-5 py-10 rounded-lg  relative">
                        <h1 class="title-font sm:text-2xl text-xl font-medium text-gray-900 mb-3">
                            {{ $supplier->name }}</h1>
                        <p class="leading-relaxed mb-3">{{ $supplier->description }}</p>

                        <span class="font-semibold">Socials</span>
                        <ul class="mx-5 list-disc mb-3">
                            @foreach ($supplier->socials as $social)
                                <li class=""><a href="{{ $social }}" target="_blank" rel="noopener noreferrer">{{ $social }}</a></li>
                            @endforeach
                        </ul>
                        <span class="font-semibold">Price range</span> <br>
                        @php
                            $data = explode(' - ', $supplier->price_range)
                        @endphp
                        <span>₱{{ number_format($data[0]) }} - {{ number_format($data[1]) }}</span>

                    </div>
                </div>
            @empty
                <span>no suppliers</span>
            @endforelse
        </div>
    </div>

</section>
