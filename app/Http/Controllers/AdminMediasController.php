<?php

namespace App\Http\Controllers;

use App\Photos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminMediasController extends Controller
{
    public function index()
    {
        $photos = Photos::all();

        return view('admin.media.index', compact('photos'));
    }

    public function create()
    {
        return view('admin.media.create');
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        $name = time() . $file->getClientOriginalName();
        $file->move('images', $name);
        Photos::create(['file' => $name]);
    }

    public function destroy($id)
    {
        $photo = Photos::findOrFail($id);
        @unlink(public_path(). $photo->file);
        Session::flash('deleted_image', "The image has been deleted!");
        $photo->delete();
        return redirect('/admin/media');
    }
}
