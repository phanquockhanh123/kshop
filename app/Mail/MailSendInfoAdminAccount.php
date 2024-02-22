<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailSendInfoAdminAccount extends Mailable
{
    use Queueable;

    use SerializesModels;

    protected $emailAddress;

    /**
     * Create a new message instance.
     *
     * @param string $emailAddress
     * @return void
     */
    public function __construct($emailAddress)
    {
        $this->emailAddress = $emailAddress;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->emailAddress)
            ->subject('[KSHOP] Thông tin tài khoản')
            ->view('emails.info_admin_account_mail')
            ->with(['emailAddress' => $this->emailAddress]);
    }
}
