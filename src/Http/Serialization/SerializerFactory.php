<?php

namespace TenantCloud\TazWorksSDK\Http\Serialization;

use Crell\Serde\SerdeCommon;

class SerializerFactory
{
	public static function make(): SerdeCommon
	{
		return new SerdeCommon(
			handlers: [
				new SafeCarbonDateTimeExporter(),
				new SafeEnumExporter(),
			]
		);
	}
}
