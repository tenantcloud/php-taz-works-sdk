<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders\Searches;

use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Property\Flattening\Flatten;
use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;

class OrderSearchWithResultsDTO
{
	public function __construct(
		#[Flatten]
		public readonly OrderSearchDTO $search,
		public readonly ?CriminalResult $results = null,
	)
	{
	}
}
