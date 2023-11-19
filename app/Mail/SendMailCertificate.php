<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailCertificate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $userData;
    protected $certificate;
    protected $baseFile;

    public function __construct($userData, $certificate)
    {
        $this->userData = $userData;
        $this->certificate = $certificate;
        $this->baseFile = basename($this->certificate);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.user.salutation',['user' => $this->userData])
            ->subject('Certificado de Conclusão')
            ->attach($this->certificate, [
                'as' => $this->baseFile,
                'mime' => 'application/pdf',
            ]);
    }
}
