<?php

namespace App\Services\Notfications;

interface NotificationInterface
{
    public function send(string $mode);
}
