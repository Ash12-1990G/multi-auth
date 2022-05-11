<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\WelcomeMail;
use App\Models\User;
use App\Notifications\FailedJobsNotice;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

use Throwable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $mailData;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $tries = 3;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }
    
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
       
            Mail::to($this->mailData['email'])->send(new WelcomeMail($this->mailData));
        
    }

    public function failed(Throwable $exception)
    {
        //dd($exception);
        
       
            $users = User::permission('failed-job-notification')->get();
            $details =[
                'name' => $this->mailData['name'],
                'email' => $this->mailData['email'],
            ];
        try{
            Notification::send($users, new FailedJobsNotice($details));
        }
        catch(Throwable $e){
            
            report($e);
 
            return false;
        }
        
        
        
    }
}
