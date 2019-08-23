<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';
    protected $primaryKey = 'bookid';

    protected $fillable = [
        'isbn', 'author', 'status',
    ];
    
}
