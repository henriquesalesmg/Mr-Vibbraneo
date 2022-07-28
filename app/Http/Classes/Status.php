<?php

namespace App\Http\Classes;

class Status
{
    public static function status($status)
    {
        switch ($status) {
            case 0:
                $status = 'Created';
                break;
            case 0:
                $status = 'Started';
                break;
            case 1:
                $status = 'In production';
                break;
            case 2:
                $status = 'Done';
                break;
            case 3:
                $status = 'Incomplete';
                break;
        }
        return $status;
    }
}
