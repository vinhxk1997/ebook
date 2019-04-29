<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sunra\PhpSimple\HtmlDomParser;
use App\Models\Story;
use App\Models\Meta;
use App\Models\Review;
use App\Repositories\StoryRepository;
use App\Repositories\MetaRepository;
use App\Repositories\ReviewRepository;

class CrawlController extends Controller
{
    protected $story;

    public function __construct(StoryRepository $story, MetaRepository $meta, ReviewRepository $review)
    {
        $this->story = $story;
        $this->meta = $meta;
        $this->review = $review;
    }

    public function index() {
        $dom = HtmlDomParser::file_get_html('https://truyen.tangthuvien.vn/doc-truyen/trieu-hoan-mong-yem', false, null, 0);
        // foreach ($dom->find('#max-volume .cf li a') as $link) {
        //     echo $link->href . '<br>';
        // }

        $link = $dom->find('#max-volume .cf li a')[0];
        $doc = HtmlDomParser::file_get_html($link->href, false, null, 0);
        echo $doc->find('.box-chap', 0)->innertext;
    }

    public function new() {
        $stories = Story::inRandomOrder()->take(6)->get();
        $recommend_stories = Story::where('is_recommended', 1)->inRandomOrder()->take(6)->get();
        $metas = Meta::take(14)->get();
        $meta_count = $metas->count();
        $reviews = Review::orderby('created_at')->take(9)->get();

        return view('front.new', compact('stories', 'metas', 'meta_count', 'reviews', 'recommend_stories'));
    } 
}
