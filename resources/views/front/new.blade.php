@extends('front.layouts.master')
@section('title', __('app.home'))
@section('content')
<div class="container">
    <div class="row">
        <table class="table-striped col-3 box-category">
            <tbody>
                @for ($i = 0; $i < $meta_count; $i+=2)
                <tr>
                    <td><i class="fa fa-book"></i>&nbsp{{ $metas[$i]->name }}</td>
                    <td><i class="fa fa-book"></i>&nbsp{{ $metas[$i + 1]->name }}</td>
                </tr>
                @endfor
            </tbody>
        </table>
        <div class="col-7">
            <div class="owl-carousel owl-loaded owl-drag">
                <!-- The slideshow -->
                <div class="item">
                    <img src="{{ asset('upload/banners/slide1.jpg') }}" alt="item">
                </div>
                <div class="item">
                    <img src="{{ asset('upload/banners/slide2.jpg') }}" alt="item">
                </div>
                <div class="item">
                    <img src="{{ asset('upload/banners/slide3.jpg') }}" alt="item">
                </div>
            </div>
            <div>
                <div></div> 
                <img width="32%" height="200px;" src="http://localhost:/upload/story_covers/0_176x275.jpeg" alt="item">
                <img width="32%" height="200px;" src="http://localhost:/upload/story_covers/0_176x275.jpeg" alt="item">
                <img width="32%" height="200px;" src="http://localhost:/upload/story_covers/0_176x275.jpeg" alt="item">
            </div>
        </div>
        <table class="table-striped col-2 box-review">
            <thead>
                <th><h3>Review</h3></th>
            <thead>
            <tbody>
                @foreach ($reviews as $review)
                    <tr>
                        <td>&nbsp{{ $review->title }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-2">
            <h4>Truyen moi</h4>
            <hr>
            <ul>
                <li>
                    ten truyen
                </li>
            </ul>
        </div>
        <div class="col-8">
            <h4>Bien tap vien de cu</h4>
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
                        <h3>{{ $stories[0]->title }}</h3>
                        <pre>{{ $stories[0]->summary }}</pre>
                        <a href="' + ebook.base_url + '/story/' + rs.id + '-' + rs.slug + '" class="btn btn-info">{{ trans('tran.read') }}</a>
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
            <h4>Đang theo dõi</h4>
            <hr>
            <ul>
                <li>
                    ten truyen
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <h4>Truyen moi</h4>
            <hr>
            <ul>
                <li>
                    ten truyen
                </li>
            </ul>
        </div>
        <div class="col-8">
            <h4>Bien tap vien de cu</h4>
            <hr>
            <div class="row d-flex">
                <div class="story d-flex col-4 mb-3"
                    data-url="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad">
                    <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                        class="on-story-preview item-cover">
                        <img width="100px" heght="70px"  src="http://localhost:/upload/story_covers/0_176x275.jpeg">
                    </a>
                    <div class="story-details text-truncate">
                        <h5 class="story-title text-truncate">
                            <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                                class="on-story-preview text-truncate">Consequatur ullam eum et debitis.</a>
                        </h5>
                        <div class="story-uploader"><a href="http://localhost:/user/rthinh">By Khưu Huấn</a></div>
                        <div class="story-stats">
                            <span class="view-count"><i class="fa fa-eye"></i> 1</span>
                            <span class="vote-count"><i class="fa fa-star"></i>0</span>
                            <span class="chapter-count"><i class="fa fa-list-ul"></i> 6</span>
                        </div>
                        <div class="story-tags">
                            <ul class="tag-items">
                                <li><a href="http://localhost:/stories/essea">essea</a></li>
                                <li><a href="http://localhost:/stories/explicaboi">explicaboi</a></li>
                                <li><a href="http://localhost:/stories/ullamt">ullamt</a></li>
                                <li><a href="http://localhost:/stories/quow">quow</a></li>
                                <li><a href="http://localhost:/stories/amety">amety</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="story d-flex col-4 mb-3"
                    data-url="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad">
                    <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                        class="on-story-preview item-cover">
                        <img width="100px" heght="70px" src="http://localhost:/upload/story_covers/0_176x275.jpeg">
                    </a>
                    <div class="story-details text-truncate">
                        <h5 class="story-title text-truncate">
                            <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                                class="on-story-preview text-truncate">Consequatur ullam eum et debitis.</a>
                        </h5>
                        <div class="story-uploader"><a href="http://localhost:/user/rthinh">By Khưu Huấn</a></div>
                        <div class="story-stats">
                            <span class="view-count"><i class="fa fa-eye"></i> 1</span>
                            <span class="vote-count"><i class="fa fa-star"></i>0</span>
                            <span class="chapter-count"><i class="fa fa-list-ul"></i> 6</span>
                        </div>
                        <div class="story-tags">
                            <ul class="tag-items">
                                <li><a href="http://localhost:/stories/essea">essea</a></li>
                                <li><a href="http://localhost:/stories/explicaboi">explicaboi</a></li>
                                <li><a href="http://localhost:/stories/ullamt">ullamt</a></li>
                                <li><a href="http://localhost:/stories/quow">quow</a></li>
                                <li><a href="http://localhost:/stories/amety">amety</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="story d-flex col-4 mb-3"
                    data-url="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad">
                    <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                        class="on-story-preview item-cover">
                        <img width="100px" heght="70px" src="http://localhost:/upload/story_covers/0_176x275.jpeg">
                    </a>
                    <div class="story-details text-truncate">
                        <h5 class="story-title text-truncate">
                            <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                                class="on-story-preview text-truncate">Consequatur ullam eum et debitis.</a>
                        </h5>
                        <div class="story-uploader"><a href="http://localhost:/user/rthinh">By Khưu Huấn</a></div>
                        <div class="story-stats">
                            <span class="view-count"><i class="fa fa-eye"></i> 1</span>
                            <span class="vote-count"><i class="fa fa-star"></i>0</span>
                            <span class="chapter-count"><i class="fa fa-list-ul"></i> 6</span>
                        </div>
                        <div class="story-tags">
                            <ul class="tag-items">
                                <li><a href="http://localhost:/stories/essea">essea</a></li>
                                <li><a href="http://localhost:/stories/explicaboi">explicaboi</a></li>
                                <li><a href="http://localhost:/stories/ullamt">ullamt</a></li>
                                <li><a href="http://localhost:/stories/quow">quow</a></li>
                                <li><a href="http://localhost:/stories/amety">amety</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row d-flex">
                <div class="story d-flex col-4 mb-3"
                    data-url="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad">
                    <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                        class="on-story-preview item-cover">
                        <img width="100px" heght="70px"  src="http://localhost:/upload/story_covers/0_176x275.jpeg">
                    </a>
                    <div class="story-details text-truncate">
                        <h5 class="story-title text-truncate">
                            <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                                class="on-story-preview text-truncate">Consequatur ullam eum et debitis.</a>
                        </h5>
                        <div class="story-uploader"><a href="http://localhost:/user/rthinh">By Khưu Huấn</a></div>
                        <div class="story-stats">
                            <span class="view-count"><i class="fa fa-eye"></i> 1</span>
                            <span class="vote-count"><i class="fa fa-star"></i>0</span>
                            <span class="chapter-count"><i class="fa fa-list-ul"></i> 6</span>
                        </div>
                        <div class="story-tags">
                            <ul class="tag-items">
                                <li><a href="http://localhost:/stories/essea">essea</a></li>
                                <li><a href="http://localhost:/stories/explicaboi">explicaboi</a></li>
                                <li><a href="http://localhost:/stories/ullamt">ullamt</a></li>
                                <li><a href="http://localhost:/stories/quow">quow</a></li>
                                <li><a href="http://localhost:/stories/amety">amety</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="story d-flex col-4 mb-3"
                    data-url="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad">
                    <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                        class="on-story-preview item-cover">
                        <img width="100px" heght="70px" src="http://localhost:/upload/story_covers/0_176x275.jpeg">
                    </a>
                    <div class="story-details text-truncate">
                        <h5 class="story-title text-truncate">
                            <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                                class="on-story-preview text-truncate">Consequatur ullam eum et debitis.</a>
                        </h5>
                        <div class="story-uploader"><a href="http://localhost:/user/rthinh">By Khưu Huấn</a></div>
                        <div class="story-stats">
                            <span class="view-count"><i class="fa fa-eye"></i> 1</span>
                            <span class="vote-count"><i class="fa fa-star"></i>0</span>
                            <span class="chapter-count"><i class="fa fa-list-ul"></i> 6</span>
                        </div>
                        <div class="story-tags">
                            <ul class="tag-items">
                                <li><a href="http://localhost:/stories/essea">essea</a></li>
                                <li><a href="http://localhost:/stories/explicaboi">explicaboi</a></li>
                                <li><a href="http://localhost:/stories/ullamt">ullamt</a></li>
                                <li><a href="http://localhost:/stories/quow">quow</a></li>
                                <li><a href="http://localhost:/stories/amety">amety</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="story d-flex col-4 mb-3"
                    data-url="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad">
                    <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                        class="on-story-preview item-cover">
                        <img width="100px" heght="70px" src="http://localhost:/upload/story_covers/0_176x275.jpeg">
                    </a>
                    <div class="story-details text-truncate">
                        <h5 class="story-title text-truncate">
                            <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                                class="on-story-preview text-truncate">Consequatur ullam eum et debitis.</a>
                        </h5>
                        <div class="story-uploader"><a href="http://localhost:/user/rthinh">By Khưu Huấn</a></div>
                        <div class="story-stats">
                            <span class="view-count"><i class="fa fa-eye"></i> 1</span>
                            <span class="vote-count"><i class="fa fa-star"></i>0</span>
                            <span class="chapter-count"><i class="fa fa-list-ul"></i> 6</span>
                        </div>
                        <div class="story-tags">
                            <ul class="tag-items">
                                <li><a href="http://localhost:/stories/essea">essea</a></li>
                                <li><a href="http://localhost:/stories/explicaboi">explicaboi</a></li>
                                <li><a href="http://localhost:/stories/ullamt">ullamt</a></li>
                                <li><a href="http://localhost:/stories/quow">quow</a></li>
                                <li><a href="http://localhost:/stories/amety">amety</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2">
            <h4>Đang theo dõi</h4>
            <hr>
            <ul>
                <li>
                    ten truyen
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-2">
            <h4>Truyen moi</h4>
            <hr>
            <ul>
                <li>
                    ten truyen
                </li>
            </ul>
        </div>
        <div class="col-8">
            <h4>Bien tap vien de cu</h4>
            <hr>
            <div class="row d-flex">
                <div class="story d-flex col-4 mb-3"
                    data-url="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad">
                    <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                        class="on-story-preview item-cover">
                        <img width="100px" heght="70px"  src="http://localhost:/upload/story_covers/0_176x275.jpeg">
                    </a>
                    <div class="story-details text-truncate">
                        <h5 class="story-title text-truncate">
                            <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                                class="on-story-preview text-truncate">Consequatur ullam eum et debitis.</a>
                        </h5>
                        <div class="story-uploader"><a href="http://localhost:/user/rthinh">By Khưu Huấn</a></div>
                        <div class="story-stats">
                            <span class="view-count"><i class="fa fa-eye"></i> 1</span>
                            <span class="vote-count"><i class="fa fa-star"></i>0</span>
                            <span class="chapter-count"><i class="fa fa-list-ul"></i> 6</span>
                        </div>
                        <div class="story-tags">
                            <ul class="tag-items">
                                <li><a href="http://localhost:/stories/essea">essea</a></li>
                                <li><a href="http://localhost:/stories/explicaboi">explicaboi</a></li>
                                <li><a href="http://localhost:/stories/ullamt">ullamt</a></li>
                                <li><a href="http://localhost:/stories/quow">quow</a></li>
                                <li><a href="http://localhost:/stories/amety">amety</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="story d-flex col-4 mb-3"
                    data-url="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad">
                    <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                        class="on-story-preview item-cover">
                        <img width="100px" heght="70px" src="http://localhost:/upload/story_covers/0_176x275.jpeg">
                    </a>
                    <div class="story-details text-truncate">
                        <h5 class="story-title text-truncate">
                            <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                                class="on-story-preview text-truncate">Consequatur ullam eum et debitis.</a>
                        </h5>
                        <div class="story-uploader"><a href="http://localhost:/user/rthinh">By Khưu Huấn</a></div>
                        <div class="story-stats">
                            <span class="view-count"><i class="fa fa-eye"></i> 1</span>
                            <span class="vote-count"><i class="fa fa-star"></i>0</span>
                            <span class="chapter-count"><i class="fa fa-list-ul"></i> 6</span>
                        </div>
                        <div class="story-tags">
                            <ul class="tag-items">
                                <li><a href="http://localhost:/stories/essea">essea</a></li>
                                <li><a href="http://localhost:/stories/explicaboi">explicaboi</a></li>
                                <li><a href="http://localhost:/stories/ullamt">ullamt</a></li>
                                <li><a href="http://localhost:/stories/quow">quow</a></li>
                                <li><a href="http://localhost:/stories/amety">amety</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="story d-flex col-4 mb-3"
                    data-url="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad">
                    <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                        class="on-story-preview item-cover">
                        <img width="100px" heght="70px" src="http://localhost:/upload/story_covers/0_176x275.jpeg">
                    </a>
                    <div class="story-details text-truncate">
                        <h5 class="story-title text-truncate">
                            <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                                class="on-story-preview text-truncate">Consequatur ullam eum et debitis.</a>
                        </h5>
                        <div class="story-uploader"><a href="http://localhost:/user/rthinh">By Khưu Huấn</a></div>
                        <div class="story-stats">
                            <span class="view-count"><i class="fa fa-eye"></i> 1</span>
                            <span class="vote-count"><i class="fa fa-star"></i>0</span>
                            <span class="chapter-count"><i class="fa fa-list-ul"></i> 6</span>
                        </div>
                        <div class="story-tags">
                            <ul class="tag-items">
                                <li><a href="http://localhost:/stories/essea">essea</a></li>
                                <li><a href="http://localhost:/stories/explicaboi">explicaboi</a></li>
                                <li><a href="http://localhost:/stories/ullamt">ullamt</a></li>
                                <li><a href="http://localhost:/stories/quow">quow</a></li>
                                <li><a href="http://localhost:/stories/amety">amety</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row d-flex">
                <div class="story d-flex col-4 mb-3"
                    data-url="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad">
                    <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                        class="on-story-preview item-cover">
                        <img width="100px" heght="70px"  src="http://localhost:/upload/story_covers/0_176x275.jpeg">
                    </a>
                    <div class="story-details text-truncate">
                        <h5 class="story-title text-truncate">
                            <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                                class="on-story-preview text-truncate">Consequatur ullam eum et debitis.</a>
                        </h5>
                        <div class="story-uploader"><a href="http://localhost:/user/rthinh">By Khưu Huấn</a></div>
                        <div class="story-stats">
                            <span class="view-count"><i class="fa fa-eye"></i> 1</span>
                            <span class="vote-count"><i class="fa fa-star"></i>0</span>
                            <span class="chapter-count"><i class="fa fa-list-ul"></i> 6</span>
                        </div>
                        <div class="story-tags">
                            <ul class="tag-items">
                                <li><a href="http://localhost:/stories/essea">essea</a></li>
                                <li><a href="http://localhost:/stories/explicaboi">explicaboi</a></li>
                                <li><a href="http://localhost:/stories/ullamt">ullamt</a></li>
                                <li><a href="http://localhost:/stories/quow">quow</a></li>
                                <li><a href="http://localhost:/stories/amety">amety</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="story d-flex col-4 mb-3"
                    data-url="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad">
                    <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                        class="on-story-preview item-cover">
                        <img width="100px" heght="70px" src="http://localhost:/upload/story_covers/0_176x275.jpeg">
                    </a>
                    <div class="story-details text-truncate">
                        <h5 class="story-title text-truncate">
                            <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                                class="on-story-preview text-truncate">Consequatur ullam eum et debitis.</a>
                        </h5>
                        <div class="story-uploader"><a href="http://localhost:/user/rthinh">By Khưu Huấn</a></div>
                        <div class="story-stats">
                            <span class="view-count"><i class="fa fa-eye"></i> 1</span>
                            <span class="vote-count"><i class="fa fa-star"></i>0</span>
                            <span class="chapter-count"><i class="fa fa-list-ul"></i> 6</span>
                        </div>
                        <div class="story-tags">
                            <ul class="tag-items">
                                <li><a href="http://localhost:/stories/essea">essea</a></li>
                                <li><a href="http://localhost:/stories/explicaboi">explicaboi</a></li>
                                <li><a href="http://localhost:/stories/ullamt">ullamt</a></li>
                                <li><a href="http://localhost:/stories/quow">quow</a></li>
                                <li><a href="http://localhost:/stories/amety">amety</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="story d-flex col-4 mb-3"
                    data-url="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad">
                    <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                        class="on-story-preview item-cover">
                        <img width="100px" heght="70px" src="http://localhost:/upload/story_covers/0_176x275.jpeg">
                    </a>
                    <div class="story-details text-truncate">
                        <h5 class="story-title text-truncate">
                            <a href="http://localhost:/story/22-exercitationem-similique-et-itaque-dolore-qui-adipisci-ad"
                                class="on-story-preview text-truncate">Consequatur ullam eum et debitis.</a>
                        </h5>
                        <div class="story-uploader"><a href="http://localhost:/user/rthinh">By Khưu Huấn</a></div>
                        <div class="story-stats">
                            <span class="view-count"><i class="fa fa-eye"></i> 1</span>
                            <span class="vote-count"><i class="fa fa-star"></i>0</span>
                            <span class="chapter-count"><i class="fa fa-list-ul"></i> 6</span>
                        </div>
                        <div class="story-tags">
                            <ul class="tag-items">
                                <li><a href="http://localhost:/stories/essea">essea</a></li>
                                <li><a href="http://localhost:/stories/explicaboi">explicaboi</a></li>
                                <li><a href="http://localhost:/stories/ullamt">ullamt</a></li>
                                <li><a href="http://localhost:/stories/quow">quow</a></li>
                                <li><a href="http://localhost:/stories/amety">amety</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-2">
            <h4>Đang theo dõi</h4>
            <hr>
            <ul>
                <li>
                    ten truyen
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection