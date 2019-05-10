@foreach ($stories as $story)
<div class="row d-flex">
    <div class="col-9">
        <div class="story d-flex" data-url="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}">
            <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" class="on-story-preview item-cover">
                <img width="150px" heght="100px" src="{{ get_story_cover($story, 0) }}">
            </a>
            <div class="story-details text-truncate">
                <strong class="story-title text-truncate">
                    <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" data-toggle="tooltip" title="Dolores in illum rerum."
                        class="on-story-preview text-truncate text-success" data-original-title="Dolores in illum rerum.">{{ $story->title }}</a>
                </strong>
                <div class="story-uploader d-flex">
                    @if (!isset($in_profile))
                        <div class="story-uploader"><a class="text-info" href="{{ route('user_about', ['user' => $story->user->login_name]) }}">@lang('app.by') {{ $story->user->full_name }}</a></div>
                    @endif
                </div>
                <div class="story-stats">
                        <span class="view-count"><i class="fa fa-eye"></i>&nbsp;{{ $story->views }}</span>
                        <span class="vote-count"><i class="fa fa-star"></i>&nbsp;{{ $story->votes }}</span>
                        <span class="chapter-count"><i class="fa fa-list-ul"></i>&nbsp;{{ $story->chapters->count() }}</span>
                </div>
                <div class="story-summary text-dark">
                    <p>{{ $story->summary }}</p>
                </div>
                <div class="story-stats">
                    <span class="text-dark">{{ trans('tran.update') }}:</span>    
                    <span class="view-count">{{ $story->updated_at }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-3">
        <a style="width: 10em;" href="{{ route('read_chapter', ['id' => $story->chapters->first()->id, 'slug' => $story->chapters->first()->slug]) }}" class="btn btn-danger">{{ trans('tran.read') }}</a>
        <a style="width: 10em; margin-top:1em;"  href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" class="btn btn-outline-dark">{{ trans('tran.view_detail') }}</a>
    </div>
</div>
<hr>
@endforeach