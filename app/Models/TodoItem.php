<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoItem extends Model
{
    use HasFactory;

    protected $fillable = ['text'];

    public function todoList() {
        return $this->belongsTo(TodoList::class);
    }
}
