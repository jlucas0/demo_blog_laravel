<x-layout>
    <div class="row g-5 mt-5">
        <div class="col-md-8">
            <x-pagination :page='$page' :adapter='\App\Adapters\PostAdapter::class' :perPage='\App\Adapters\PostAdapter::DEFAULT_LIST_AMOUNT' />
            @if(count($posts))
                @foreach($posts as $post)
                    <article class="blog-post mb-4">
                        <h2 class="display-5 link-body-emphasis mb-1">{{$post->title}}</h2>
                        <p class="blog-post-meta">{{$post->created_at->format('M d, Y')}} by {{$post->author->name}}</p>

                        <p>{{$post->extract}}</p>
                        <a href="{{route('post',$post->slug)}}">Read more</a>
                    </article>
                @endforeach
            @else
                <h3>There are no posts yet</h3>
            @endif
            <x-pagination :page='$page' :adapter='\App\Adapters\PostAdapter::class' :perPage='\App\Adapters\PostAdapter::DEFAULT_LIST_AMOUNT' />

        </div>

        <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <x-recents />
            </div>
        </div>
    </div>
</x-layout>