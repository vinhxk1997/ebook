<div class="story d-flex col-4 mb-3" data-url="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}">
    <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" class="on-story-preview item-cover">
        <img width="100px" heght="70px" src="{{ get_story_cover($story, 0) }}" />
    </a>
    <div class="story-details text-truncate">
        <h5 class="story-title text-truncate">
            <a class="text-success" href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" data-toggle="tooltip" title="{{ $story->title }}" class="on-story-preview text-truncate">{{ $story->title }}</a>
        </h5>
        @if (!isset($in_profile))
        <div class="story-uploader"><a href="{{ route('user_about', ['user' => $story->user->login_name]) }}">@lang('app.by') {{ $story->user->full_name }}</a></div>
        @endif
        <div class="story-stats">
            <div>
            <span class="view-count"><i class="fa fa-eye"></i>&nbsp{{ $story->views() }}</span>
            </div>
            <div>
            <span class="vote-count"><i class="fa fa-star"></i>&nbsp{{ $story->votes() }}</span>
            </div>
            <div>
            <span class="chapter-count"><i class="fa fa-list-ul"></i>&nbsp{{ $story->chapters()->published()->count() }}</span>
            </div>
        </div>
        <div class="story-tags">
            <ul class="tag-items">
                @foreach ($story->metas->take(config('app.shown_meta')) as $meta)
                <li><a href="{{ route('meta', ['slug' => $meta->slug]) }}">{{ $meta->name }}</a></li>
                @endforeach
            </ul>
            @if ($story->metas->count() > config('app.shown_meta'))
            <span class="on-story-preview num-not-show">
                +@lang('app.more_tag', ['count' => ($story->metas->count() - config('app.shown_meta'))])
            </span>
            @endif
        </div>
    </div>
</div>
