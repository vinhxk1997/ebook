<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Meta;
use App\Models\User;
use App\Models\Review;
use App\Models\Banner;
use App\Repositories\StoryRepository;
use App\Repositories\VoteRepository;
use Auth, DB;
use Illuminate\Http\Request;
use App\Http\Requests\SearchRequest;
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
        $top_follow = User::withCount('followers')->orderBy('followers_count', 'desc')->first();
        $top_create = User::withCount(['stories' => function ($q) {
            $q->published();
        }])->orderBy('stories_count', 'desc')->first();
        $top_review = User::withCount('reviewings')->orderBy('reviewings_count', 'desc')->first();
        $banners = Banner::all();
        $stories = Story::published()->with(['chapters' => function ($q) {
            $q->published();
        }])->inRandomOrder()->take(6)->get();
        $recommend_stories = Story::published()->with(['chapters' => function ($q) {
            $q->published();
        }])->where('is_recommended', 1)->inRandomOrder()->take(6)->get();
        $metas = Meta::withCount(['stories' => function($story) {
            $story->published();
        }])->take(14)->get();
        $meta_count = $metas->count();
        $reviews = Review::orderby('created_at')->take(9)->get();
        $new_stories = Story::published()->with(['chapters' => function ($q) {
            $q->published();
        }])->orderBy('updated_at', 'desc')->take(11)->get();
        $completed_stories = Story::published()->with(['chapters' => function ($q) {
            $q->published();
        }])->where('is_complete', 1)->take(11)->get();
        $vote_stories = Story::published()->with(['chapters' => function ($q) {
            $q->published();
        }])->orderBy('votes', 'desc')->take(7)->get();
        $follow_stories = Story::published()->withCount('saveLists')->orderBy('save_lists_count', 'desc')
        ->with(['chapters' => function ($q) {
            $q->published();
        }])->published()->take(7)->get();
        $stories_by_view = Story::published()->with(['chapters' => function ($q) {
            $q->published();
        }])->orderBy('views', 'desc')->take(6)->get();

        return view('front.home', compact('stories', 'metas', 'meta_count', 'reviews', 'recommend_stories', 'new_stories'
        , 'completed_stories', 'vote_stories', 'follow_stories', 'stories_by_view', 'banners', 'top_follow', 'top_create', 'top_review'));
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

    public function search(SearchRequest $request)
    {
        $keyword = urldecode($request->query('q'));
        $stories = Story::search($keyword)->published()
            ->paginate(config('app.per_page'))
            ->appends(['q' => $keyword]);
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
    
    public function filter()
    {
        $metas = Meta::all()->where('type', 'category');
        $tags = Meta::all()->where('type', 'tag');
        $stories = Story::published()->with(['chapters' => function ($q) {
            $q->published();
        }])->paginate(config('app.comment'));

        return view('front.filter', compact('metas', 'tags', 'stories'));
    }

    public function filterResult(Request $request)
    {
        $st = ['1' => '1', '2' => '0'];
        $ra = ['1' => 'is_recommended', '2' => 'views', '3' => 'votes', '4' => 'saveLists'];
        $complete = null; $tag = null; $cate = null; $rank = null;
        if ($request->input('status') != 0) {
            $complete = $st[$request->input('status')];
        }
        if ($request->input('rank')) {
            $rank = $request->input('rank');
        }
        if ($request->input('tag')) {
            $tag = $request->input('tag');
        }
        if ($request->input('cate')) {
            $cate = $request->input('cate');
        }
        $query = new Story;
        if ($tag != null) {
            $query = Story::whereHas('tags', function($q) use($tag){
                $q->where('id', $tag);
            });
        }
       
        if ($cate != null) {
            $query = $query->whereHas('category', function($q) use($cate){
                $q->where('id', $cate);
            });
        }

        if ($complete != null) {
            $query = $query->where('is_complete', $complete);
        }

        if ($rank == '1') {
            $query = $query->where('is_recommended', 1);
        }

        if ($rank == '2') {
            $query = $query->orderBy('views', 'desc');
        }

        if ($rank == '3') {
            $query = $query->orderBy('votes', 'desc');
        }

        if ($rank == '4') {
            $query = $query->withCount('saveLists')->orderBy('save_lists_count', 'desc');
        }

        $stories = $query->published()->with(['chapters' => function ($q) {
            $q->published();
        }])->get();
        $content = '';
        if ($request->ajax()) {
            $content .= view('front.items.filter_stories', ['stories' => $stories])->render();
        }

        return response()->json($content);
    }
}
