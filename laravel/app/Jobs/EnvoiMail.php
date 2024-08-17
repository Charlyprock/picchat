<?php

namespace App\Jobs;

use App\Mail\mailTest;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class EnvoiMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     * 
    */

    public $email;
    public $user;
    
    public function __construct($email, $user)
    {
        $this->email = $email;
        $this->user = $user;
    }

    /**
     * Execute the job.     'charly.kouasseu@gmail.com'
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->email)->send(new mailTest($this->user));
    }
}
