<?php

namespace TenantCloud\TazWorksSDK;

use Webmozart\Assert\Assert;

class TazAssert
{
	public static function ssn(string $value): void
	{
		Assert::regex($value, '/^\d{3}-\d{2}-\d{4}$/');
	}
}
