<?php

use GoodPhp\Serialization\MissingValue;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Psr16Cache;
use TenantCloud\TazWorksSDK\Clients\Applicants\Addresses\AddressDTO;
use TenantCloud\TazWorksSDK\Clients\Applicants\Addresses\AddressType;
use TenantCloud\TazWorksSDK\Clients\Applicants\Addresses\UpsertAddressDTO;
use TenantCloud\TazWorksSDK\Clients\Applicants\UpsertApplicantDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderStatus;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\SubmitOrderDTO;
use TenantCloud\TazWorksSDK\Fake\FakeTazWorksClient;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;
use TenantCloud\TazWorksSDK\Http\Serialization\SerializerFactory;
use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;
use TenantCloud\TazWorksSDK\Searches\Results\NationalCriminalDatabaseAlias\NationalCriminalResult;
use TenantCloud\TazWorksSDK\Searches\SearchResultType;
use TenantCloud\TazWorksSDK\TazWorksClient;

$makeFakeClient = fn () => new FakeTazWorksClient(
	cache: new Psr16Cache(new ArrayAdapter()),
	serializer: SerializerFactory::make(),
	clients: [
		'7f8feafb-745b-4ea2-b50a-98b76da39c38' => [
			'products' => [
				'02f4d895-871e-47f7-9fec-99ed59532c60' => [
					'searches' => [
						[
							'type'         => SearchResultType::NATIONAL_CRIMINAL_DATABASE_ALIAS,
							'display_name' => 'National Criminal, SSN Trace, Name Alias, OIG, OFAC, Terrorist Watch List, Government Sanctions, Sex offender, Address History',
							'set'          => 'regular',
						],
						[
							'type'         => SearchResultType::COUNTY_CRIMINAL_RECORD,
							'display_name' => '7 year Unlimited County Search',
							'set'          => 'all',
						],
					],
				],
			],
		],
	],
);
$makeHttpClient = fn () => new HttpTazWorksClient(
	baseUrl: 'https://api-sandbox.instascreen.net',
	apiToken: '',
	serializer: SerializerFactory::make()
);

test('client - create, update applicant; submit order; receive list of orders and results for each', function (callable $makeClient, string $clientProductGuid, callable $checkResults) {
	/** @var TazWorksClient $client */
	$client = $makeClient();
	$clientApi = $client->client('7f8feafb-745b-4ea2-b50a-98b76da39c38');

	$applicant = $clientApi->applicants()->create(
		UpsertApplicantDTO::testGoodResults()
	);

	$applicant = $clientApi->applicants()->update(
		$applicant->id,
		UpsertApplicantDTO::testBadResults()
	);

	$foundApplicant = $clientApi->applicants()->find($applicant->id);
	expect($foundApplicant)->toEqual($applicant);

	$address = $clientApi->applicants()->addresses()->create(
		$applicant->id,
		new UpsertAddressDTO(
			type: AddressType::DOMESTIC,
			streetOne: '12345 Lamplight Village Ave',
			streetTwo: null,
			city: 'Austin',
			stateOrProvince: 'TX',
			postalCode: '76878',
			country: 'US',
		)
	);

	$addresses = $clientApi->applicants()->addresses()->list($applicant->id);
	expect($addresses)->toHaveCount(1);
	expect($addresses[0])->toEqual(
		new AddressDTO(
			id: $address->id,
			type: $address->type,
			streetOne: $address->streetOne,
			streetTwo: $address->streetTwo,
			city: $address->city,
			stateOrProvince: $address->stateOrProvince,
			postalCode: $address->postalCode,
			country: $address->country,
		)
	);

	$order = $clientApi->orders()->submit(new SubmitOrderDTO(
		applicantGuid: $applicant->id,
		clientProductGuid: $clientProductGuid,
	));

	expect($order->applicantId)->toBe(MissingValue::INSTANCE);
	expect($order->clientProductId)->toBe(MissingValue::INSTANCE);

	sleep(5);

	$order = $clientApi->orders()->find($order->id);

	expect($order->status)->toBe(OrderStatus::COMPLETE);
	expect($order->applicantId)->toBe($applicant->id);
	expect($order->clientProductId)->toBe($clientProductGuid);

	$results = array_map(
		fn (OrderSearchDTO $search) => $clientApi->orders()->searches()->results($order->id, $search->id)->results,
		$clientApi->orders()->searches()->list($order->id),
	);

	$checkResults($results);
})->with([
	[$makeFakeClient, '02f4d895-871e-47f7-9fec-99ed59532c60', function (array $results) {
		expect($results)->toHaveCount(2);
		expect($results[0])->toBeInstanceOf(NationalCriminalResult::class);
		expect($results[0]->baseResult->records)->toHaveCount(4);
		expect($results[1])->toBeInstanceOf(CriminalResult::class);
		expect($results[1]->records)->toHaveCount(6);
	}],

	[$makeHttpClient, 'c7e67758-6758-4820-959a-e2131d47a5bf', function (array $results) {
		expect($results)->toHaveCount(1);
		expect($results[0])->toBeInstanceOf(NationalCriminalResult::class);
	}],
	[$makeHttpClient, '3fff0153-13df-40d5-a7c2-c02ed8887abf', function (array $results) {
		expect($results)->toHaveCount(2);
	}],
	[$makeHttpClient, '02f4d895-871e-47f7-9fec-99ed59532c60', function (array $results) {
		expect($results)->toHaveCount(2);
	}],
]);
