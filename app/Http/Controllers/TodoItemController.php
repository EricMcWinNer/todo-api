<?php

namespace App\Http\Controllers;

use App\Models\TodoItem;
use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoItemController extends Controller
{

    /**
     * Display a listing of the todo list items in a todo list.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TodoList $todoList)
    {
        return response(['todoItems' => $todoList->todoItems], 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TodoList $todoList)
    {
        $data = $request->validate([
            'text' => ['string', 'required']
        ]);
        $todoItem = new TodoItem();
        $todoItem->text = $data['text'];
        $todoList->todoItems()->save($todoItem);
        $todoList->load(['todoItems' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }]);
        return response([
            'message' => 'Todo Item created successfully',
            'todo_list' => $todoList
        ], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\TodoItem $todoItem
     * @return \Illuminate\Http\Response
     */
    public function show(TodoItem $todoItem)
    {
        return response(['todo_item' => $todoItem], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\TodoItem $todoItem
     * @return \Illuminate\Http\Response
     */
    public function edit(TodoItem $todoItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TodoItem $todoItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodoItem $todoItem)
    {
        $data = $request->validate([
            'text' => ['string', 'required'],
        ]);
        $todoItem->text = $data['text'];
        $todoItem->save();
        return response(['message' => 'Todo item updated successfully', 'todo_item' => $todoItem], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\TodoItem $todoItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoItem $todoItem)
    {
        $todoItem->delete();
        return response(['message' => 'Todo item deleted successfully'], 200);
    }

    /**
     * Toggles the completed state of the todo_item
     *
     * @param \App\Models\TodoItem $todoItem
     * @return \Illuminate\Http\Response
     */
    public function toggle(TodoItem $todoItem)
    {
        $todoItem->is_completed = !$todoItem->is_completed;
        $todoItem->save();
        return response([
            'message' => 'Todo Item toggled successfully',
            'todo_item' => $todoItem->refresh()
        ]);
    }
}
