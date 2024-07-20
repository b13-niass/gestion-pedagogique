<?php

namespace GPD\Core\Impl;

interface IValidator
{
    public function validate($data, $rules);
}