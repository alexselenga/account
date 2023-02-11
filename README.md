Порядок запуска:
    composer install
    cd console
    php index.php

Версия PHP 8.1
Без unit тестирования.


Результат:

$ php index.php


### 1
Array
(
    [bank\RUB] => bank\RUB Object
        (
            [rates:protected] => Array
                (
                )

        )

    [bank\EUR] => bank\EUR Object
        (
            [rates:protected] => Array
                (
                    [bank\RUB] => 80
                    [bank\USD] => 1
                )

        )

    [bank\USD] => bank\USD Object
        (
            [rates:protected] => Array
                (
                    [bank\RUB] => 70
                )

        )

)


### 2
1000 RUB
40 USD
50 EUR


### 5
2000 RUB


### 6
100 EUR


### 7
106.66666666667 EUR


### 9
106.66666666667 EUR


### 10
Array
(
    [bank\RUB] => bank\RUB Object
        (
            [rates:protected] => Array
                (
                )

        )

)

18800 RUB
