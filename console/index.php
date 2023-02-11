<?php

require dirname(__DIR__).'/vendor/autoload.php';

use bank\Bank;
use bank\Cash;
use bank\EUR;
use bank\RUB;
use bank\USD;

//1
echo "\n\n### 1\n";
$bank = new Bank;
$rub = new RUB;
$eur = new EUR;
$usd = new USD;

$account = $bank->createAccount();
$account->addCurrency($rub);
$account->addCurrency($eur);
$account->addCurrency($usd);
$account->setMainCurrency($rub);
print_r($account->getCurrencyList());
$account->addToBalance(new Cash(1000, $rub));
$account->addToBalance(new Cash(50, $eur));
$account->addToBalance(new Cash(40, $usd));

//2
echo "\n\n### 2\n";
$rubCash = $account->getCash();
echo $rubCash->getValue(), ' ', $rubCash->getCurrency()->getName(), "\n";
$usdCash = $account->getCash($usd);
echo $usdCash->getValue(), ' ', $usdCash->getCurrency()->getName(), "\n";
$eurCash = $account->getCash($eur);
echo $eurCash->getValue(), ' ', $eurCash->getCurrency()->getName(), "\n";

//3
$account->addToBalance(new Cash(1000, $rub));
$account->addToBalance(new Cash(50, $eur));
$account->addToBalance(new Cash(10, $usd));

//4
$eur->setExchangeRate($rub, 150);
$usd->setExchangeRate($rub, 100);

//5
echo "\n\n### 5\n";
$rubCash = $account->getCash();
echo $rubCash->getValue(), ' ', $rubCash->getCurrency()->getName(), "\n";

//6
echo "\n\n### 6\n";
$account->setMainCurrency($eur);
$eurCash = $account->getCash();
echo $eurCash->getValue(), ' ', $eurCash->getCurrency()->getName(), "\n";

//7
echo "\n\n### 7\n";
$account->toMainCurrency(new Cash(1000, $rub));
$eurCash = $account->getCash();
echo $eurCash->getValue(), ' ', $eurCash->getCurrency()->getName(), "\n";

//8
$eur->setExchangeRate($rub, 120);

//9
echo "\n\n### 9\n";
$eurCash = $account->getCash();
echo $eurCash->getValue(), ' ', $eurCash->getCurrency()->getName(), "\n";

//10
echo "\n\n### 10\n";
$account->setMainCurrency($rub);
$account->removeCurrency($eur);
$account->removeCurrency($usd);
print_r($account->getCurrencyList());
echo "\n";
$rubCash = $account->getCash();
echo $rubCash->getValue(), ' ', $rubCash->getCurrency()->getName(), "\n";
