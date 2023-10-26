<?php

namespace TenantCloud\TazWorksSDK\Searches\Results\NationalCriminalDatabaseAlias;

use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Property\Flattening\Flatten;
use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;
use TenantCloud\TazWorksSDK\Searches\Results\SsnInfo;

final class NationalCriminalResult
{
	public function __construct(
		#[Flatten]
		public readonly CriminalResult $baseResult,
		public readonly ?string $nameVariationsSearched = null,
		/** @var SsnInfo[] */
		public readonly array $ssnInfos = [],
		/** @var AddressInfo[] */
		public readonly array $addressInfos = [],
	) {}
}
