<?php

use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/tasks', function () {
    return view('index', [
        'tasks' => Task::latest()->get()
    ]); // get all tasks and pass them to the
})->name('tasks.index'); // name the route tasks.index

Route::get('/tasks/{id}', function ($id) {
    return view('show', [
        'task' => Task::findOrFail($id)
    ]); // find the task by id
})->name('tasks.show'); // name the route tasks.show


Route::post('/tasks', function (Request $request) {
    $data = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'long_description' => 'required'
    ]); // validate the request

    $task = new Task; // new instance of Task model
    $task->title = $data['title']; // set the title attribute
    $task->description = $data['description'];
    $task->long_description = $data['long_description'];
    $task->save(); // save the task to the database

    return redirect()->route('tasks.show', ['id' => $task->id]);
})->name('tasks.store'); // name the route tasks.store
