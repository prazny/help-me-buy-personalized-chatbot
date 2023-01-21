<?php

namespace App\Services\Chat\Interfaces;

use App\Services\Chat\Response;

interface MessageTypeInterface
{
    public function getResponse(): Response;

}
