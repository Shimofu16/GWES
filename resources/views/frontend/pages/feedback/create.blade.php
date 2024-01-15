<x-layouts.app>
    <section class="container px-5 py-10 lg:py-24 mx-auto">
        <div class="">
            <div class="flex sm:flex-nowrap flex-wrap">
                <div
                    class="lg:w-2/3 md:w-1/2 rounded-lg overflow-hidden sm:mr-10  flex items-end justify-start relative hidden md:block">
                    <img src="{{ asset('assets/images/defaults/wed-7.jpg') }}" alt="wed" class="rounded">
                    {{-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7736.696496297044!2d121.24213464588337!3d14.174369795052014!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd60bcf45a3077%3A0xa9b0e34f8a80cd9a!2sSan%20Antonio%2C%20Los%20Ba%C3%B1os%2C%20Laguna!5e0!3m2!1sen!2sph!4v1705328545208!5m2!1sen!2sph" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe> --}}
                </div>
                <div class="lg:w-1/3 md:w-1/2 bg-white flex flex-col md:ml-auto w-full  md:mt-5 p-5">
                    <h2 class="text-gray-900 text-lg mb-1 font-medium title-font">Write feedback</h2>
                    <p class="leading-relaxed mb-5 text-gray-600">Share your thoughts with great weddings directory.</p>
                    @if (Session::has('success'))
                        <p class="text-xs text-green-500 mb-3">{{ Session::get('success') }}</p>
                    @else
                        <p class="text-xs text-red-500 mb-3">{{ Session::get('error') }}</p>
                    @endif
                    <form action="{{ route('feedbacks.store') }}" method="post">
                        @csrf
                        <div class="relative mb-4">
                            <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
                            <input type="text" id="name" name="name"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                            <input type="email" id="email" name="email"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                        </div>
                        <div class="relative mb-4">
                            <label for="message" class="leading-7 text-sm text-gray-600">Message <span
                                    class="text-red-500">*</span></label>
                            <textarea id="message" name="context"
                                class="w-full bg-white rounded border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                        </div>
                        <button
                            {{-- class="text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded text-lg" --}}
                            class="text-white transform hover:scale-105 transition-all duration-200 bg-[#c4bcaf] hover:bg-[#ae9371]
                            font-bold
                            px-3 py-2.5 text-center rounded"
                            type="submit">Submit</button>

                    </form>
                </div>


            </div>

        </div>
    </section>
</x-layouts.app>
