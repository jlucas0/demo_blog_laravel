<x-layout title=" - TITULO">
    <a href="{{route('home')}}" class="btn btn-primary mt-3">Back to home</a>
    <div class="row g-5 mt-2">
        <div class="col-md-8">
            <article class="blog-post">
                <h2 class="display-5 link-body-emphasis mb-1">{{$post->title}}</h2>
                <p class="blog-post-meta">{{$post->created_at->format('M d, Y')}}</p>

                {!! $post->post !!}
            </article>
        </div>
        <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <div class="p-4 mb-3 bg-body-tertiary rounded">
                    <h4 class="fst-italic">Author: {{$post->author->name}}</h4>
                    <p class="mb-0">Created {{$post->author->post_count}} posts</p>
                </div>
                <x-recents />
            </div>
        </div>
    </div>
</x-layout>