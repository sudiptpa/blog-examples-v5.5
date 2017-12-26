@extends('layouts.default')

@section('head')
    <meta property="og:url" content="{{ $open_graph['url'] }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $open_graph['title'] }}" />
    <meta property="og:description" content="{{ $open_graph['description'] }}" />
    <meta property="og:image" content="{{ $open_graph['image'] }}" />

    <div id="fb-root"></div>
    <script>
        (function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.11&appId=180539309049634';
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>
@stop

@section('content')
    <div class="container">
        <article>
            <div class="row">
                <div class="col-lg-12">
                    <div class="post__content">
                        <header>
                            <span>{{ $blog->created_at->format('F, d Y') }}</span>
                            <p>
                                <h2>{{ $blog->title }}</h2>
                            </p>
                        </header>
                        <div class="blog__excerpt">{{ $blog->excerpt }}</div>
                        <div class="blog__content">{{ $blog->content }}</div>
                        <hr>
                        <div class="facebook__like">
                            <div class="fb-like" data-href="{{ route('app.blog.view', ['slug' => $blog->slug]) }}" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </article>
    </div>
@stop
