<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskPostRequest;
use App\Product;
use App\Task;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
//use mysql_xdevapi\Exception;
//use Illuminate\Support\Facades\Validator;
//use \Debugbar;
use function PHPUnit\Framework\isNull;


class TaskController extends Controller
{
    public function index()
    {
        $string_with_256_symbols = Str::random(256);
//        $faker = new Faker;
//        $string_with_256_symbols = $faker->text(110);
//        Debugbar::info($string_with_256_symbols);    // Debugbar usage example
//        Debugbar::error('Error!');
//        Debugbar::warning('Watch out…');
//        Debugbar::addMessage('Another message', 'mylabel');

//        $tasks = Task::with('ratings', 'user')->get();
        $tasks = Task::with('ratings', 'user')->orderBy("created_at", "asc")->paginate(10);
//        $tasks = Task::with('ratings')->where('user_id', Auth::id())->paginate(5);
//        $tasks = Task::where('user_id', Auth::id())->paginate(5);
        return view('tasks.tasks', compact('tasks', 'string_with_256_symbols'));
    }

    public function task_info($task_ID)
    {
        $task = Task::find($task_ID);
        return view('tasks.task_info', ['task' => $task]);
    }

    public function post(TaskPostRequest $request)
    {
        $this->authorize('create_task');

        $user = Auth::user();
        $validated = $request->validated();
        $task = Task::create([
            'name' => $validated['name'],
            'details' => $validated['details'],
            'status' => $status = isset($validated['status']) ? $validated['status'] : null,
            'priority' => $validated['priority'],
            'start_time' => $validated['start_time'],
            'finish_time' => $validated['finish_time'],
            'time_spent' => $validated['time_spent'],
            'user_id' => $user->id,
        ]);
        if (isset($validated['rating'])) {
            $task->rate($validated['rating'], $user);
        }
        return redirect()->route('user.tasks_main_page');
    }
    public function rate_a_task(Request $request, $task_ID)
    {
        if (isset($request->rating)) {
            $validatedData = $request->validate([
                'rating' => 'nullable | integer | between:1,5',
            ]);

            $task = Task::find($task_ID);
            $task->rate($validatedData['rating'], Auth::user());
        }
        else {
            $request->session()->flash('error_rate_a_task', 'Выберите оценку!');
        }
        return redirect()->back();
    }

    public function task_form(Task $task=null)
    {
        if (isset($task)) {
            $this->authorize('update_task', $task);
            $found_task = $task;
            return view('tasks.task_form_page', ['found_task' => $found_task]);
        }
        else {
            $this->authorize('create_task');
            $found_task = null;
            return view('tasks.task_form_page', ['found_task' => $found_task]);
        }

    }

    public function update(Task $task, TaskPostRequest $request)
    {
        $this->authorize('update_task', $task);
        $user = Auth::user();
        $validated = $request->validated();
        $task->update([
            'name' => $validated['name'],
            'details' => $validated['details'],
            'status' => $status = isset($validated['status']) ? 1 : 0,
            'priority' => $validated['priority'],
            'start_time' => $validated['start_time'],
            'finish_time' => $validated['finish_time'],
            'time_spent' => $validated['time_spent'],
        ]);

        if (isset($validated['rating'])) {
            if (isset($validated['comment'])) {
                if (isNull($task->ratings->first()->comment)) {
                    $task->rate($validated['rating'], $user, $validated['comment']);
                }
                else {
                    $task->rate($validated['rating'], $user);
                }
            }
            else {
                $task->rate($validated['rating'], $user);
            }
        }

        return redirect()->route('user.tasks_main_page');
    }

    public function delete(Task $task)
    {
        $this->authorize('delete_task', $task);
        $task->delete();
        return redirect()->route("tasks.tasks");
    }

}
