<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = ['deleted_at', 'pivot'];

    function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    function books() {
        return $this->belongsToMany(Book::class);
    }
}
