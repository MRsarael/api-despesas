<?php

namespace App\Utils;

use Carbon\Carbon;
use Exception;

class Util
{
    public static function convertMessageErrorFormRequest(array $messages)
    {
        $message = '';

        foreach ($messages as $key => $value) 
            $message .= $key.": ".$value[0].";";
        
        return $message;
    }
}