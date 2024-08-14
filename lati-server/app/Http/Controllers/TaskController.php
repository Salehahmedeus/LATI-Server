<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['max:1024'],
            'before_date' => ['date'],
            'priority' => ['required', 'integer', 'min:1', 'max:5'],
            'status' => ['string', 'in:Not-Started,In-Progress,Completed,Cancelled']
        ]);

        auth()->user()
            ->servers()->firstOrFail()
            ->tasks()->create($inputs);

        return response()->json([
            'data' => 'task created successfully'
        ]);
    }


    public function index(){
        $tasks=auth()->user()->servers()->firstOrFail()->tasks()->get();

        return response()->json([
            'data' => $tasks
        ]);
    }

    public function show($id){
        $tasks=auth()->user()->servers()->firstOrFail()->tasks()->findOrFail($id);

        return response()->json([
            'data' => $tasks
        ]);
    }


    public function update(Request $request,$id)
    {
        $inputs = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['max:1024'],
            'before_date' => ['date'],
            'priority' => ['required', 'integer', 'min:1', 'max:5'],
            'status' => ['string', 'in:Not-Started,In-Progress,Completed,Cancelled']
        ]);

        $task = auth()->user()
            ->servers()->firstOrFail()
            ->tasks()->findOrFail($id);

        $task->update($inputs);

        return response()->json([
            'data' => 'updated successfully'
        ]);
    }

    public function destroy($id)
    {
        auth()->user()
            ->servers()->firstOrFail()
            ->tasks()->delete($id);

        return response()->json([
            'data' => 'task deleted successfully'
        ]);
    }







}
