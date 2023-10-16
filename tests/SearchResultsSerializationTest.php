<?php

use DMS\PHPUnitExtensions\ArraySubset\Constraint\ArraySubset;
use Illuminate\Support\LazyCollection;
use Symfony\Component\Finder\Finder;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;
use TenantCloud\TazWorksSDK\Http\Serialization\SerializerFactory;
use TenantCloud\TazWorksSDK\Searches\Results\BaseSubject;
use TenantCloud\TazWorksSDK\Searches\Results\Subject;
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
	$original = file_get_contents($filePath);

	$deserialized = $serializer->deserialize($original, from: 'json', to: $className);
	$serialized = $serializer->serialize($deserialized, format: 'json');

	expect($serialized)
		->json()
		->toMatchConstraint(
			new ArraySubset(json_decode($original, true, 512, JSON_THROW_ON_ERROR))
		);
})->with('search results');
