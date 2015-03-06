<?php namespace Lasso\Adminsendmail\Controllers;

use Redirect;
use Backend;
use BackendMenu;
use Request;
use Backend\Classes\Controller;
use Lasso\Adminsendmail\Models\Email;
use System\Models\File;
use Lasso\Adminsendmail\ReportWidgets\TopViewed;

/**
 * Emails Back-end Controller
 */
class Emails extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        $this->assignVars();
        $this->vars['postsTotal'] = Email::count();
        $this->vars['popularPost'] = $this->popularPost;
        BackendMenu::setContext('Lasso.Adminsendmail', 'email', 'emails');
        $topViewedWidget = new TopViewed($this);
        $topViewedWidget->alias = 'topViewed';
        $topViewedWidget->bindToController();
    }

    public function assignVars()
    {
        $this->popularPost = Email::orderBy('views', 'desc')->take(1)->get();

    }

    public function onSend()
    {
        return Email::find(1);
    }

    public function send($id = null)
    {
        $email = Email::with('attachments')->find($id);

        if(is_null($email))
            return Redirect::to(Backend::url('lasso/adminsendmail/emails'));

        // TODO: load subscribers and send email

        return $this->makePartial('send', [
                'email' => $email
            ]);
    }

    public function download($id = null)
    {
        $file = File::find($id);

         if(is_null($file))
            return Redirect::to(Backend::url('lasso/adminsendmail/emails'));

        echo $file->output();
    }
}