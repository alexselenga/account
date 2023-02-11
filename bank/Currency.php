<?php

namespace bank;

abstract class Currency
{
	protected array $rates = [];

	//Установить курс обмена валют
	public function setExchangeRate(Currency $currency, $rate)
	{
		$this->rates[$currency::class] = $rate;
	}

	//Получить курс обмена валют
	public function getExchangeRate(Currency $currency): float|null
	{
		return $this->rates[$currency::class] ?? NULL;
	}

	abstract public function getName(): string;
}
