<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::orderBy('id', 'desc')->paginate(10);
        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;

        // Way no 1:
        // Storage::putFile('public', $request->image, env('FILESYSTEM_DISK'));
        $file = $request->file('image');
        $image_name = Str::of($request->name)->slug() . '-' . time() . '.' . $file->extension();

        // Way 02
        // $category->image = Storage::putFileAs('public', $request->image, $image_name, 'public');

        // Way 03
        $category->image = $request->file('image')->storePubliclyAs('public', $image_name);

        // Way 04 move()
        // $path = 'images/categories';
        // $file->move($path, $image_name);
        // $category->image = $path . '/' . $image_name;

        $category->save();

        // Session a success/error
        session()->flash('success', 'Category created successfully.');

        // return back();
        return redirect()->route('categories.create');
    }
}
