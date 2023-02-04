<?php

namespace App\Mail;

use App\Models\PasswordReset;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailResetPassword extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $passwordReset;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PasswordReset $passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $resetPasswordUrl = env('FE_URL') . 'reset-password?token=' . $this->passwordReset->token;
        return $this->to($this->passwordReset->email)
            ->subject('[MonstarGate] Đặt lại mật khẩu')
            ->view('emails.forgot_password_mail')
            ->with(['resetPasswordUrl' => $resetPasswordUrl]);
    }
}
