<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Story;
use App\Repositories\StoryRepository;
use App\Repositories\MetaRepository;
use Carbon\Carbon;

class StoryController extends Controller
{
    protected $story;
    protected $meta;

    public function __construct(StoryRepository $story, MetaRepository $meta)
    {
        $this->story = $story;
        $this->meta = $meta;
    }

    public function index()
    {
        $stories = $this->story->with('user')->get();

        return view('backend.stories.index', compact('stories'));
    }

    public function show($id)
    {
        $story = $this->story->with(['user', 'chapters'])->findOrFail($id);
        $current_cate = $story->category[0];
        $cates = $this->meta->all();
        $tags = null;
        if ($story->tags != null) {
            $tags = $story->tags;
        }

        $createAt = Carbon::parse($story['created_at']);
        $updateAt = Carbon::parse($story['updated_at']);

        return view('backend.stories.information', compact('story', 'createAt', 'updateAt', 'cates', 'current_cate', 'tags'));
    }

    public function update($id, Request $request)
    {
        $story = $this->story->findOrFail($id);
        $mature = ($request->get('mature') != true) ? 0 : 1;
        $status = ($request->get('status') != true) ? 0 : 1;
        $recommended = ($request->get('recommended') != true) ? 0 : 1;
        $cate = $request->input('cate');

        $story->update([
            'is_mature' => $mature,
            'status' => $status,
            'is_recommended' => $recommended,
        ]);

        $story->metas()->sync($cate);

        return redirect()->back()->with('status', __('tran.story_update_status'));
    }

    public function destroy($id)
    {
        $user = $this->story->findOrFail($id);
        $user->delete();
        
        return redirect('/admin/stories')->with('status', __('tran.story_delete_status'));
    }
}
