@if($pages > 1)
<nav class="mb-3">
    <ul class="pagination pagination-sm">
        @for($i = 1; $i <= $pages; $i++)
            <li @class(["page-item", "active" => $page == $i])>
                @if($page == $i)
                    <span class="page-link">{{$i}}</span>
                @else
                    <a class="page-link" href="?page={{$i}}">{{$i}}</a>
                @endif
            </li>
        @endfor
    </ul>
</nav>
@endif