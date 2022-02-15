<?php

namespace App\Notifications\invoices;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class AddInvoiceToDatabase extends Notification
{
    use Queueable;

    private $invoice_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    

    public function toDatabase($notifiable){
        return [
            'id' => $this->invoice_id,
            'title' => "تم اضافة فاتورة جديدة بواسطة",
            'user' => Auth::user()->name
        ];
    }
}
