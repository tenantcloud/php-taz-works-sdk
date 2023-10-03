<?php

namespace TenantCloud\TazWorksSDK\Http\Serialization;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Crell\Serde\Attributes\Field;
use Crell\Serde\Deserializer;
use Crell\Serde\PropertyHandler\DateTimeExporter;
use Crell\Serde\SerdeError;

class SafeCarbonDateTimeExporter extends DateTimeExporter
{
	public function importValue(Deserializer $deserializer, Field $field, mixed $source): mixed
	{
		$string = $deserializer->deformatter->deserializeString($source, $field);

		if ($string === SerdeError::Missing) {
			return null;
		}

		if (str_contains($string, 'X')) {
			return null;
		}

		// @todo It would be helpful to use https://www.php.net/manual/en/datetimeimmutable.createfromformat.php
		// to only accept value sin the expected format. However, that method
		// auto-fills missing values with the current time.  The constructor does
		// not.  So if you have a Y-m-d string of 2022-07-04T00:00:00 and create a new DTI
		// using the constructor, you get that timestamp. If you use createFromFormat(),
		// you get that date but the time is filled in with whenever you ran the code.
		// Once we figure out how to deal with that (arguably it's a PHP bug),
		// an opt-in/out flag to restrict the format on import should be added
		// to DateField to get used here.  Until then, this will do.

		return new ($field->phpType)($string);
	}

	public function canImport(Field $field, string $format): bool
	{
		return in_array($field->phpType, [Carbon::class, CarbonImmutable::class], true);
	}
}

