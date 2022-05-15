<x-layout :bg-image="url('/storage/' . $post->featured_image)">
    <x-slot name="heading">
        <div class="post-heading">
            <h1>{{ $post->title }}</h1>
            @if ($post->short_description)
                <h2 class="subheading">{{ $post->short_description }}</h2>
            @endif
            <span class="meta">
                Posted by
                <a href="#">{{ $post->author->first_name . ' ' . $post->author->last_name }}</a>
                on {{ $post->created_at->toFormattedDateString() }}
            </span>
        </div>
    </x-slot>

    <!-- Post Content-->
    <article class="mb-4">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-md-10 col-lg-8 col-xl-7">
                    {!! $post->description !!}
                </div>
            </div>
        </div>
    </article>
</x-layout>
