<?php namespace Lasso\AdminSendMail\Components;

use Cms\Classes\ComponentBase;
use Lasso\AdminSendMail\Models\Subscriber;
use Lasso\AdminSendMail\Models\Email;

class SendMail extends ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Send Mail',
            'description' => 'Send the email to specified recipients.'
        ];
    }

    public function onRun()
    {
        //create Email
        $email = new Email;
        $email->subject = post('subject');
        $email->content = post('message');
        
        if(strlen(post('abstract'))==0)
            $email->abstract = substr(strip_tags(post('message')), 0, 300);
        else
            $email->abstract = strip_tags(post('abstract'));
        $email->save();

        //set twig vars
        $this->page['email'] = $email;

        //send email
        $subs = Subscriber::whereNotNull('verificationDate')->get();
        $params = ['msg' => $email->content, 'subject' => $email->subject];
        foreach($subs as $subscriber)
        {
            \Mail::queue('lasso.adminsendmail::mail.blank', $params, function($message) use ($subscriber) {
                $message->to($subscriber->email, $subscriber->name);
            });
        }  
    }
}