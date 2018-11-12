<?php

namespace Waygou\Surveyor\Exceptions;

use Exception;

class RepositoryException extends Exception
{
    public static function notInitialized()
    {
        return new static('Repository not initialized. Please login again.');
    }
}
