<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::latest()->withCount('book')->get(['id', 'name', 'created_at']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'max:40',
                Rule::unique('categories')
                    ->where(function ($query) {
                        return $query->where('deleted_at', null);
                    }),
            ],
        ]);

        $record = Category::create([
            'created_by' => auth()->user()->id,
            'name' => $request->input('name'),
            'created_at' => now(),
        ]);

        return $record;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return $category
            ->load([
                'createdBy' => function ($query) {
                    $query->select('id', 'name');
                },
                'updatedBy' => function ($query) {
                    $query->select('id', 'name');
                },
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($category)
    {
        return Category::select('id', 'name')->findOrFail($category);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => [
                'required',
                'max:40',
                Rule::unique('categories')
                    ->where(function ($query) {
                        return $query->where('deleted_at', null);
                    })->ignore($category->id),
            ],
        ]);

        $category->update([
            'updated_by' => auth()->user()->id,
            'name' => $request->input('name'),
            'updated_at' => now(),
        ]);

        return $category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if ($category->book()->exists())
        {
            return response()->json(['error' => 'integrity violation'], 500);
        }

        $category->delete();

        return response([], 204);
    }
}
