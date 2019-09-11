<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index() {
        return view('todo');
    }

    public function get(Request $request){
        // $user = Auth::id();
        // return $user;
        // return response()->json(Auth::user());
        // return Auth::user();
        return response()->json(Auth::user()->todos()->orderBy('updated_at', 'desc')->get());
        // return Todo::where('user_id', 1)->get();
    }

    public function post(Request $request){
        // $data = $request->all();
        // return $request->input('todo');
        $todo = new Todo();
        $todo->todo = $request->input('todo');
        $todo->user_id = Auth::id();
        $todo->save();
        return response("OK", 200);
    }

    public function delete($id){
        Todo::find($id)->delete();
        return response("OK", 200);;
    }

    public function update(Request $request, $id){
        $todo = Todo::find($id);
        $todo->todo = $request->input('todo');
        $todo->save();
        return response("OK", 200);
    }
}
