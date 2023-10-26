<?php

use DMS\PHPUnitExtensions\ArraySubset\Constraint\ArraySubset;
use GoodPhp\Serialization\TypeAdapter\Json\JsonTypeAdapter;
use Illuminate\Support\LazyCollection;
use Symfony\Component\Finder\Finder;
use TenantCloud\TazWorksSDK\Http\Serialization\SerializerFactory;
use TenantCloud\TazWorksSDK\Searches\SearchResultType;

dataset(
	'search results',
	LazyCollection::make(SearchResultType::cases())
		->mapWithKeys(function (SearchResultType $type) {
			$finder = (new Finder())
				->in(__DIR__ . '/../resources/results/' . $type->value)
				->name('*.json');

			foreach ($finder as $file) {
				yield $type->value . ' -> ' . $file->getRealPath() => [$type->className(), $file->getRealPath()];
			}
		})
		->all()
);

it('deserializes search results for every type', function (string $className, string $filePath) {
	$serializer = SerializerFactory::make();
	$typeAdapter = $serializer->adapter(JsonTypeAdapter::class, $className);

	$original = file_get_contents($filePath);

	$deserialized = $typeAdapter->deserialize($original);
	$serialized = $typeAdapter->serialize($deserialized);

	expect($serialized)
		->json()
		->toMatchConstraint(
			new ArraySubset(json_decode($original, true, 512, JSON_THROW_ON_ERROR))
		);
})->with('search results');
