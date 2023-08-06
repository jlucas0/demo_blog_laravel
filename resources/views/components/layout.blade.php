<!doctype html>
<html data-bs-theme="auto">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Blog Demo{{$title ?? ''}}</title>
        <link href="/resources/bootstrap.min.css" rel="stylesheet">

    </head>
    <body>
        <div class="container">
            <header class="border-bottom lh-1 py-3">
                <div class="row flex-nowrap justify-content-between align-items-center">
                    <div class="col-6 offset-3 text-center">
                        <a class="blog-header-logo text-body-emphasis text-decoration-none" href="{{route('home')}}"><h1>This is a Simple Demo Blog</h1></a>
                    </div>
                </div>
            </header>
        </div>

        <main id="content" class="container">
            {{$slot}}
        </main>

        <footer class="py-5 text-center text-body-secondary bg-body-tertiary">
            <p>Blog Demo by Juan Lucas</p>
            <p class="mb-0">
                <a href="#content">Back to top</a>
            </p>
        </footer>
    </body>
</html>
