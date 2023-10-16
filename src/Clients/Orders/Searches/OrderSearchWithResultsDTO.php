<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders\Searches;

use Crell\Serde\Attributes\Field;
use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;

/**
 * @template ResultsType of CriminalResult
 */
class OrderSearchWithResultsDTO
{
	public function __construct(
		public readonly OrderSearchDTO $search,
		/** @var CriminalResult */
		public readonly CriminalResult $results,
	)
	{
	}
}
