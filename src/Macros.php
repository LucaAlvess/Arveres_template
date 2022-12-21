<?php

namespace ArveresTemplate;
class Macros
{
    public function lower(string $value): string
    {
        return strtolower($value);
    }

    public function upper(string $value): string
    {
        return strtoupper($value);
    }

    public function uc(string $value): string
    {
        return ucfirst(strtolower($value));
    }
}