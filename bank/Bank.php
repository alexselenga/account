<?php

namespace bank;

class Bank
{
	const COURSE_EUR_RUB = 'COURSE_EUR_RUB';
	const COURSE_USD_RUB = 'COURSE_USD_RUB';
	const COURSE_EUR_USD = 'COURSE_EUR_USD';

	protected array $accountList = [];

	public function createAccount(): Account
	{
		$account = new Account;
		$this->accountList[] = $account;
		return $account;
	}

	public function removeAccount(Account $account)
	{
		$key = array_search($account, $this->accountList);
		if($key === false) return;
		unset($this->accountList[$key]);
	}

	public function getAccountList(): array
	{
		return $this->accountList;
	}

	public static function getCourse(string $courseName): float|null
	{
		switch($courseName)
		{
			case static::COURSE_EUR_RUB:
				return 80;
			case static::COURSE_USD_RUB:
				return 70;
			case static::COURSE_EUR_USD:
				return 1;
		}

		return null;
	}
}
