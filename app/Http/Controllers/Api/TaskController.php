<?php

namespace App\Http\Controllers\Api;

use App\Events\TaskAssigned;
use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Attachment;
use App\Models\Task;
use App\Models\User;
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
     * Assign a task to a user.
     */
    public function assignTaskToUser(Task $task, User $user)
    {
        try {
            $task->assignee_id = $user->id;
            $task->save();

            event(new TaskAssigned($task, $user));
            return response()->json([
                'status' => 'success',
                'message' => 'Task assigned successfully.',
                'task' => new TaskResource($task),
            ], 200);
        } catch (Exception $e) {
            //throw $e;
            return response()->json([
                'status' => 'error',
                'message' => 'Task assigned failed.',
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
            'file' => 'required|file|max:10240', // 10MB max size
        ]);

        try {
            $file = $request->file('file');
            $path = Storage::putFile('public/attachments/', $file);
            $attachment = Attachment::create([
                'task_id' => $task->id,
                'filename' => $file->getClientOriginalName(),
                'path' => $path,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'File attached successfully.',
                'attachment' => $attachment,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'File attachment failed.',
                'errors' => $e->getMessage(),
            ], 500);
        }
    }
}
