
<x-layouts.app>

    <section class="">
        <div class="container px-5 pb-10 pt-5 mx-auto">
            {{-- <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
                <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-bold text-gray-900 ">Our Blogs</h2>
                <p class="font-light text-gray-500 sm:text-xl">

                </p>
            </div> --}}
            <div class="flex flex-wrap -m-4 px-3">
                <article class="bg-white p-4 md:p-8 rounded-lg shadow-md md:mr-4 md:flex-1 relative">
                    <div class="relative mb-3 w-full">
                        <img class=" object-cover object-center rounded"
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
                        {!! nl2br(e($supplier->description)) !!}
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
                </article>
            </div>
        </div>
    </section>
</x-layouts.app>
