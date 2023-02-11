<?php

namespace bank;

class Cash
{
	public function __construct(protected float $cash, protected Currency $currency)
	{
	}

	public function getValue(): float
	{
		return $this->cash;
	}

	public function getCurrency(): Currency
	{
		return $this->currency;
	}
}
