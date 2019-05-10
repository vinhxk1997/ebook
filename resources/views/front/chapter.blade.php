@extends('front.layouts.master')
@section('title', 'Chapter title')
@section('content')
<div id="story-reading">
    <div id="top-bar" class="fixed-top">
        <div class="container d-flex justify-content-between">
            <div class="top-bar-story dropdown">
                <button class="btn btn-toc dropdown-toggle" type="button" id="chaptersList" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <span class="cover cover-xxs float-left">
                        <img src="{{ get_story_cover($story) }}" />
                    </span>
                    <span class="info">
                        <h1 class="story-title">{{ $story->title }}</h1>
                        <small>@lang('app.by') {{ $story->user->full_name }}</small>
                    </span>
                </button>
                <div class="dropdown-menu" aria-labelledby="chaptersList">
                    <div class="toc-header text-center">
                        <h6>
                            <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}">
                                {{ $story->title }}
                            </a>
                        </h6>
                        <small>@lang('app.table_of_contents')</small>
                    </div>
                    <div class="table-of-contents list-group list-group-flush disable-body-scroll">
                        @foreach ($story->chapters as $story_chapter)
                            <a href="{{ route('read_chapter', ['id' => $story_chapter->id, 'slug' => $story_chapter->slug]) }}" class="list-group-item{{ $story_chapter->id == request()->route('id') ? ' active' : '' }}">
                                {{ $story_chapter->title }}
                                @if (auth()->user() && $story_chapter->views()->where('visitor', auth()->user()->id)->count())
                                    <i class="fa fa-check"></i>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            @auth
            <div class="top-bar-actions my-auto">
                <div class="d-inline-block dropdown button-lists-add" data-id="{{ $story->id }}">
                    <button class="btn btn-primary on-lists-add">+</button>
                    <div class="dropdown-menu dropdown-menu-right lists"></div>
                </div>
                @if ($vote != null)
                <div class="d-inline-block button-vote">
                    <button class="btn btn-default btnvote voted" data-id="{{ $chapter->id }}"><i class="fa fa-star mr-2"></i> @lang('app.vote')</button>
                </div>
                @else
                <div class="d-inline-block button-vote">
                    <button class="btn btn-default btnvote unvoted" data-id="{{ $chapter->id }}"><i class="fa fa-star mr-2"></i> @lang('app.vote')</button>
                </div>
                @endif
            </div>
            @endauth
        </div>
    </div>
    <div id="chapter-container">
        <article class="story-chapter">
            <div class="container">
                <div class="chapter-header text-center border-bottom">
                    <h2>{{ $chapter->title }}</h2>
                    <div class="story-stats">
                        <span class="count-view"><i class="fa fa-eye"></i> {{ views($chapter)->count() }}</span>
                        <span class="count-vote"><i class="fa fa-star"></i> {{ $chapter->votes_count }}</span>
                        <span class="count-chapter"><i class="fa fa-comment"></i> <a href="#comments">{{ $chapter->comments_count }}</a></span>
                    </div>
                    <div class="story-author">
                        <a class="avatar avatar-sm mx-auto">
                            <img src="{{ get_avatar($story->user) }}" />
                        </a>
                        @lang('app.by') <a href="{{ route('user_about', ['user' => $story->user->login_name]) }}">{{ $story->user->full_name }}</a>
                    </div>
                </div>
                <div class="chapter-content row">
                    <div class="col-md-1 col-lg-2 share-bar">
                        <div class="sticky-top">
                            <div class="title">@lang('app.share')</div>
                            <a class="social-share" target="_blank" href="https://www.facebook.com/sharer.php?u={{ $chapter->share_url }}">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x text-facebook"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                            <a class="social-share" target="_blank" href="https://twitter.com/intent/tweet?text={{ $story->share_text }}&url={{ $story->share_url }}">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x text-twitter"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span></a>
                            @if (auth()->user()) 
                            <div class="social-share dropup">
                                <a class="social-share" href="#" data-toggle="dropdown">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x text-secondary"></i>
                                        <i class="fa fa-ellipsis-h fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-left">
                                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#myModalReport"><i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        @lang('app.report_this_story')</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-7 col-lg-8 main-content">
                        <div class="content">
                            <span id="size-content">
                                {{ $chapter->content }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-1 col-lg-2 share-bar">
                        <div class="sticky-top">
                            <a href="javascript:" data-toggle="dropdown">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x text-secondary"></i>
                                    <i class="fa fa-cog fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:" class="dropdown-item"><label for="font">Font-size:&nbsp</label><input id="font-change" name="font" type="number" value="20" min="10" max="60" required style="width: 50px;"></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="chapter-footer row">
                    <div class="col-md-7 offset-md-1 col-lg-6 offset-lg-3">
                        <div class="next">
                        @if ($next_chapter)
                            <a class="btn btn-primary btn-lg btn-block text-white" href="{{ route('read_chapter', ['id' => $next_chapter->id, 'slug' => $next_chapter->slug]) }}">@lang('app.continue_reading_next_chapter')
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                            </a>
                        @else
                        <div class="alert alert-warning text-center">
                            <p>@lang('app.finished_reading')</p>
                            <strong>{{ $story->title }}</strong>
                        </div>
                        @endif
                        </div>
                        <div class="chapter-actions d-flex justify-content-between mt-3">
                            <div class="actions my-auto">
                                @auth
                                <div class="d-inline-block dropdown button-lists-add" data-id="{{ $story->id }}">
                                    <button class="btn on-lists-add"><i class="fa fa-plus"></i> @lang('app.add')</button>
                                    <div class="dropdown-menu dropdown-menu-left lists"></div>
                                </div>
                                    @if ($vote != null)
                                    <div class="d-inline-block button-vote">
                                        <button class="btn btn-default btnvote voted" data-id="{{ $chapter->id }}"><i class="fa fa-star mr-2"></i> @lang('app.vote')</button>
                                    </div>
                                    @else
                                    <div class="d-inline-block button-vote">
                                        <button class="btn btn-default btnvote unvoted" data-id="{{ $chapter->id }}"><i class="fa fa-star mr-2"></i> @lang('app.vote')</button>
                                    </div>
                                    @endif
                                @endauth
                            </div>
                            <div class="share">
                                <a class="social-share" target="_blank" href="https://www.facebook.com/sharer.php?u={{ $chapter->share_url }}">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x text-facebook"></i>
                                        <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                                <a class="social-share" target="_blank" href="https://twitter.com/intent/tweet?text={{ $chapter->share_text }}&url={{ $chapter->share_url }}">
                                    <span class="fa-stack fa-lg">
                                        <i class="fa fa-circle fa-stack-2x text-twitter"></i>
                                        <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                    </span></a>
                                @if (auth()->user())
                                <div class="social-share dropdown">
                                    <a class="social-share" href="#" data-toggle="dropdown">
                                        <span class="fa-stack fa-lg">
                                            <i class="fa fa-circle fa-stack-2x text-secondary"></i>
                                            <i class="fa fa-ellipsis-h fa-stack-1x fa-inverse"></i>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#myModalReport"><i class="fa fa-exclamation-circle"
                                                aria-hidden="true"></i> @lang('app.report_this_story')</a>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="chapter-comments mt-3" id="comments">
                            @auth
                            <div class="add-comment">
                            <div class="comment-form d-flex">
                                <div class="user-avatar">
                                    <div class="avatar avatar-md">
                                        <img src="{{ get_avatar(Auth::user()) }}" />
                                    </div>
                                </div>
                                <div class="comment-input flex-grow-1">
                                    {!!  Form::textarea('text', '',['class' => 'form-control', 'rows' => '1', 'id' => 'comment-text']) !!}
                                    <div class="d-none justify-content-end mt-1">
                                        <button id="post-submit" data-id="{{ $chapter->id }}" class="btn btn-sm btn-primary on-post ml-2" disabled="">Post</button>
                                    </div>
                                </div>
                            </div>
                            </div>
                            @endauth
                            <div class="collection" id="chapterComments">
                            @if ($chapter->comments->count())                           
                                @foreach ($chapter->comments as $comment)
                                @include('front.items.comment', ['comment' => $comment])
                                @endforeach
                            </div>
                                @if ($chapter->comments->hasPages())
                                <button class="btn btn-light btn-block mt-3 on-show-more" data-url="{{ route('chapter_comments', ['id' => $chapter->id, 'page' => $chapter->comments->currentPage() + 1]) }}" data-target="#chapterComments">
                                    @lang('app.show_more')
                                    <i class="fa fa-angle-down" aria-hidden="true"></i>
                                </button>
                                @endif
                            @else
                            <p class="py-3">@lang('app.no_comments')</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </div>
    @if ($recommended_stories->count())
    <div class="chapter-recommendations">
        <div class="container">
            <div class="h3 py-3">@lang('app.recommendations')</div>
            <div class="collection row">
                @foreach ($recommended_stories as $recommended_story)
                    @include('front.items.story', ['story' => $recommended_story])
                @endforeach
            </div>
        </div>
    </div>
    @endif
    <!-- Modal report-->
    <div class="modal fade" id="myModalReport" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ trans('tran.report') }}</h4>
                </div>
                {!! Form::open(['route' => ['user_report', $story->id], 'method' => 'POST']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label(trans('tran.content'), '', ['class' => '']) !!}
                        {!! Form::textarea('content', null, ['class' => 'form-control' . ($errors->has('address') ? ' is-invalid' : ''), 'autofocus', 'required']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::button(trans('tran.cancel'), ['class' => 'btn btn-dark pull-left', 'data-dismiss' => 'modal', 'type' => 'button']) !!}
                    {!! Form::button(trans('tran.create'), ['class' => 'btn btn-info pull-right', 'type' => 'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<script>
  var msg = '{{Session::get('success')}}';
  var exist = '{{Session::has('success')}}';
  if(exist){
    alert(msg);
  }
</script>
@endsection
