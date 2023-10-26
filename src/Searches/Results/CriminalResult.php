<?php

namespace TenantCloud\TazWorksSDK\Searches\Results;

use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult\CriminalRecord;

final class CriminalResult
{
	public function __construct(
		public readonly ?string $jurisdictionsSearched = null,
		/** @var CriminalRecord[] */
		public readonly array $records = [],
	) {}
}
