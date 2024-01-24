<section class="container mx-auto px-3 lg:px-0 h-dvh">
    <div class="flex justify-between flex-wrap mb-3">
        <div class="">

        </div>
        <div class="selects flex items-center flex-wrap px-3 sm:px-0">
            <div class="relative mb-3 sm:mb-0 w-full sm:w-auto">
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
            <div class="sm:ms-3 w-full sm:w-auto">
                <select id="categories" wire:model.live='category_id'
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option selected value="">Choose a category</option>
                    @foreach ($categories as $key => $category)
                        <option value="{{ $key }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            {{-- <div>

                <select id="categoryTypes" wire:model.live='category_type'
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option selected value="">Choose a category type</option>
                    @foreach (App\Enums\CategoryTypeEnum::toArray() as $key => $category_type)
                        <option value="{{ $key }}">{{ $category_type }}</option>
                    @endforeach
                </select>
            </div> --}}

        </div>
    </div>
    <div class="container px-2 py-3">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
            @forelse ($suppliers as $supplier)
                <div class="p-4 col-span-2">
                    <div class="h-full bg-gray-100 bg-opacity-75 p-5 pb-10 rounded-lg  relative ">
                        <div class="relative overflow-hidden mb-3 w-full">
                            <img class="lg:h-50 md:h-40 object-cover object-center rounded w-[100%]"
                                src="{{ asset('storage/' . $supplier->image) }}" alt="supplier">
                            @if ($supplier->isPremium)
                                <div class="absolute top-3 right-3 bg-white p-0 rounded-full">
                                    <img class="object-cover object-center rounded-full h-[50px] w-[50px] sm:h-[75px] sm:w-[75px]"
                                        src="{{ asset('storage/' . $supplier->logo) }}" alt="supplier">
                                </div>
                            @endif
                            <!-- <img class="w-full object-cover rounded h-" src="{{ asset('storage/' . $supplier->logo) }}"-->
                            <!--alt="supplier"> -->
                        </div>

                        <h1 class="title-font sm:text-2xl  text-[#9b4819] text-xl font-medium mb-3 break-words ">
                            {{ $supplier->name }}</h1>
                        <p class="leading-relaxed mb-3 break-words hyphens-none ">
                            {!! nl2br(e(Str::of($supplier->description)->limit(200))) !!}
                        </p>

                        <span class="font-semibold text-[#9b4819] ">Socials</span>
                        <ul class="mx-5 list-disc mb-3">
                            @foreach ($supplier->socials as $social)
                                <li class=""><a href="{{ url('https://' . $social) }}" target="_blank"
                                        rel="noopener noreferrer" class="break-words">{{ $social }}</a></li>
                            @endforeach
                        </ul>
                        <span class="font-semibold text-[#9b4819] ">Price range</span> <br>
                        @php
                            $data = explode(' - ', $supplier->price_range);
                        @endphp
                        <span>₱{{ number_format($data[0]) }} - {{ number_format($data[1]) }}</span>
                        <div class="mt-3 pt-3">
                            <a href="{{ route('suppliers.show', ['supplier_id' => $supplier->id]) }}"
                                class="transform hover:scale-105 transition-all duration-200 bg-[#c4bcaf] text-white font-bold px-3 py-2.5 rounded mb-3">
                                Reed More.
                            </a>
                        </div>
                    </div>
                </div>
            @empty
            <div class="col-span-2 md:col-span-4 lg:col-span-6 px-4 w-full">
                <h1 class="text-2xl text-center">No Suppliers Found</h1>
                </div>
            @endforelse
        </div>
    </div>

</section>
