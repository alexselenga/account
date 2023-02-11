<?php

namespace bank;

class USD extends Currency
{
	public function __construct()
	{
		$this->rates[RUB::class] = Bank::getCourse(Bank::COURSE_USD_RUB);
	}

	public function getName(): string
	{
		return 'USD';
	}
}
