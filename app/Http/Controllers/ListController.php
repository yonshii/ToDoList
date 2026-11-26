<?php

namespace App\Http\Controllers;

use App\Mail\TaskCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ListController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'due_date' => ['nullable', 'date'],
            'is_important' => ['nullable', 'boolean'],
        ]);

        $task = $request->user()->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'is_completed' => false,
            'is_important' => $request->boolean('is_important'),
        ]);

        if ($request->user()->email) {
            Mail::to($request->user()->email)->send(new TaskCreated($task));
        }

        return redirect('/');
    }
}
