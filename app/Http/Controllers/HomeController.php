<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Meta;
use App\Models\Review;
use App\Models\Banner;
use App\Repositories\StoryRepository;
use App\Repositories\VoteRepository;
use Auth, DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    protected $story;
    protected $vote;    

    public function __construct(StoryRepository $story, VoteRepository $vote)
    {
        $this->story = $story;
        $this->vote = $vote;
    }

    public function index()
    {
        $banners = Banner::all();
        $stories = Story::published()->inRandomOrder()->take(6)->get();
        $recommend_stories = Story::published()->where('is_recommended', 1)->inRandomOrder()->take(6)->get();
        $metas = Meta::take(14)->get();
        $meta_count = $metas->count();
        $reviews = Review::orderby('created_at')->take(9)->get();
        $new_stories = Story::published()->orderBy('updated_at', 'desc')->take(11)->get();
        $completed_stories = Story::published()->where('is_complete', 1)->take(11)->get();
        $vote_stories = Story::all()->sortByDesc(function ($story) {
            return $story->votes();
        })->where('is_published', 1)->take(7);
        $follow_stories = null;
        if (auth()->user()) {
            $follow_stories = auth()->user()->archives()->published()->where('is_archive', 1)->take(7)->get();
        }
        $stories_by_view = Story::all()->sortByDesc(function ($story) {
            return $story->votes();
        })->where('is_published', 1)->take(6);

        return view('front.home', compact('stories', 'metas', 'meta_count', 'reviews', 'recommend_stories', 'new_stories'
        , 'completed_stories', 'vote_stories', 'follow_stories', 'stories_by_view', 'banners'));
    }

    private function getArchivedStories()
    {
        $user = Auth::user();
        if (Cache::has('_reading_stories_' . $user->id)) {
            $archived_stories = Cache::get('_reading_stories_' . $user->id);
        } else {
            $user->load([
                'saveLists.stories' => function ($query) {
                    return $query->published()->withCount(['chapters' => function ($q) {
                        $q->published();
                    }, 'metas']);
                },
                'saveLists.stories.metas',
                'saveLists.stories.user',
            ]);

            $archived_stories = $user->saveLists->map(function ($item) {
                return $item->stories;
            })->flatten(1);

            if ($archived_stories->count() > config('app.random_items')) {
                $archived_stories = $archived_stories->random(config('app.random_items'));
            }
            Cache::put('_reading_stories_' . $user->id, $archived_stories, config('app.cache_time'));
        }
        
        return $archived_stories;
    }

    public function search(Request $request)
    {
        $keyword = urldecode($request->query('q'));
        $stories = Story::search($keyword)->published()
            ->paginate(config('app.per_page'))
            ->appends(['q' => urlencode($keyword)]);
        $count = Story::search($keyword)->published()->count();
        if ($request->ajax()) {
            $content = '';
            foreach ($stories as $story) {
                $content .= view('front.items.story', ['story' => $story])->render();
            }
    
            $stories = $stories->toArray();
            unset($stories['data']);
            $stories['content'] = $content;

            return response()->json($stories);
        }

        return view('front.search', compact('stories', 'keyword', 'count'));
    }

    public function getReivew()
    {
        $new_stories = Story::published()->orderBy('updated_at', 'desc')->take(11)->get();
        $reviews = Review::with([
            'user',
            'story' => function ($q) {
                $q->with('metas');
            }
        ])->orderBy('created_at')->paginate(config('app.comment'));

        return view('front.review', compact('reviews', 'new_stories'));
    }
}
