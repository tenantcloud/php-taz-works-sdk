<?php

namespace Tests\Unit\Http\Serialization;

use Carbon\CarbonImmutable;
use GoodPhp\Reflection\Type\NamedType;
use GoodPhp\Serialization\TypeAdapter\Primitive\BuiltIn\DateTimeMapper;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use TenantCloud\TazWorksSDK\Http\Serialization\SafeDateMapper;

class SafeDateMapperTest extends TestCase
{
	#[DataProvider('fromProvider')]
	public function testFrom(?string $expected, string $value): void
	{
		$mapper = new SafeDateMapper(new DateTimeMapper());

		self::assertSame($expected, $mapper->from($value, new NamedType(CarbonImmutable::class))?->toISOString());
	}

	public static function fromProvider(): iterable
	{
		yield ['2019-08-01T00:00:00.000000Z', '2019-08-01'];

		yield ['2019-08-01T00:00:00.000000Z', '2019/08/01'];

		yield ['2019-08-01T14:34:35.000000Z', '2019/08/01 14:34:35'];

		yield ['2020-10-27T00:00:00.000000Z', '10/27/2020&nbsp;'];

		yield [null, 'XXXX-04-01'];

		yield [null, 'Partial DOB On File: 04/21'];
	}
}
