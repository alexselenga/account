<?php

namespace bank;

class Account
{
	protected array $currencyList = []; //Список поддерживаемых валют для счета

	protected Currency|null $mainCurrency = NULL; //Основная валюта

	protected array $cashes = []; //Баланс: ключ - наименование класса валюты

	public function addCurrency(Currency $currency)
	{
		if(!isset($this->currencyList[$currency::class]))
		{
			$this->currencyList[$currency::class] = $currency;
		}

		if(!$this->mainCurrency)
		{
			$this->mainCurrency = $currency;
		}
	}

	public function removeCurrency(Currency $currency): bool
	{
		if(!$this->mainCurrency || $this->mainCurrency::class === $currency::class)
		{
			return false;
		}

		$mainCash = $this->cashes[$this->mainCurrency::class];
		/** @var Cash $mainCash */
		$cash = $this->cashes[$currency::class];
		/** @var Cash $oldCash */
		$rate = $this->getExchangeRateToMainCurrency($currency);

		if(is_null($rate))
		{
			return false;
		}

		$cashValue = $mainCash->getValue() + $cash->getValue() * $rate;
		$newCash = new Cash($cashValue, $this->mainCurrency);
		$this->cashes[$this->mainCurrency::class] = $newCash;
		unset($this->cashes[$currency::class]);
		unset($this->currencyList[$currency::class]);

		return true;
	}

	public function setMainCurrency(Currency $currency)
	{
		$this->mainCurrency = $currency;
		$this->addCurrency($currency);
	}

	public function getMainCurrency(): Currency|null
	{
		return $this->mainCurrency;
	}

	public function getCurrencyList(): array
	{
		return $this->currencyList;
	}

	//Пополнение баланса
	public function addToBalance(Cash $cash): bool
	{
		$currency = $cash->getCurrency();
		$currencyClassName = $currency::class;

		if(!isset($this->currencyList[$currencyClassName]))
		{
			return false;
		}

		if(isset($this->cashes[$currencyClassName]))
		{
			$oldCash = $this->cashes[$currencyClassName];
			/** @var Cash $oldCash */
			$newValue = $oldCash->getValue() + $cash->getValue();
			$newCash = new Cash($newValue, $currency);
			$this->cashes[$currencyClassName] = $newCash;
		}
		else
		{
			$this->cashes[$currencyClassName] = $cash;
		}

		$this->logDebet($cash);
		return true;
	}

	//Списание с баланса
	public function subFromBalance(Cash $cash): bool
	{
		$currency = $cash->getCurrency();
		$currencyClassName = $currency::class;

		if(!isset($this->currencyList[$currencyClassName]) || !isset($this->cashes[$currencyClassName]))
		{
			return false;
		}

		$oldCash = $this->cashes[$currencyClassName];
		/** @var Cash $oldCash */
		$newValue = $oldCash->getValue() - $cash->getValue();

		if($newValue < 0)
		{
			return false;
		}

		$newCash = new Cash($newValue, $currency);
		$this->cashes[$currencyClassName] = $newCash;
		$this->logCredit($cash);

		return true;
	}

	//Сконвертировать в основную валюту
	public function toMainCurrency(Cash $cash): bool
	{
		$currency = $cash->getCurrency();
		$currencyClassName = $currency::class;

		if(is_null($this->mainCurrency)
			|| $this->mainCurrency::class === $currencyClassName
			|| !isset($this->currencyList[$currencyClassName])
			|| !isset($this->cashes[$currencyClassName]))
		{
			return false;
		}

		$rate = $this->getExchangeRateToMainCurrency($currency);

		if(is_null($rate) || !$this->subFromBalance($cash))
		{
			return false;
		}

		$newCashValue = $cash->getValue() * $rate;
		$newCash = new Cash($newCashValue, $this->mainCurrency);
		$this->addToBalance($newCash);

		return true;
	}

	//Получить баланс
	public function getCash(Currency $currency = NULL): Cash|null
	{
		if(is_null($currency))
		{
			$currency = $this->mainCurrency;

			if(is_null($currency))
			{
				return NULL;
			}
		}

		if(!isset($this->currencyList[$currency::class]) || !isset($this->cashes[$currency::class]))
		{
			return NULL;
		}

		return $this->cashes[$currency::class];
	}

	//Курс обмена по отношению к основной валюте
	protected function getExchangeRateToMainCurrency(Currency $currency): float|null
	{
		$rate = $currency->getExchangeRate($this->mainCurrency);

		if(is_null($rate))
		{
			$rate = $this->mainCurrency->getExchangeRate($currency);

			if(is_null($rate))
			{
				return NULL;
			}

			$rate = 1 / $rate;
		}

		return $rate;
	}

	//Регистрация поступлений на счет
	protected function logDebet(Cash $cash)
	{
	}

	//Регистрация списаний со счета
	protected function logCredit(Cash $cash)
	{
	}
}
