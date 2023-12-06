<?php

namespace App\Response;

interface GlobalResponseInterface
{
    public function get();
    public function success();
    public function error();
    public function setMessage(string $message);
    public function setData(array $data);

}


