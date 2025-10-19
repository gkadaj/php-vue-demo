<?php
declare(strict_types=1);

namespace App\Controller;

class CORSHeader
{
    public static array $headers = [
        'Access-Control-Allow-Origin' => '*',
    ];
}