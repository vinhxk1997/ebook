@extends('front.layouts.master')
@section('title', __('app.home'))
@section('content')
<div class="container">
    <div class="row">
        <table class="table-striped col-3 box-category">
            <tbody>
                @for ($i = 0; $i < $meta_count; $i+=2)
                <tr>
                    <td><a style="color: black" href="{{ route('meta', ['slug' => $metas[$i]->slug]) }}">
                    <i class="fa fa-book"></i>&nbsp{{ $metas[$i]->name }}</a></td>
                    <td><a style="color: black" href="{{ route('meta', ['slug' => $metas[$i + 1]->slug]) }}">
                    <i class="fa fa-book"></i>&nbsp{{ $metas[$i + 1]->name }}</a></td>
                </tr>
                @endfor
            </tbody>
        </table>
        <div class="col-6">
            <div class="owl-carousel owl-loaded owl-drag">
                <!-- The slideshow -->
                @foreach ($banners as $banner)
                <div class="item">
                    <a href="{{ $banner->url }}"><img width="100%" height="250px;" src="{{ asset('upload/banners/') }}/{{ $banner->image }}" alt="item"></a>
                </div>
                @endforeach
            </div>
            <div>
                <div></div> 
                <img width="32%" height="200px;" src="http://localhost:/upload/story_covers/0_176x275.jpeg" alt="item">
                <img width="32%" height="200px;" src="http://localhost:/upload/story_covers/0_176x275.jpeg" alt="item">
                <img width="32%" height="200px;" src="http://localhost:/upload/story_covers/0_176x275.jpeg" alt="item">
            </div>
        </div>
        <table class="table-striped col-3 box-review">
            <thead class="text-info">
                <th><h4>Review</h4></th>
            </thead>
            <tbody>
                @foreach ($reviews as $review)
                    <tr>
                        <td><a href="{{ route('reviews') }}/#review-{{ $review->id }}">&nbsp{{ $review->title }}</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-2">
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
        <div class="col-8">
            <h4  class="text-info">Bien tap vien de cu</h4>
            <hr>
            <div class="row d-flex">
                <div class="col-3">
                    <div class="owl-carousel owl-theme owl-loaded" id="carousel">
                        @foreach ($stories as $story)
                        <div class="item" data-id="{{ $story->id }}">
                            <img class="thumbnail thumbnail-md" src="{{ get_story_cover($story, 0) }}"/>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-9">
                    <div id="story-decription">
                        <h3>{{ $stories->first()->title }}</h3>
                        <pre>{{ $stories->first()->summary }}</pre>
                        <a href="{{ route('story', ['id' => $stories->first()->id, 'slug' => $stories->first()->slug]) }}" class="btn btn-info">{{ trans('tran.read') }}</a>
                    </div>
                </div>
            </div>
            <div class="row d-flex">
                @foreach($recommend_stories as $story)
                    @include('front.items.story', ['story' => $story, 'is_col' => true])
                @endforeach
            </div>
        </div>
        <div class="col-2">
            <h4  class="text-info">Hoan thanh</h4>
            <hr>
            <ul>
                @foreach ($completed_stories as $story)
                <li style="margin-left: -35px;" class="text-truncate">
                        <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" style="color:black;" data-toggle="tooltip" title="{{ $story->title }}" rel="noopener noreferrer">
                            {{ $story->title }}</a>
                    <hr>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <h4  class="text-info">Binh chon</h4>
            <hr>
            <ul style="list-style-type:none;">
                @foreach ($vote_stories as $story)
                <li style="margin-left:-50px;" class="text-truncate">
                        <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" style="color:black;" data-toggle="tooltip" title="{{ $story->title }}" rel="noopener noreferrer">
                            {{ $story->title }}</a>
                    <hr>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="col-8">
            <h4  class="text-info">Truyen xem nhieu</h4>
            <hr>
            <div class="row d-flex">
                @foreach($stories_by_view as $story)
                    @include('front.items.story', ['story' => $story, 'is_col' => true])
                @endforeach
            </div>
        </div>
        <div class="col-2">
            <h4 class="text-info">Đang theo dõi</h4>
            <hr>
            <ul style="list-style-type:none;">
                @if($follow_stories != null)
                    @foreach ($follow_stories as $story)
                    <li style="margin-left:-50px;" class="text-truncate">
                            <a href="{{ route('story', ['id' => $story->id, 'slug' => $story->slug]) }}" style="color:black;" data-toggle="tooltip" title="{{ $story->title }}" rel="noopener noreferrer">
                                {{ $story->title }}</a>
                        <hr>
                    </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection