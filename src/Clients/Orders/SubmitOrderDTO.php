<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders;

use Crell\Serde\Attributes\SequenceField;
use TenantCloud\TazWorksSDK\Searches\SearchResultType;

class SubmitOrderDTO
{
	public function __construct(
		public readonly string $applicantGuid,
		public readonly string $clientProductGuid,
		public readonly ?string $externalIdentifier = null,
		public readonly bool $useQuickApp = false,
		/** @var SearchResultType[] */
		#[SequenceField(arrayType: SearchResultType::class)]
		public readonly array $optionalSearches = [],
	)
	{
	}
}
