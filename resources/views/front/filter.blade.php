@extends('front.layouts.master')
@section('title', __('tran.review'))
@section('content')
<div class="container">
	<div class="row">
		<div class="col-3">
			<div class="row">
				<h3>{{ trans('tran.category') }}</h3>
				<select id="select-cate" class="custom-select custom-select-lg mb-3">
					<option selected value="0">All</option>
					@foreach($metas as $meta)
						<option value="{{ $meta->id }}">{{ $meta->name }}</option>
					@endforeach
				</select>
			</div>
			<hr>
			<div class="row d-block">
				<div>
					<h3>Status</h3>
				</div>
				<div class="status">
					<a href="javascript:" class="btn btn-outline-dark filter active" data-value="0">All</a>
					<a href="javascript:" class="btn btn-outline-dark filter" data-value="1">Completed</a>
					<a href="javascript:" class="btn btn-outline-dark filter" data-value="2">Ongoing</a>
				</div>
			</div>
			<hr>
			<div class="row d-block">
				<div>
					<h3>Rank</h3>
				</div>
				<div class="rank">
					<a href="javascript:" class="btn btn-outline-dark filter active" data-value="0">Not Rank</a>
					<a href="javascript:" class="btn btn-outline-dark filter" data-value="1">Recommended</a>
					<a href="javascript:" class="btn btn-outline-dark filter" data-value="2">Top View</a>
					<a href="javascript:" class="btn btn-outline-dark filter" data-value="3">Top Vote</a>
					<a href="javascript:" class="btn btn-outline-dark filter" data-value="4">Top follow</a>
				</div>
			</div>
			<hr>
			<div class="row d-block">
				<div>
					<h3>Tags</h3>
				</div>
				<div class="tag">
					<a href="javascript:" class="btn btn-outline-dark text-capitalize filter active" data-value="0">no filter</a>
					@foreach($tags as $tag)
						<a href="javascript:" class="btn btn-outline-dark text-capitalize filter" data-value="{{ $tag->id }}">{{ $tag->name }}</a>
					@endforeach
				</div>
			</div>
		</div>
		<div class="col-9">
			<div><h1 class="text-center">{{ trans('tran.filter') }}</h1></div>
			<div id="filter">
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
			@if ($stories->total() > 1)
				<div class="float-right">{{ $stories->links() }}</div>
			@endif
			</div>
		</div>
	</div>
</div>
@stop