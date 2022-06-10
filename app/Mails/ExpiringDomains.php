<?php

namespace App\Mails;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpiringDomains extends Mailable
{
    use Queueable, SerializesModels;
    private $domains;
    private $days;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($domains, $days = 0)
    {
        $this->domains = $domains;
        $this->days = $days;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.expiring_domains')->with([
            'domains' => $this->domains,
            'days' => $this->days
        ]);
    }
}
