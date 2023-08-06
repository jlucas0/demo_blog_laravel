<x-layout>
    <div class="row g-5 mt-5">
        <div class="col-md-8">
            <nav class="mb-3">
                <ul class="pagination pagination-sm">
                  <li class="page-item active" aria-current="page">
                    <span class="page-link">1</span>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                </ul>
            </nav>
            <article class="blog-post">
                <h2 class="display-5 link-body-emphasis mb-1">Sample blog post</h2>
                <p class="blog-post-meta">January 1, 2021 by <a href="#">Mark</a></p>

                <p>This blog post shows a few different types of content that’s supported and styled with Bootstrap. Basic typography, lists, tables, images, code, and more are all supported as expected.</p>
                <a href="{{route('post','slug')}}">Read more</a>
            </article>

            <article class="blog-post">
                <h2 class="display-5 link-body-emphasis mb-1">Another blog post</h2>
                <p class="blog-post-meta">December 23, 2020 by <a href="#">Jacob</a></p>

                <p>This is some additional paragraph placeholder content. It has been written to fill the available space and show how a longer snippet of text affects the surrounding content. We'll repeat it often to keep the demonstration flowing, so be on the lookout for ...</p>
                <a href="{{route('post','slug')}}">Read more</a>
            </article>

            <article class="blog-post">
                <h2 class="display-5 link-body-emphasis mb-1">New feature</h2>
                <p class="blog-post-meta">December 14, 2020 by <a href="#">Chris</a></p>

                <p>This is some additional paragraph placeholder content. It has been written to fill the available space and show how a longer snippet of text affects the surrounding content. We'll repeat it often to keep the demonstration flowing, so be on the lookout for this ...</p>
                <a href="{{route('post','slug')}}">Read more</a>
            </article>

            <nav class="mt-3">
                <ul class="pagination pagination-sm">
                  <li class="page-item active" aria-current="page">
                    <span class="page-link">1</span>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                </ul>
            </nav>

        </div>

        <div class="col-md-4">
            <div class="position-sticky" style="top: 2rem;">
                <div class="p-4 mb-3 bg-body-tertiary rounded">
                    <h4 class="fst-italic">About</h4>
                    <p class="mb-0">Customize this section to tell your visitors a little bit about your publication, writers, content, or something else entirely. Totally up to you.</p>
                </div>
                <x-recents />
            </div>
        </div>
    </div>
</x-layout>