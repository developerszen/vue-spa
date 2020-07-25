<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    protected $hidden = ['deleted_at'];

    function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }

    function updatedBy() {
        return $this->belongsTo(User::class, 'updated_by');
    }

    function category() {
        return $this->belongsTo(Category::class);
    }

    function authors() {
        return $this->belongsToMany(Author::class);
    }
}
