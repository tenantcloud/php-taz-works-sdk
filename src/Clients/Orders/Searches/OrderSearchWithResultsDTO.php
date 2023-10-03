<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders\Searches;

use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;

/**
 * @template ResultsType of CriminalResult
 */
class OrderSearchWithResultsDTO
{
	public function __construct(
		/** @var CriminalResult */
		public readonly CriminalResult $results,
	)
	{
	}
}
