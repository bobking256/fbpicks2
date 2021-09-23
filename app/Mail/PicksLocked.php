<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PicksLocked extends Mailable
{
    use Queueable, SerializesModels;
    protected $weekno, $x ,$y, $pick531, $pickall;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($weekno, $pick531, $pickall, $x, $y)
    {
        //
        $this->weekno = $weekno;
        $this->pick531 = $pick531;
        $this->pickall = $pickall;
        $this->x = $x;
        $this->y = $y;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('pjwashi@comcast.net', 'Paulie Football Picks')
        ->view('emails.pickslocked',['weekno'=>$this->weekno, 'pick531'=>$this->pick531, 'pickall' => $this->pickall, 'x'=>$this->x, 'y'=>$this->y]);
    }
}
