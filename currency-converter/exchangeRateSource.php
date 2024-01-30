<?php


interface IExchangeRateSource
{
    public function getExchangeRates(): array;
}

class ApiExchangeRateSource implements IExchangeRateSource
{
    public function getExchangeRates(): array
    {
        $response = file_get_contents('https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies/usd.json');
        return json_decode($response, true);
    }
}
