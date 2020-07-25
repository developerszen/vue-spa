<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Book::with([
            'category' => function ($query) {
                return $query->select(['id', 'name']);
            },
        ])->latest()->get(['id', 'category_id', 'title', 'image', 'created_at']);
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
            'authors' => 'required|array',
            'authors.*' => 'exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'title' => [
                'required',
                Rule::unique('books')
                    ->where(function ($query) {
                        return $query->where('deleted_at', null);
                    }),
            ],
            'synopsis' => 'required|string|max:500',
            'image' => 'nullable|image',
        ]);

        $record = Book::create([
            'created_by' => auth()->user()->id,
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'synopsis' => $request->input('synopsis'),
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images/books');

            $record->update(['image' => $path]);
        }

        return $record;
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return $book
            ->load([
                'createdBy' => function ($query) {
                    $query->select('id', 'name');
                },
                'updatedBy' => function ($query) {
                    $query->select('id', 'name');
                },
                'category' => function ($query) {
                    return $query->select(['id', 'name']);
                },
                'authors' => function ($query) {
                    return $query->select(['authors.id', 'name']);
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
        return Book::with([
            'category' => function ($query) {
                return $query->select(['id', 'name']);
            },
            'authors' => function ($query) {
                return $query->select(['authors.id', 'name']);
            },
        ])->select('id', 'category_id', 'title', 'synopsis', 'image')->findOrFail($author);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        $path = null;

        $request->validate([
            'authors' => 'required|array',
            'authors.*' => 'exists:authors,id',
            'category_id' => 'required|exists:categories,id',
            'title' => [
                'required',
                Rule::unique('books')
                    ->where(function ($query) {
                        return $query->where('deleted_at', null);
                    })->ignore($book->id),
            ],
            'synopsis' => 'required|string|max:500',
            'image' => 'nullable|image',
        ]);

        $book->update([
            'updated_by' => auth()->user()->id,
            'category_id' => $request->input('category_id'),
            'title' => $request->input('title'),
            'synopsis' => $request->input('synopsis'),
            'updated_at' => now(),
        ]);

        if ($request->hasFile('image')) {
            Storage::delete($book->image);

            $path = $request->file('image')->store('images/books');
        }

        $book->update(['image' => $path]);

        return $book;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        Storage::delete($book->image);

        $book->delete();

        return response([], 204);
    }
}
