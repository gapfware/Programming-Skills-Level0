<?php

require_once 'exchangeRateSource.php';

class CurrencyConverter
{
    private $exchangeRates;

    public function __construct(IExchangeRateSource $exchangeRateSource)
    {
        $this->exchangeRates = $exchangeRateSource->getExchangeRates();
    }

    public function convert($from, $to, $amount)
    {
        $mainCurency = 'usd';
        $from = strtolower($from);
        $to = strtolower($to);

        if (!isset($this->exchangeRates[$mainCurency][$from]) || !isset($this->exchangeRates[$mainCurency][$to])) {
            throw new InvalidArgumentException('Invalid currency codes provided.');
        }

        if ($from == 'USD') {
            $result = $amount * $this->exchangeRates[$mainCurency][$to];
        } else {
            $result = $amount / $this->exchangeRates[$mainCurency][$from];
            $result = $result * $this->exchangeRates[$mainCurency][$to];
        }

        return round($result, 3);
    }

    public function getExchangeRates($currency = 'usd')
    {
        return $this->exchangeRates[$currency];
    }

    public function listCurrencies()
    {
        foreach ($this->exchangeRates['usd'] as $currency => $rate) {
            echo $currency . ' - ' . $rate . PHP_EOL;
        }
    }

    public function witdrawSimulator($amount, $currency)
    {
        $result = (int) self::convert($currency, 'usd', $amount);
        return $result - ($result * 0.01);
    }
}
