<?php

namespace TenantCloud\TazWorksSDK\Http\Serialization;

use GoodPhp\Serialization\Serializer;
use GoodPhp\Serialization\SerializerBuilder;
use GoodPhp\Serialization\TypeAdapter\Primitive\BuiltIn\DateTimeMapper;

class SerializerFactory
{
	public static function make(): Serializer
	{
		return (new SerializerBuilder())
			->addMapper(new SafeDateMapper(new DateTimeMapper()))
			->build();
	}
}
