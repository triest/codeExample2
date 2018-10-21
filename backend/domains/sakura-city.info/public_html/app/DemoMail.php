<?php
namespace App;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;

class DemoMail extends Model
{

    public function __construct()
    {
//
    }
    public function build()
    {
        return $this->view('mail.confurmuser');
    }
}
