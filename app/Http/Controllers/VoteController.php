<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\VoteRepository;
use App\Repositories\ChapterRepository;
use App\Repositories\StoryRepository;
use Auth;

class VoteController extends Controller
{
    protected $vote;

    public function __construct(VoteRepository $vote, ChapterRepository $chapter, StoryRepository $story)
    {
        $this->vote = $vote;
        $this->chapter = $chapter;
        $this->story = $chapter;
    }

    public function voted($id, Request  $request)
    {
        if ($request->ajax()) {
            if (Auth::check()) {
                $chapter = $this->chapter->findOrFail($id);
                $this->vote->create([
                    'user_id' => auth()->user()->id,
                    'votable_type' => $this->chapter->getModelClass(),
                    'votable_id' => $chapter->id,
                ]);

                return response()->json('success');
            }
            return response()->json('fail');
        }
    }

    public function unVoted($id, Request  $request)
    {
        if ($request->ajax()) {
            if (Auth::check()) {
                $chapter = $this->chapter->findOrFail($id);
                \DB::table('votes')->where('user_id', auth()->user()->id)->where('votable_id', $chapter->id)->delete();

                return response()->json('success');
            }

            return response()->json('fail');
        }
    }
}
