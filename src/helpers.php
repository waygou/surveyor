<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('me')) {
    function me()
    {
        return Auth::user();
    }
}
