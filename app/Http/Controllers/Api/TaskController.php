<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Attachment;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return TaskResource::collection(Task::paginate(10));
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
    public function store(TaskRequest $request)
    {
        //
        try {
            $task = Task::create($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'Task created successfully.',
                'task' => new TaskResource($task),
            ], 201);
        } catch (Exception $e) {
            //throw $e;
            return response()->json([
                'status' => 'error',
                'message' => 'Task creation failed.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
        return new TaskResource($task);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        //
        try {
            if (auth()->user()->id !== $task->user_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to update this task.',
                ], 403);
            }
            $task->update($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'Task updated successfully.',
                'task' => new TaskResource($task),
            ], 200);
        } catch (Exception $e) {
            //throw $e;
            return response()->json([
                'status' => 'error',
                'message' => 'Task update failed.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
        try {
            if (auth()->user()->id !== $task->user_id) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'You are not authorized to delete this task.',
                ], 403);
            }
            $task->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Task deleted successfully.',
            ], 200);
        } catch (Exception $e) {
            //throw $e;
            return response()->json([
                'status' => 'error',
                'message' => 'Task deletion failed.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }

    //
    public function attachFile(Request $request, Task $task)
    {
        //
        $request->validate([
            'attachments' => 'required|array',
            'attachments.*' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,ppt,pptx',
        ]);
        try {
            $files = $request->file('attachments');
            foreach ($files as $file) {
                $filename = $file->getClientOriginalName();
                $path = Storage::putFile('attachments', $file);

                Attachment::create([
                    'filename' => $filename,
                    'path' => $path,
                    'task_id' => $task->id,
                ]);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'File attached successfully.',
            ], 201);
        } catch (Exception $e) {
            //throw $th;
            return response()->json([
                'status' => 'error',
                'message' => 'File attachment failed.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }
}
