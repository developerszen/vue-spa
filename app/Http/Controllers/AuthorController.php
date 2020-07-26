<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Author::latest()->withCount('books')->get(['id', 'name', 'created_at']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'max:80',
                'alpha_custom',
                Rule::unique('authors')
                    ->where(function ($query) {
                        return $query->where('deleted_at', null);
                    }),
            ],
        ]);

        $record = Author::create([
            'created_by' => auth()->user()->id,
            'name' => $request->input('name'),
            'created_at' => now(),
        ]);

        return $record;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        return $author
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
    public function edit($author)
    {
        return Author::select('id', 'name')->findOrFail($author);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => [
                'required',
                'max:80',
                'alpha_custom',
                Rule::unique('authors')
                    ->where(function ($query) {
                        return $query->where('deleted_at', null);
                    })->ignore($author->id),
            ],
        ]);

        $author->update([
            'updated_by' => auth()->user()->id,
            'name' => $request->input('name'),
            'updated_at' => now(),
        ]);

        return $author;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        if (count($author->books)) {
            return response()->json(['error' => 'integrity violation'], 500);
        }

        $author->delete();

        return response([], 204);
    }
}
