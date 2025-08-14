<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'All');
        session(['mode' => 'add']);
        $tasks = Task::when($tab !== 'All', function ($query) use ($tab) {
            return $query->where('status', $tab);
        })->get();

        return view('index', compact('tasks', 'tab'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        session(['mode' => 'add']);
        $request->validate([
            'name' => 'required|string',
        ]);
        Task::create([
            'name' => $request->name,
        ]);
        return redirect()->route('task.index')->with('success', 'Tạo thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::find($id);
        session(['mode' => 'edit']);
        return view('index', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::find($id);
        $request->validate([
            'name' => 'required|string',
        ]);
        $task->name = $request->name;
        session(['mode' => 'add']);
        $task->save();
        return redirect()->route('task.index')->with('success', 'Update thành công');
    }

    public function updatestatus(Request $request, string $id)
    {
        $task = Task::find($id);
        if ($request->status == 'checked') {
            $task->status = 'completed';
            $task->save();
        } else {
            $task->status = 'pending';
            $task->save();
        }
        return back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        $task->delete();
        return back();
    }
}
