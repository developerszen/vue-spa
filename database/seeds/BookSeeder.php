<?php

use App\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Book::class, 30)->make()->each(function ($book) {
            $book->save();

            $book->authors()->attach([1, 2]);
        });
    }
}
