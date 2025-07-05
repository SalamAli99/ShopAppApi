<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
class TodoController extends Controller
{
 public function CreateTodo(Request $request)
{
    // Validate the incoming data
    $request->validate([
        'user_id' => 'required',
        'title' => 'required',
        'is_completed' => 'required|boolean',  // Ensure that the availability is a boolean (true or false)
    ]);

    // Create the product in the database
    $todo = Todo::create([
        'user_id' => $request->user_id,
        'title' => $request->title,
        'is_completed' => $request->is_completed,
    ]);

    // Check if the product was created successfully
    if ($todo) {
        // Return the product and success message as JSON
        return response()->json([
            'message' => 'todo created successfully!',
            'todo' => $todo,
            'status' => 200,
        ]);
    } else {
        // Return an error message if product creation failed
        return response()->json([
            'message' => 'Failed to create todo',
            'todo' => null,
            'status' => 500,
        ], 500); // Return 500 Internal Server Error status code
    }
}


public function getAllTodos()
{
    $todos = Todo::all();

    if ($todos->isNotEmpty()) {
        return response()->json([
            'message' => 'Success',
            'data' => $todos->toArray() // ✅ ensures it's a pure array
        ], 200);
    } else {
        return response()->json([
            'message' => 'No todos in database',
            'data' => [] // ✅ still return an array for consistency
        ], 200);
    }
}

public function updateTodo(Request $request, $id)
{
    // 1️⃣  Validate only what might change
    $data = $request->validate([
        'title'        => ['sometimes', 'string', 'max:255'],
        'is_completed' => ['sometimes', 'boolean'],
    ]);

    // 2️⃣  Find the todo that belongs to the authenticated user
    //      (or just Todo::find($id) if you skip ownership checks)
    $todo = $request->user()->todos()->find($id);

    if (! $todo) {
        return response()->json(['message' => 'Todo not found'], 404);
    }

    // 3️⃣  Update only the supplied keys
    $todo->fill($data)->save();

    return response()->json([
        'message' => 'success',
        'todo'    => $todo,
    ], 200);
}



function deleteTodo(string $id){

   $todo = Todo::find($id);
   if($todo){
     $todo->delete();
       return response()->json([
           'message'=>'success',
           'todos'=> 'todo has been deleted successfully!',
           'status'=>200
      ]);
     }
   else{
     return response()->json([
           'message'=> 'error',
           'todos'=>'todo does not exist!',
           'status'=>404
     ]);
     }
  }


}