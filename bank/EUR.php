<?php

namespace bank;

class EUR extends Currency
{
	public function __construct()
	{
		$this->rates[RUB::class] = Bank::getCourse(Bank::COURSE_EUR_RUB);
		$this->rates[USD::class] = Bank::getCourse(Bank::COURSE_EUR_USD);
	}

	public function getName(): string
	{
		return 'EUR';
	}
}
