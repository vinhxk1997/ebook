<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReportFormRequest;
use App\Repositories\ChapterRepository;
use App\Repositories\CommentRepository;
use App\Repositories\StoryRepository;
use App\Repositories\VoteRepository;
use App\Repositories\ReportRepository;
use Auth;

class ChapterController extends Controller
{
    protected $chapter;
    protected $comment;
    protected $story;
    protected $report;

    public function __construct(ChapterRepository $chapter, CommentRepository $comment, StoryRepository $story, VoteRepository $vote, ReportRepository $report)
    {
        $this->chapter = $chapter;
        $this->comment = $comment;
        $this->story = $story;
        $this->vote = $vote;
        $this->report = $report;
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

        views($chapter)->delayInSession(now()->addHours(1))->record();

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
    public function report($id, ReportFormRequest $request)
    {
        $story = $this->story->find($id);
        $content = strip_tags($request->input('content'));
        if (auth()->user() && $story != null) {
            $this->report->create([
                'user_id' => auth()->user()->id,
                'story_id' => $story->id,
                'content' => $content
            ]);
        }

        return redirect()->back()->with('success', "report thanh cong cho admin xu ly");
    }
}
