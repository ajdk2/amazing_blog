<x-layout>
    <x-slot name="heading">
        <div class="site-heading">
            <h1>Clean Blog</h1>
            <span class="subheading">A Blog Theme by Start Bootstrap</span>
        </div>
    </x-slot>

    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                @if (count($posts))
                    @foreach ($posts as $post)
                        <!-- Post preview-->
                        <div class="post-preview">
                            <a href="{{ route('post.show', $post->slug) }}">
                                <h2 class="post-title">{{ $post->title }}</h2>
                                <h3 class="post-subtitle">{{ $post->short_description }}</h3>
                            </a>
                            <p class="post-meta">
                                Posted by
                                <a href="{{ route('post', ['author' => $post->user_id]) }}">
                                    {{ $post->author->first_name . ' ' . $post->author->last_name }}
                                </a>
                                on {{ $post->created_at->toFormattedDateString() }}
                            </p>
                        </div>
                        <!-- Divider-->
                    @endforeach
                @else
                    <div class="my-5 text-center">
                        <h1>Sorry, no posts posted.</h1>
                    </div>
                @endif
                <!-- Pager-->
                {{ $posts->withQueryString()->links('components.paginator') }}
            </div>
        </div>
    </div>
</x-layout>
