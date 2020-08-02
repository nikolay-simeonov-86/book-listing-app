<?php

namespace App\Controllers;

abstract class BaseController
{
    protected function renderView(string $path, array $data)
    {
        ob_start();
        include($path);
        $var=ob_get_contents(); 
        ob_end_clean();
        return $var;
    }
}
