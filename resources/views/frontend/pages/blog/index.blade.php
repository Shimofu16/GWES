<x-layouts.app>

    <section class="h-dvh">
        <div class="mx-auto max-w-screen-sm text-center lg:mb-16 mb-8">
            <h2 class="mb-4 text-3xl lg:text-4xl tracking-tight font-bold text-[#9b4819]">Our Blog</h2>
            <p class="font-light text-gray-500 sm:text-xl">

            </p>
        </div>
        <div class="container px-2 py-3 mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
                @forelse ($blogs as $blog)
                    <div class="p-4 col-span-2">
                        <div class="h-full bg-gray-100 bg-opacity-75 p-5 pb-10 rounded-lg  relative ">
                            <div class="relative overflow-hidden mb-3 w-full">
                                <img class="lg:h-48 md:h-36 w-full object-cover object-center rounded"
                                    src="{{ asset('storage/' . $blog->images) }}" alt="blog" loading="lazy">
                            </div>
                            <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">
                                {{ date('M d, Y', strtotime($blog->date)) }}</h2>
                            <h1 class="title-font sm:text-2xl  text-[#9b4819] text-xl font-medium mb-3 break-words ">
                                {{ $blog->title }}</h1>

                            <p class="leading-relaxed mb-3 break-words hyphens-none ">
                                {!! nl2br(e(Str::of($blog->description)->limit(100))) !!}
                            </p>
                            <div class="mt-3 pt-3">
                                <a href="{{ route('blogs.show', ['blog_id' => $blog->id]) }}"
                                    class="transform hover:scale-105 transition-all duration-200 bg-[#c4bcaf] text-white font-bold px-3 py-2.5 rounded mb-3">
                                    Reed More.
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 md:col-span-4 lg:col-span-6 px-4 w-full">
                        <h1 class="text-2xl text-center">No blogs yet..</h1>
                    </div>
                @endforelse
            </div>
            <div class="mt-3">
                {{ $blogs->links() }}
            </div>
        </div>
    </section>
</x-layouts.app>
