<?php

namespace App\Services\Notfications;

use App\DTO\UserRegisterDTO;
use App\Mail\ConfirmEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailService implements NotificationInterface
{
    private UserRegisterDTO $data;
    private $template;

    public function config(UserRegisterDTO $data): static
    {
        $this->data = $data;
        return $this;
    }

    private function ConfirmEmail() {
        $mailData = [
            "name" => $this->data->name,
            "code" => $this->data->access_token
        ];

        $template = new ConfirmEmail($mailData);
        Mail::to($this->data->email)->queue($template);

    }

    public function send(string $mode)
    {
        switch ($mode) {
            case "confirm":
                $this->ConfirmEmail();
                break;
            default:
                throw new \Error("Missing Mail mode parameter");
        }
    }
}
