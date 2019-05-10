@extends('front.layouts.master')
@section('title', __('tran.review'))
@section('content')
<div class="container">
    <div class="rows d-flex">
        <div class="col-3">
            <h4  class="text-info">Truyen moi</h4>
            <hr>
            <ul style="list-style-type:none;">
                @foreach ($new_stories as $story)
                <li style="margin-left:-50px;" class="text-truncate">
                        <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" style="color:black;" data-toggle="tooltip" title="{{ $story->title }}" rel="noopener noreferrer">
                            {{ $story->title }}</a>
                    <hr>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-md-9">
            @foreach ($reviews as $review)
            <div class="d-flex row" style="margin:1%;">
                <div class="col-2">
                    <div class="avatar avatar-profile">
                        <img class="img-thumbnail" src="{{ get_avatar($review->user_id) }}" />
                    </div>
                </div>
                <div class="col-10 row d-block" id="review-{{ $review->id }}">
                    <div class="header">
                        <div class="info">
                            <a href="{{ route('user_about', ['user' => $review->user->login_name]) }}">{{ $review->user->full_name }}</a>
                        </div>
                    </div>
                    <details>
                        <summary><strong>{{ $review->title }}</strong></summary>
                        <pre>{{ $review->content }}</pre>
                    </details>
                    <div class="footer d-plex">
                        <a href="{{ route('story', ['id' => $review->story->id, 'slug' => $review->story->slug]) }}" class="btn btn-outline-info"><strong>{{ $review->story->title }}</strong></a>
                    </div>
                </div>
            </div>
            @endforeach
            <div style="margin-top: 1%;">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</div>
@stop
