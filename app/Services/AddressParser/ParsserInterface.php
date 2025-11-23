<?php

namespace App\Services\AddressParser;

interface ParsserInterface 
{
    public function clean(string $address) : array;
    
}