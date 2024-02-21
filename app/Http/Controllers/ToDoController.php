<?php

namespace App\Http\Controllers;

use App\Models\ToDo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ToDoController extends Controller
{
    public function index()
    {
        $todos = ToDo::all();
        return response()->json(['todos' => $todos ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);
        $todo = ToDo::create([
            'title' => $request->title,
            'description' => $request-> description,
        ]);

        return response()->json(['message' => 'TODO item created successfully!' ]);
    }

    public function show($id)
    {
        $todo = ToDo::findOrFail($id);
        return response()->json($todo);
    }

    public function update( $id, Request $request)
    {
         $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
         ]);
        $todo = ToDo::find($id);
        if (!$todo) 
            return response()->json(['error' => 'No data found' ]);
        // $todo->update($validatedData);
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->save();

        return response()->json(['message' => 'succesfylly updated' ]);
    }
    public function destroy($id)
    {
        $todo = ToDo::findOrFail($id);
        $todo->delete();
        return response()->json(['message' => 'TODO item deleted successfully!']);
    }
} 
