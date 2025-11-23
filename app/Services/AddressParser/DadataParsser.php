<?php

namespace App\Services\AddressParser;
use Dadata\DadataClient;

class DadataParsser implements ParsserInterface
{
    public function __construct(protected DadataClient $dadata)
    {
        
    }
    
    public function clean(string $address) : array
    {
        return $this->dadata->clean("address", "мск сухонская 11 89");
    }
}