<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $csvData;

    public function __construct($csvData)
    {
        $this->csvData = $csvData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // dd($this->csvData);
        return $this->view('emails.user.listUser')
            ->subject('Lista de Usuarios ativos')
            ->attachData($this->csvData,'user.csv');
    }
}
