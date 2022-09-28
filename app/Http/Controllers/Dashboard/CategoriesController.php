<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    public function index()
    {
        return view('dashboard.categories.index', [
            'categories' => Category::all()
        ]);
    }


    public function create()
    {
        return view('dashboard.categories.create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {

        $attributes = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image'
        ]);
        $attributes['image'] = $this->uploadImage($request);
        $attributes['slug'] = \Str::slug($request->name);

        Category::create($attributes);

        #PRG post redirect get
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }


    public function show(Category $category)
    {
        return view('dashboard.categories.show', [
            'category' => $category
        ]);
    }

    public function edit(Category $category)
    {

        return view('dashboard.categories.edit', [
            'category' => $category,
            'categories' => Category::where('id', '<>', $category->id)
                ->where(function ($query) use ($category) {
                    $query->whereNull('parent_id')
                        ->orWhere('parent_id', '<>', $category->id);
                })->get()
        ]);
    }


    public function update(Request $request, Category $category)
    {
        $attributes = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image'
        ]);

        $attributes['image'] = $this->uploadImage($request, $category->image);

        $category->update($attributes);

        return redirect()->route('categories.index');
    }


    public function destroy(Category $category)
    {
        $category->delete();
        $category->image && Storage::disk('public')->delete($category->image); // delete the image from the storage folder

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    protected function uploadImage(Request $request, $old_image = null)
    {
        if (!$request->hasFile('image')) {
            return $old_image;
        }
        if ($old_image) {
            Storage::disk('public')->delete($old_image);
        }

        $image = $request->file('image'); // get the image
        $path = $image->store('uploads', [
            'disk' => 'public'
        ]); // store the image in the storage folder and return the path

        return $path;
    }
}
