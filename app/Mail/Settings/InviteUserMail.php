<?php

namespace App\Mail\Settings;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $password;
    public function __construct(User $newUser, string $password)
    {
        $this->user = $newUser;
        $this->password = $password;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invite User',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.settings.invite-user',
            with: [
                'user' => $this->user,
                'password' => $this->password,
            ]
        );
    }


}
