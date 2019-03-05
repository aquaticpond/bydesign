<?php

namespace Aquatic\ByDesign\Exceptions;

use InvalidArgumentException;

class InvalidAPICredentials extends InvalidArgumentException
{
    protected $message = 'Invalid ByDesign API Credentials';
}
