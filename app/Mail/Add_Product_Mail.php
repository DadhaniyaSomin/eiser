<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Add_Product_Mail extends Mailable
{
    use Queueable, SerializesModels;
     public $products;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($products)
    {
        //
        $this->products = $products;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('somin.elsner@example.com', 'Example')->view('Mail.add_product');
    }
}
