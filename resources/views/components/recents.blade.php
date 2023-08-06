@if(count($posts))
<div>
    <h4 class="fst-italic">Recent posts</h4>
    <ul class="list-unstyled">
        @foreach ($posts as $post)   
            <li>
                <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="{{route('post',$post->slug)}}">
                    <div class="col">
                        <h6 class="mb-0">{{$post->title}}</h6>
                        <small class="text-body-secondary">{{$post->created_at->format('M d, Y')}}</small>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endif