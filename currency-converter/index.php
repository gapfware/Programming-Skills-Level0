<?php

require_once 'converter.php';
require_once 'exchangeRateSource.php';

$converter = new CurrencyConverter(new ApiExchangeRateSource());

echo "----------------------" . PHP_EOL;
echo "Currencies exchange:" . PHP_EOL;
echo "----------------------" . PHP_EOL;


try {
    while (true) {
        
        echo "1. List currencies" . PHP_EOL;
        echo "2. Convert" . PHP_EOL;
        echo "3. Exit" . PHP_EOL;

        switch (readline()) {
            case 1:
                system('clear');
                
                $converter->listCurrencies();
                break;
            case 2:
                system('clear');
                $from = readline('Enter currency code to convert from: ');
                $to = readline('Enter currency code to convert to: ');
                $amount = readline('Enter amount: ');

                echo "----------------------" . PHP_EOL;
                echo "Result: " . $converter->convert($from, $to, $amount) . strtoupper($to)     . PHP_EOL;
                echo "----------------------" . PHP_EOL;

                echo "WITHDRAW? (y/n)" . PHP_EOL;
                $withdraw = readline();
                if ($withdraw == 'y') {
                    echo "You withdrawn " . $converter->witdrawSimulator($amount, $from) . strtoupper($to) . PHP_EOL;
                }
                break;
            case 3:
                system('clear');
                echo "Bye!" . PHP_EOL;
                exit;
        }
    }
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
}
