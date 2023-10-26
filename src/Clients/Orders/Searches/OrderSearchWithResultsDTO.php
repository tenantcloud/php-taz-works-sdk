<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders\Searches;

use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Property\Flattening\Flatten;
use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;
use TenantCloud\TazWorksSDK\Searches\Results\NationalCriminalDatabaseAlias\NationalCriminalResult;

class OrderSearchWithResultsDTO
{
	public function __construct(
		#[Flatten]
		public readonly OrderSearchDTO $search,
		public readonly CriminalResult|NationalCriminalResult|null $results = null,
	) {}
}
