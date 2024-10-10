<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $status;

    public function __construct(Reservation $reservation, $status)
    {
        $this->reservation = $reservation;
        $this->status = $status;
    }

    public function build()
{
    $subjectLine = "Your Reservation " . ($this->status == 'accepted' ? 'Confirmation' : 'Cancellation');
    
    return $this->from('alloexpert@gmail.com', 'AlloExpert')
                ->subject($subjectLine)
                ->view('emails.reservation_status_changed')
                ->with([
                    'reservation' => $this->reservation,
                    'status' => $this->status
                ]);
}

}
