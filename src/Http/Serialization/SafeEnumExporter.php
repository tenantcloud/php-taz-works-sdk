<?php

namespace TenantCloud\TazWorksSDK\Http\Serialization;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Crell\Serde\Attributes\Field;
use Crell\Serde\Deserializer;
use Crell\Serde\PropertyHandler\DateTimeExporter;
use Crell\Serde\PropertyHandler\EnumExporter;
use Crell\Serde\SerdeError;
use Crell\Serde\TypeCategory;

class SafeEnumExporter extends EnumExporter
{
	public function importValue(Deserializer $deserializer, Field $field, mixed $source): mixed
	{
		try {
			return parent::importValue($deserializer, $field, $source);
		} catch (\ValueError $e) {
			if ($field->typeField instanceof ForUnknownUseNull) {
				return null;
			}

			throw $e;
		}
	}
}

