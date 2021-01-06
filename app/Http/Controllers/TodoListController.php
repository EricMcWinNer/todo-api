<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = TodoList::with(['todoItems' => function($query) {
            $query->orderBy('created_at', 'desc');
        }])->get();
        return response(['todo_lists' => $todos], 200);
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
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:todo_lists']
        ]);
        $todoList = TodoList::create([
            'name' => $data['name']
        ]);
        return response(['todo_list' => $todoList->refresh()], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\TodoList $todoList
     * @return \Illuminate\Http\Response
     */
    public function show(TodoList $todoList)
    {
        $todoList->load(['todoItems' => function($query) {
            $query->orderBy('created_at', 'desc');
        }]);
        return response(['todo_list' => $todoList], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\TodoList $todoList
     * @return \Illuminate\Http\Response
     */
    public function edit(TodoList $todoList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\TodoList $todoList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TodoList $todoList)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'unique:todo_lists']
        ]);
        $todoList->name = $data['name'];
        $todoList->save();
        return response(['todo_list' => $todoList->refresh()], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\TodoList $todoList
     * @return \Illuminate\Http\Response
     */
    public function destroy(TodoList $todoList)
    {
        $todoList->todoItems()->delete();
        return response(['message' => 'Todo List deleted successfully'], 200);
    }

    /**
     * Displays only completed todo list items
     *
     * @param \App\Models\TodoList $todoList
     * @return \Illuminate\Http\Response
     */
    public function completed(TodoList $todoList)
    {
        return response(['todoItems' => $todoList->completed], 200);
    }


    /**
     * Deletes only completed todo list items
     *
     * @param \App\Models\TodoList $todoList
     * @return \Illuminate\Http\Response
     */
    public function deleteCompleted(TodoList $todoList)
    {
        $todoList->completed()->delete();
        return response(['message' => "Complete todo list items deleted successfully"], 200);
    }


    /**
     * Displays only incomplete todo list items
     *
     * @param \App\Models\TodoList $todoList
     * @return \Illuminate\Http\Response
     */
    public function incomplete(TodoList $todoList)
    {
        return response(['todoItems' => $todoList->incomplete], 200);
    }


    /**
     * Deletes only incomplete todo list items
     *
     * @param \App\Models\TodoList $todoList
     * @return \Illuminate\Http\Response
     */
    public function deleteIncomplete(TodoList $todoList)
    {
        $todoList->completed()->delete();
        return response(['message' => "Incomplete todo list items deleted successfully"], 200);
    }

}
