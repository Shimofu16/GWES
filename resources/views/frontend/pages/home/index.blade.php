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
                    <a href="#"
                        class="text-white transform hover:scale-105 transition-all duration-200 bg-[#c4bcaf] hover:bg-[#ae9371]
                         font-bold
                         px-3 py-2.5 text-center rounded-full">
                        Become a Supplier
                    </a>

                </div>
            </div>

            <div class="w-full">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 grid-rows-2 sm:grid-rows-3 gap-1">
                    {{-- row 1 --}}
                    <div class="col-span-2 lg:col-span-4">
                        <img src="{{ asset('assets/images/default/wed4.jpg') }}" alt="Image 1"
                            class="object-cover h-48 w-full rounded-md shadow-md" loading="lazy">
                    </div>
                    {{-- row 2 --}}
                    <div class="col-span-1  lg:col-span-2 row-start-2">
                        <img src="{{ asset('assets/images/default/wed2.jpg') }}" alt="Image 2"
                            class="object-cover h-48 w-full rounded-md shadow-md" loading="lazy">
                    </div>
                    <div class="col-span-1  lg:col-span-2  row-start-2">
                        <img src="{{ asset('assets/images/default/wed3.jpg') }}" alt="Image 3"
                            class="object-cover h-48 w-full rounded-md shadow-md" loading="lazy">
                    </div>
                    {{--  row 3 --}}
                    <div class="hidden sm:block col-span-1  lg:col-span-3 row-start-3">
                        <img src="{{ asset('assets/images/default/wed5.jpg') }}" alt="Image 4"
                            class="object-cover h-48 w-full rounded-md shadow-md" loading="lazy">
                    </div>
                    <div class="hidden sm:block col-start-1 lg:col-start-4 row-start-3">
                        <img src="{{ asset('assets/images/default/wed4.jpg') }}" alt="Image 5"
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
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>
                <div class="rounded-full bg-white w-[95px] h-[95px] mx-2">
                    <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" alt="Logo 1" class="rounded-full"
                        loading="lazy">
                </div>

            </div>
        </div>
    </section>
    <section class="container mx-auto px-5 mt-[50px] sm:mt-[100px]">
        <div class="flex flex-col md:flex-row justify-center">
            <div class="flex flex-col justify-center items-center w-full">
                <h1 class="text-center text-2xl font-semibold  md:text-3xl lg:text-4xl text-[#9b4819]">About Us</h1>
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
                <p class="text-justify">
                    One search engine that can help clients find reliable wedding suppliers, an online platform that
                    offers a wide range of vetted and trusted vendors for weddings.

                    By using Great Weddings Suppliers Directory, clients can search for suppliers based on their
                    specific location and wedding category, such as venues, photographers, caterers, florists, and more.
                    The platform provides detailed vendor profiles, including their Facebook Page and Contact Number,
                    this helps clients in making informed decisions and finding the right supplier that suits their
                    preferences and needs.

                    Overall, Great Weddings Suppliers Directory acts as a reliable and comprehensive search engine that
                    assists clients in finding and connecting with trustworthy wedding suppliers for their special day.
                </p>
            </div>
        </div>
    </section>
    <section class="container mx-auto px-5 mt-[50px] sm:mt-[100px]">
        <div class="flex flex-col md:flex-row justify-center">
            <div class="flex flex-col justify-center w-full">
                <h1 class="text-center text-2xl font-semibold  md:text-3xl lg:text-4xl text-[#9b4819] mb-5">Mission
                </h1>
                <p class="text-justify">
                    Our Mission is to simplify the wedding planning process, saving precious time ensuring stress free
                    journey and be the ease and peace of mind our directory brings in every wedding planning journey.
                </p>
            </div>
            <div class="flex flex-col justify-center items-center w-full">
                <img src="{{ asset('assets/images/default/wed4.jpg') }}" id="mission-pic1"
                    class="object-cover  pb-4" alt="Your Image" loading="lazy">
                <img src="{{ asset('assets/images/default/wed2.jpg') }}" id="mission-pic2" class="object-cover"
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
