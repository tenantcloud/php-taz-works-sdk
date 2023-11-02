<?php

namespace Tests\Integration;

use DMS\PHPUnitExtensions\ArraySubset\Constraint\ArraySubset;
use GoodPhp\Serialization\TypeAdapter\Json\JsonTypeAdapter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use TenantCloud\TazWorksSDK\Http\Serialization\SerializerFactory;
use TenantCloud\TazWorksSDK\Searches\SearchResultType;

class SearchResultsSerializationTest extends TestCase
{
	#[DataProvider('deserializesAndSerializesSearchResultsProvider')]
	public function testDeserializesAndSerializesSearchResults(string $className, string $filePath, string $expectedFilePath): void
	{
		$serializer = SerializerFactory::make();
		$typeAdapter = $serializer->adapter(JsonTypeAdapter::class, $className);

		$original = file_get_contents($filePath);

		$deserialized = $typeAdapter->deserialize($original);
		$serialized = $typeAdapter->serialize($deserialized);

		$expected = json_decode(file_get_contents($expectedFilePath), true, 512, JSON_THROW_ON_ERROR);

		expect($serialized)->json()->toMatchConstraint(new ArraySubset($expected));
	}

	public static function deserializesAndSerializesSearchResultsProvider(): iterable
	{
		foreach (SearchResultType::cases() as $type) {
			$finder = (new Finder())
				->in(__DIR__ . '/../../resources/results/' . $type->value)
				->name('*.json');

			foreach ($finder as $file) {
				yield $type->value . ' -> ' . $file->getRelativePathname() => [
					$type->className(),
					$file->getRealPath(),
					__DIR__ . '/SearchResultsSerialization/' . $type->value . '/' . $file->getRelativePathname(),
				];
			}
		}
	}
}
