<?php

namespace TenantCloud\TazWorksSDK\Http\Serialization;

use Carbon\Exceptions\InvalidArgumentException;
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
		if (str_contains($value, 'X') || str_contains($value, 'Partial')) {
			return null;
		}

		// See tests for why this is done this way. TazWorks loves to return invalid dates.
		$value = preg_replace('/[^0-9\/: ]/i', '', $value);

		try {
			return $this->delegate->from($value, $type);
		} catch (InvalidArgumentException) {
			return null;
		}
	}
}
