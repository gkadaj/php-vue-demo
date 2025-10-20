<?php
declare(strict_types=1);

namespace App\Controller;

class CORSHeader
{
    /** TODO change CORS configuration in production */
    public static array $headers = [
        'Access-Control-Allow-Origin' => '*',
    ];
}