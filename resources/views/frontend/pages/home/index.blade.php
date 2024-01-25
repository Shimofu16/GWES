<x-layouts.app>
    <section id="hero" class="container mx-auto px-3">
        <div class="flex flex-col md:flex-row justify-center">
            <div class="flex flex-col justify-center w-full pe-5 mb-5 sm:mb-0">
                <h1 class="text-center sm:text-start text-2xl font-semibold  md:text-3xl lg:text-4xl text-[#9b4819]">
                    Great
                    Wedding's Directory</h1>
                <h1 class="text-center sm:text-start text-xl md:text-2xl lg:text-3xl  pb-4 mt-2">Connect with soon-to-wed
                    couples & Suppliers through Great Weddings Directory.</h1>
                {{--  <h1 class="text-center sm:text-start text-xl md:text-2xl lg:text-3xl  pb-4 mt-2">We provide a
                    comprehensive
                    list of
                    suppliers for all your wedding needs. </h1> --}}

                <div class="text-center sm:text-start mt-3">
                    <!--<a href="{{ route('suppliers.create') }}"-->
                    <!--    class="text-white transform hover:scale-105 transition-all duration-200 bg-[#c4bcaf] hover:bg-[#ae9371]-->
                    <!--     font-bold-->
                    <!--     px-3 py-2.5 text-center rounded-full">-->
                    <!--    Become a Supplier-->
                    <!--</a>-->

                </div>
            </div>

            <div class="w-full">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 grid-rows-2 sm:grid-rows-3 gap-1">
                    {{-- row 1 --}}
                    <div class="col-span-2 lg:col-span-4">
                        <img src="{{ asset('assets/images/defaults/wed-1.jpg') }}" alt="Image 1"
                            class="object-cover h-48 w-full rounded-md shadow-md" loading="lazy">
                    </div>
                    {{-- row 2 --}}
                    <div class="col-span-1  lg:col-span-2 row-start-2">
                        <img src="{{ asset('assets/images/defaults/wed-7.jpg') }}" alt="Image 2"
                            class="object-cover h-48 w-full rounded-md shadow-md" loading="lazy">
                    </div>
                    <div class="hidden sm:block col-span-1  lg:col-span-2  row-start-2">
                        <img src="{{ asset('assets/images/defaults/wed-3.jpg') }}" alt="Image 3"
                            class="object-cover h-48 w-full rounded-md shadow-md" loading="lazy">
                    </div>
                    {{--  row 3 --}}
                    <div class="hidden sm:block col-span-1  lg:col-span-3 row-start-3">
                        <img src="{{ asset('assets/images/defaults/wed-5.jpg') }}" alt="Image 4"
                            class="object-cover h-48 w-full rounded-md shadow-md" loading="lazy">
                    </div>
                    <div class="hidden sm:block col-start-1 lg:col-start-4 row-start-3">
                        <img src="{{ asset('assets/images/defaults/wed-6.jpg') }}" alt="Image 5"
                            class="object-cover h-48 w-full rounded-md shadow-md" loading="lazy">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bg-[#c4bcaf] ">
        <div class="container mx-auto px-3 sm:px-10 py-10 sm:py-20 mt-[50px] sm:mt-[100px]">
            <h1
                class="text-center text-2xl font-semibold  md:text-3xl lg:text-4xl text-[#9b4819] mb-10 border-solid border-bottom border-white border-b-5">
                Our Suppliers</h1>
            <div class="owl-carousel owl-theme owl-loaded owl-drag">
                @foreach ($suppliers as $supplier)
                    <div class="rounded-full bg-white w-[95px] h-[95px] mx-2 flex justify-center">
                        <img src="{{ asset('storage/' . $supplier) }}" alt="Logo 1" class="rounded-full"
                            loading="lazy">
                    </div>
                @endforeach
                @if ($suppliers->count() < 100)
                    @php
                        $count = 100 - $suppliers->count();
                    @endphp
                    @for ($i = 0; $i < $count; $i++)
                        <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                            <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1"
                                class="rounded-full" loading="lazy">
                        </div>
                    @endfor
                @endif


            </div>
            <div class="mt-10   text-center w-full">
                <a href="{{ route('suppliers.index') }}"
                    class="transform hover:scale-105 transition-all duration-200 bg-white text-[#c4bcaf] hover:text-[#ae9371]
                     font-bold
                     px-3 py-2.5  rounded-full mx-auto self-center mb-3">
                    Suppliers
                </a>
            </div>
        </div>
    </section>
    @if ($announcement)
        <section class="container mx-auto mt-[50px] sm:mt-[100px]">
            <!--Announcement Container-->
            <div class="px-5">
                <h1 class="text-center text-2xl font-semibold  md:text-3xl lg:text-4xl text-[#9b4819] mb-7">Announcement</h1>
                <div class="flex flex-col md:flex-row justify-center">
                    <!--Announcement Title/Description-->
                    <div class="flex flex-col justify-center w-full md:px-10">
                        <h1 class="text-center text-2xl font-serif  md:text-3xl lg:text-4xl mb-5">
                            {{ $announcement->title }}
                        </h1>
                        <p class="text-justify text-gray-600">
                            {!! nl2br(e(Str::of($announcement->description)->limit(500))) !!}
                        </p>
                        <!--Announcement Button-->
                        <div class="ml-6 pt-5 text-center">
                            <a href="{{ route('announcements.show', ['announcement_id' => $announcement->id]) }}"
                                class="transform hover:scale-105 transition-all duration-200 bg-[#c4bcaf] text-white font-bold px-3 py-2.5 rounded mb-3">
                                Reed More.
                            </a>
                        </div>
                    </div>
                    <!--Announcement Picture-->
                    <div class="flex flex-col justify-center items-center w-full">
                        <img src="{{ asset('storage/' . $announcement->image) }}" class="object-cover mb-5 rounded"
                            alt="Your Image">
                    </div>

                </div>
            </div>
        </section>
    @endif
    <section class="container mx-auto px-5 mt-[50px] sm:mt-[100px]">

        <div class="flex flex-col md:flex-row justify-center">
            <div class="flex flex-col justify-center items-center w-full">
                <h1 class="text-center text-2xl font-semibold  md:text-3xl lg:text-4xl text-[#9b4819] mb-5">About Us
                </h1>
                <img src="{{ asset('assets/images/defaults/wed-10.jpg') }}" class="object-cover rounded mb-5"
                    alt="Your Image">
            </div>
            <div class="flex flex-col justify-center w-full">
                <h1 class="text-center text-2xl font-semibold  md:text-3xl lg:text-4xl mb-5">
                    <span class="text-black">
                        Great
                    </span>
                    <span class="text-[#9b4819]">
                        Wedding's Directory
                    </span>
                </h1>
                <p class="text-justify md:px-10 mb-5">
                    One search engine that can help soon-to-wed couples find reliable wedding suppliers, an online
                    platform that offers a wide range of vetted and trusted suppliers for weddings. By using Great
                    Weddings Suppliers Directory, soon-to-wed couples can search for suppliers based on their specific
                    location and wedding category, such as venues, photographers, caterers, florists, and more. The
                    platform provides detailed vendor profiles, including their Facebook Page and Contact Number, this
                    helps soon-to-wed couples in making informed decisions and finding the right supplier that suits
                    their preferences and needs. Overall, Great Weddings Suppliers Directory acts as a reliable and
                    comprehensive search engine that assists soon-to-wed couples in finding and connecting with
                    trustworthy wedding suppliers for their special day.
                </p>
            </div>
        </div>
    </section>
    <section class="container mx-auto px-5 mt-[50px] sm:mt-[100px]">
        <div class="flex flex-col md:flex-row justify-center">
            <div class="flex flex-col justify-center w-full">
                <h1 class="text-center text-2xl font-semibold  md:text-3xl lg:text-4xl text-[#9b4819] mb-5">Mission
                </h1>
                <p class="text-justify md:px-10 mb-5">
                    Our Mission is to simplify the wedding planning process, saving precious time ensuring stress free
                    journey and be the ease and peace of mind our directory brings in every wedding planning journey.
                </p>
            </div>
            <div class="flex flex-col justify-center items-center w-full">
                <img src="{{ asset('assets/images/defaults/wed-8.jpg') }}" id="mission-pic1" class="object-cover  pb-4"
                    alt="Your Image" loading="lazy">
                <img src="{{ asset('assets/images/defaults/wed-9.jpg') }}" id="mission-pic2" class="object-cover"
                    alt="Your Image" loading="lazy">
            </div>
        </div>
    </section>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/packages/owl carousel/owl.carousel.min.css') }}" />
        <style>
            #mission-pic1 {
                clip-path: polygon(2% 34%, 7% 14%, 27% 2%, 79% 10%, 90% 21%, 97% 30%, 82% 32%, 76% 41%, 90% 41%, 80% 61%, 95% 82%, 97% 97%, 61% 95%, 40% 88%, 25% 99%, 4% 95%, 14% 41%);
                height: 200px;
                width: 700px;
            }

            #mission-pic2 {
                clip-path: polygon(79% 15%, 99% 1%, 100% 45%, 91% 68%, 99% 99%, 50% 100%, 13% 100%, 0% 70%, 0 21%, 32% 0);
                height: 200px;
                width: 700px;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="{{ asset('assets/packages/owl carousel/owl.carousel.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.owl-carousel').owlCarousel({
                    margin: 10,
                    loop: true,
                    autoWidth: true,
                    items: 4,
                    autoplay: true,
                    autoplayTimeout: 1000,
                    autoplayHoverPause: true,
                    lazyLoad: true,
                    dots: false,
                });
            });
        </script>
    @endpush
</x-layouts.app>
