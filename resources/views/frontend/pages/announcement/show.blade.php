<x-layouts.app>
    <section class="">
        <div class="container px-5 pb-10 pt-5 mx-auto">
            {{-- <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
                <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-bold text-gray-900 ">Our Blogs</h2>
                <p class="font-light text-gray-500 sm:text-xl">

                </p>
            </div> --}}
            <div class="flex flex-wrap -m-4 px-3">
                <article class="bg-white p-4 md:p-8 rounded-lg shadow-md md:mr-4 md:flex-1">
                    <h2 class="text-2xl md:text-3xl font-bold mb-2 text-[#9b4819]">{{ $announcement->title }}</h2>
                    <p class="text-gray-600 mb-2 md:mb-4">Published on
                        {{ date('M d, Y', strtotime($announcement->date)) }}</p>
                    <div>
                        <img src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}"
                            class="mb-4 rounded-lg" loading="lazy">
                    </div>

                    <p class="mb-2 text-wrap">
                        {!! nl2br(e($announcement->description)) !!}
                        {{-- {!! $blog->description !!} --}}
                    </p>
                </article>
            </div>

        </div>
    </section>
</x-layouts.app>
