<x-layouts.app>
    <section id="hero" class="grid grid-cols-2 md:grid-cols-4">
        <div class="col-span-1 md:col-span-2">
            <div class="flex flex-col items-center ">
                <h1 class="text-2xl pt-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit </h1>
            <h1 class="text-4xl text-[#9b4819]">Lorem ipsum dolor sit amet, consectetur adipiscing elit </h1>
            <p>Ut enim ad minim veniam, quis nostrud</p>

            <button
                class="button bg-[#fff7cc] hover:bg-[#ae9371]
             text-black font-bold px-5 m-4 rounded-full">
                ARE
                YOU A SUPPLIER?
            </button>
            <button type="button"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Default
            </button>
            </div>
        </div>
        <div class="col-span-1 md:col-span-2 hidden lg:block">
            <div class="grid grid-cols-1 md:grid-cols-2  grid-rows-3 gap-1">
                <div class="col-span-1 md:col-span-2 lg:col-span-4">
                    <img src="{{ asset('assets/images/default/wed4.jpg') }}" alt="Image 1"
                        class="object-cover h-48 w-full rounded-md shadow-md">
                </div>
                <div class="col-span-1 md:col-span-1 lg:col-span-2 row-start-2">
                    <img src="{{ asset('assets/images/default/wed2.jpg') }}" alt="Image 1"
                        class="object-cover h-48 w-full rounded-md shadow-md">
                </div>
                <div class="col-span-1 md:col-span-1 lg:col-span-2 col-start-1 md:col-start-2 lg:col-start-3 row-start-2">
                    <img src="{{ asset('assets/images/default/wed3.jpg') }}" alt="Image 1"
                        class="object-cover h-48 w-full rounded-md shadow-md">
                </div>
                <div class="col-span-1 md:col-span-2 lg:col-span-3 row-start-3">
                    <img src="{{ asset('assets/images/default/wed5.jpg') }}" alt="Image 1"
                        class="object-cover h-48 w-full rounded-md shadow-md">
                </div>
                <div class="col-start-1 md:col-start-2 lg:col-start-4 row-start-3">
                    <img src="{{ asset('assets/images/default/wed4.jpg') }}" alt="Image 1"
                        class="object-cover h-48 w-full rounded-md shadow-md">
                </div>
            </div>
        </div>
    </section>

</x-layouts.app>
