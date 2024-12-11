<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'year',
        'publisher',
        'city',
        'cover',
        'bookshelf_id',
    ];
    public function bookshelf(): BelongsTo
    {
        return $this->belongsTo(Bookshelf::class);
    }

    public static function getDataBooks(){
        $books = Book::with('bookshelf')->get();
        $book_filter = [];

        $no = 1;
        for($i=0; $i < $books->count(); $i++){
            $book_filter[$i]['no'] = $no++;
            $book_filter[$i]['title'] = $books[$i]->title;
            $book_filter[$i]['author'] = $books[$i]->author;
            $book_filter[$i]['year'] = $books[$i]->year;
            $book_filter[$i]['publisher'] = $books[$i]->publisher;
            $book_filter[$i]['bookshelf'] = $books[$i]->bookshelf->name;
        }
        return $book_filter;
    }
}
