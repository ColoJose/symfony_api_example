<?php

namespace App\Controller\Helper;

interface Validatable
{
    public function isValid(): bool;
}