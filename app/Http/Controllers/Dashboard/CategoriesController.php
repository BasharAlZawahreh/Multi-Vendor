<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')
            ->withCount([
                'products as products_count' => function ($query) {
                    $query->where('status', 'active');
                }
            ])
            ->filter(request()->query())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.categories.index', [
            'categories' => $categories
        ]);
    }


    public function create()
    {
        return view('dashboard.categories.create', [
            'categories' => Category::all()
        ]);
    }

    public function store(CategoryRequest $request)
    {
        $attributes = $request->validated();
        $attributes['image'] = $this->uploadImage($request);
        $attributes['slug'] = \Str::slug($request->name);

        Category::create($attributes);

        #PRG post redirect get
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }


    public function show(Category $category)
    {
        return view('dashboard.categories.show', [
            'category' => $category,
            'products' => $category->products()->with('store')->latest()->paginate(10)
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


    public function update(CategoryRequest $request, Category $category)
    {
        $attributes = $request->validated();

        $attributes['image'] = $this->uploadImage($request, $category->image);

        $category->update($attributes);

        return redirect()->route('categories.index');
    }


    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    protected function uploadImage(Request $request, $old_image = null)
    {
        if (!$request->hasFile('image')) {
            return $old_image;
        }


        $image = $request->file('image'); // get the image
        $path = $image->store('uploads', [
            'disk' => 'public'
        ]); // store the image in the storage folder and return the path

        return $path;
    }

    public function trsashed()
    {
        $categories = Category::onlyTrashed()->paginate(10);

        return view('dashboard.categories.trashed', [
            'categories' => $categories
        ]);
    }

    public function restoreTrashed($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->back()->with('success', 'Category restored successfully.');
    }

    public function hardDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $old_image = $category->image;

        if ($old_image) {
            Storage::disk('public')->delete($old_image);
        }
        return redirect()->back()->with('success', 'Category deleted successfully.');
    }
}
