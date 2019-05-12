<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;
use App\Repositories\MetaRepository;
use App\Models\Story;
class CategoryController extends Controller
{
    protected $cateRepo;

    public function __construct(MetaRepository $meta)
    {
        $this->cateRepo = $meta;
    }

    public function index()
    {
        $cates = $this->cateRepo->all();
        $cate = $this->cateRepo->makeModel();
        return view('backend.categories', compact('cates', 'cate'));
    }

    public function edit($id)
    {
        $cate = $this->cateRepo->findOrFail($id);
        $cates = $this->cateRepo->all();
       
        return view('backend.categories', compact('cate', 'cates'));
    }

    public function store(CategoryFormRequest $request)
    {
        $meta = $this->cateRepo;
        $meta->create([
            'name' => $request->get('name'),
            'slug' => $request->get('name'),
            'type' => ($request->get('meta_type') != 'category') ? 'category' : 'tag',
        ]);
        
        return redirect('/admin/categories')->with('status', __('tran.meta_create_status'));
    }

    public function create()
    {
        return view('backend.categories');
    }

    public function update($id, CategoryFormRequest $request)
    {
        $meta = $this->cateRepo->findOrFail($id);
        $meta->update([
            'name' => $request->get('name'),
            'slug' => $request->get('name'),
            'type' => $request->get('meta_type'),
        ]);

        return redirect('/admin/categories')->with('status', __('tran.meta_update_status'));
    }

    public function destroy($id)
    {
        $status = __('tran.meta_delete_error');
        $meta = $this->cateRepo->findOrFail($id);
        $story = $meta->stories()->count();
        if ($story == 0) {
            $meta->delete();
            $status = __('tran.meta_delete_status');
            return redirect('/admin/categories')->with('status', $status);
        }
        
        return redirect('/admin/categories')->with('error', $status);
    }
}
