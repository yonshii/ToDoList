<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskCreated extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Task $task,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New task created: ' . $this->task->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.task-created',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
