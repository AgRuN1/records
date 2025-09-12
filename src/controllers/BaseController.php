<?php

namespace controllers;

class BaseController
{
    protected function validate_int($value)
    {
        return is_numeric($value);
    }

    protected function validate_string($value){
        return is_string($value) && strlen($value) <= 40;
    }
}