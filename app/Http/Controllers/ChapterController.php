<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ChapterRepository;
use App\Repositories\CommentRepository;
use App\Repositories\StoryRepository;
use App\Repositories\VoteRepository;
use Auth;

class ChapterController extends Controller
{
    protected $chapter;
    protected $comment;
    protected $story;

    public function __construct(ChapterRepository $chapter, CommentRepository $comment, StoryRepository $story, VoteRepository $vote)
    {
        $this->chapter = $chapter;
        $this->comment = $comment;
        $this->story = $story;
        $this->vote = $vote;
    }

    public function index($id)
    {
        $chapter = $this->chapter->published()->withCount(['votes', 'comments'])->findOrFail($id);
        $story = $chapter->story()->published()->with(['user', 'chapters' => function ($q) {
            $q->published();
        }])->first();
        if (Auth::check()) {
            $vote = $this->vote->where('user_id', auth()->user()->id)->where('votable_id', $chapter->id)->first();
        }
        $chapter->comments = $this->comment->getComments($chapter->id, $this->chapter->getModelClass());
        $story->chapters = $story->chapters->map(function ($chapter) use ($story) {
            $chapter->slug = $story->slug . '-' . $chapter->slug;

            return $chapter;
        });

        $session_key = 'reading_' . $id;
        if (!session($session_key) || (session($session_key) && now()->diffInSeconds(session($session_key)) > 30)) {
            session([$session_key => now()]);
            // update chapter views
            $this->chapter->where('id', $id)->increment('views');
            $chapter->views++;
            // update story views
            $this->story->where('id', $story->id)->increment('views');
        }

        $chapter->slug = $story->slug . '-' . $chapter->slug;
        $chapter->share_url = urlencode(route('read_chapter', ['id' => $chapter->id, 'slug' => $chapter->slug]));
        $chapter->share_text = urlencode($chapter->title);

        $next_chapter = $story->chapters->where('id', '>', $chapter->id)->sortBy('id')->first();

        $recommended_stories = $this->story->getRecommendedStories();

        if ($recommended_stories->count() > config('app.chapter_recommended_items')) {
            $recommended_stories = $recommended_stories->random(config('app.chapter_recommended_items'));
        }

        return view('front.chapter', compact('chapter', 'story', 'next_chapter', 'recommended_stories', 'vote'));
    }

    public function comments($id, Request $request)
    {
        if ($request->ajax()) {
            $chapter = $this->chapter->findOrFail($id);
            $comments = $this->comment->getComments($chapter->id, $this->chapter->getModelClass());

            $content = '';
            foreach ($comments as $comment) {
                $content .= view('front.items.comment', ['comment' => $comment])->render();
            }
            $comments = $comments->toArray();
            unset($comments['data']);
            $comments['content'] = $content;

            return response()->json($comments);
        }
    }
}
