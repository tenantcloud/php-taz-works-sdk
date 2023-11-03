<?php

namespace TenantCloud\TazWorksSDK\Http\Serialization;

use DateTimeInterface;
use GoodPhp\Reflection\Reflection\Attributes\Attributes;
use GoodPhp\Reflection\Type\NamedType;
use GoodPhp\Serialization\TypeAdapter\Primitive\BuiltIn\DateTimeMapper;
use GoodPhp\Serialization\TypeAdapter\Primitive\MapperMethods\Acceptance\BaseTypeAcceptedByAcceptanceStrategy;
use GoodPhp\Serialization\TypeAdapter\Primitive\MapperMethods\MapFrom;
use GoodPhp\Serialization\TypeAdapter\Primitive\MapperMethods\MapTo;
use GoodPhp\Serialization\TypeAdapter\Primitive\PrimitiveTypeAdapter;

class SafeDateMapper
{
	public function __construct(
		private readonly DateTimeMapper $delegate
	) {}

	#[MapTo(PrimitiveTypeAdapter::class, new BaseTypeAcceptedByAcceptanceStrategy(DateTimeInterface::class))]
	public function to(DateTimeInterface $value, Attributes $attributes): string
	{
		return $this->delegate->to($value, $attributes);
	}

	#[MapFrom(PrimitiveTypeAdapter::class, new BaseTypeAcceptedByAcceptanceStrategy(DateTimeInterface::class))]
	public function from(string $value, NamedType $type): ?DateTimeInterface
	{
		if (str_contains($value, 'X')) {
			return null;
		}

		return $this->delegate->from($value, $type);
	}
}
