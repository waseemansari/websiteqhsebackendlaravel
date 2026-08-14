<?php

namespace App\Listeners;

use App\Events\CourseRegisterEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\{CourseRegistrationMail,CourseRegistrationMailToAdmin};
use Illuminate\Support\Facades\Mail;

class SendCourseRegistrationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CourseRegisterEvent $event): void
    {
        $course = $event->course;
        
        $branch = config('custom.branches.' . $course->branch_id);
        $course['branchDetails'] = $branch;
        Mail::to($course->email)
            ->send(new CourseRegistrationMail($course));
        

          $adminEmail = config('custom.branch_emails.' . $course->branch_id)
        ?? config('custom.company_email');
         $course['adminEmail'] = $adminEmail;
        
        
       Mail::to($adminEmail)->send(new CourseRegistrationMailToAdmin($course));
        
    }
}
