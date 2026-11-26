<?php

use App\Mail\TaskCreated;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

uses(RefreshDatabase::class);

test('sends an email notification when a new task is created', function () {
    Mail::fake();

    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    $this->actingAs($user)
        ->post('/tasks', [
            'title' => 'Check mail test',
            'description' => 'Verify Mailable is triggered',
        ])
        ->assertRedirect('/');

    Mail::assertSent(TaskCreated::class, function (TaskCreated $mail) use ($user) {
        return $mail->hasTo($user->email)
            && $mail->task->title === 'Check mail test';
    });
});
