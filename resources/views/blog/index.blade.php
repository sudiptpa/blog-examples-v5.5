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
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <h1>{{ $title }}</h1>
                <hr>
                @foreach($blogs as $post)
                    <div class="post__preview">
                        <div class="post__content">
                            <header>
                                <span>{{ $post->created_at->format('F, d Y') }}</span>
                            </header>
                            <a href="{{ route('app.blog.view', ['slug' => $post->slug]) }}">
                                <h2>{{ $post->name }}</h2>
                            </a>
                            <div class="post__text">
                                {{ str_limit(strip_tags($post->content), 285) }}
                            </div>
                            <div class="post__readmore">
                                <a href="{{ route('app.blog.view', ['slug' => $post->slug]) }}">
                                    Read more...
                                </a>
                            </div>
                            <hr>
                            <div class="facebook__like">
                                <div class="fb-like" data-href="{{ route('app.blog.view', ['slug' => $post->slug]) }}" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                            </div>
                            <br>
                        </div>
                    </div>
                @endforeach
                <div class="pagination">
                    {{ $blogs->appends($_GET)->links() }}
                </div>
            </div>
        </div>
    </div>
@stop
