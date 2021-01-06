<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function todoItems() {
        return $this->hasMany(TodoItem::class);
    }

    public function completed() {
        return $this->todoItems()->where('is_completed', '=', true);
    }

    public function incomplete() {
        return $this->todoItems()->where('is_completed', '=', false);
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($todoList) {
            $todoList->todoItems()->delete();
        });
    }
}
