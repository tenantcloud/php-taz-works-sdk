<?php

namespace TenantCloud\TazWorksSDK\Searches;

use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;
use TenantCloud\TazWorksSDK\Searches\Results\NationalCriminalDatabaseAlias\NationalCriminalResult;

enum SearchResultType: string
{
	case COUNTY_CRIMINAL_RECORD = 'COUNTY_CRIMINAL_RECORD';
	case NATIONAL_CRIMINAL_DATABASE_ALIAS = 'NATIONAL_CRIMINAL_DATABASE_ALIAS';

	public function className(): string
	{
		return match ($this) {
			self::COUNTY_CRIMINAL_RECORD           => CriminalResult::class,
			self::NATIONAL_CRIMINAL_DATABASE_ALIAS => NationalCriminalResult::class,
		};
	}
}
