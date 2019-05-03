<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BannerRepository;
use App\Http\Requests\BannerRequest;

class BannerController extends Controller
{
    protected $banner;

    public function __construct(BannerRepository $banner)
    {
        $this->banner = $banner;
    }

    public function index()
    {
        $banners = $this->banner->all();

        return view('backend.banners', compact('banners'));
    }

    public function show($id)
    {
        $banner = $this->banner->findOrFail($id);

        return json_encode($banner);
    }

    public function update($id, Request $request)
    {
        $banner = $this->banner->findOrFail($id);
        $name = $request->get('name');
        $url = $request->get('url');
        if ($request->hasFile('avatar_file') != null) {
            $file = $request->file('avatar_file');
            $file_name = $file->getClientOriginalName();
            $file->move('upload/banners', $file_name);
            $banner->update([
                'name' => $name,
                'url' => $url,
                'image' => $file_name,
            ]);
        } else {
            $banner->update([
                'name' => $name,
                'url' => $url,
            ]); 
        }

        return redirect()->back()->with('status', __('tran.banner_update_status'));
    }
}
