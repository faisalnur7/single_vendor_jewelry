<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\HtmlString;

class ResetPasswordCustom extends Notification
{
    use Queueable;
    
    public $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $setting = GeneralSetting::first();
        $site_logo = null;
        $site_name = null;
        
        if(!empty($setting)){
            $site_logo = $setting->site_logo;
            $site_name = $setting->site_name;
        }
        $url = url(route('user.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ], false));

        return (new MailMessage)
        ->subject('Reset Your Password')
        ->view('emails.password-reset', [
            'url' => $url,
            'user' => $notifiable,
            'site_logo' => $site_logo,
            'site_name' => $site_name
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
