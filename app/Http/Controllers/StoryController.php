<?php

namespace App\Http\Controllers;

use App\Repositories\MetaRepository;
use App\Repositories\StoryRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    protected $story;
    protected $meta;
    protected $user;

    public function __construct(StoryRepository $story, MetaRepository $meta, UserRepository $user)
    {
        $this->story = $story;
        $this->meta = $meta;
        $this->user = $user;
    }

    public function story($id, Request $request)
    {
        if ($request->ajax()) {
            return $this->ajaxStoryInfo($id);
        } else {
            return $this->getStoryInfo($id);
        }
    }

    private function ajaxStoryInfo($id)
    {
        $story = $this->story->published()->with([
            'metas',
            'user',
            'chapters',
        ])->withCount(['metas', 'chapters' => function ($q) {
            $q->published();
        }])->findOrFail($id);

        return view('front.story_preview', compact('story'));
    }

    private function getStoryInfo($id)
    {
        $story = $this->story->published()->with([
            'metas',
            'chapters' => function ($query) {
                return $query->published()->withCount('votes')->orderBy('id', 'asc');
            },
            'user',
        ])->withCount(['metas', 'chapters' => function ($q) {
            $q->published();
        }])->findOrFail($id);
        

        $story->chapters = $story->chapters->map(function ($chapter) use ($story) {
            $chapter->slug = $story->slug . '-' . $chapter->slug;

            return $chapter;
        });

        $story->share_text = urlencode($story->title);
        $story->share_url = urlencode(route('story', ['id' => $story->id, 'slug' => $story->slug]));
        $first_chapter = $story->chapters->first();
        $recent_comments = $this->story->getStoryRecentComments($story);

        $recent_comments = $recent_comments->map(function ($comment) use ($story) {
            $comment->chapter = $story->chapters->find($comment->commentable_id);

            return $comment;
        });

        $recommended_stories = $this->story->getRecommendedStories();

        return view('front.story', compact('story', 'first_chapter', 'recent_comments', 'recommended_stories'));
    }

    private function getStoryHome($id)
    {
        $categories = $this->meta->where('type', 'category')->get();
        $story = $this->story->published()->with([
            'metas',
            'chapters' => function ($query) {
                return $query->published()->withCount('votes')->orderBy('id', 'asc');
            },
            'user',
        ])->withCount(['metas', 'chapters' => function ($q) {
            $q->published();
        }])->findOrFail($id);
        

        $story->chapters = $story->chapters->map(function ($chapter) use ($story) {
            $chapter->slug = $story->slug . '-' . $chapter->slug;

            return $chapter;
        });

        $story->share_text = urlencode($story->title);
        $story->share_url = urlencode(route('story', ['id' => $story->id, 'slug' => $story->slug]));
        $first_chapter = $story->chapters->first();
        $recent_comments = $this->story->getStoryRecentComments($story);

        $recent_comments = $recent_comments->map(function ($comment) use ($story) {
            $comment->chapter = $story->chapters->find($comment->commentable_id);

            return $comment;
        });

        $recommended_stories = $this->story->getRecommendedStories();

        return view('front.story', compact('story', 'first_chapter', 'recent_comments', 'recommended_stories'));
    }

    public function getStory($id)
    {
        $story = $this->story->findOrFail($id);

        return json_encode($story);
    }
}
