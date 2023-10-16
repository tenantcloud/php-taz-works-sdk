<?php

namespace TenantCloud\TazWorksSDK\Http\Serialization;

use Attribute;
use Crell\Serde\TypeField;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ForUnknownUseNull implements TypeField
{
	public function acceptsType(string $type): bool
	{
		return true;
	}

	public function validate(mixed $value): bool
	{
		return true;
	}
}

