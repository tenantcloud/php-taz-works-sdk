<?php

use Illuminate\Support\Arr;
use TenantCloud\TazWorksSDK\Clients\Applicants\UpsertApplicantDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderStatus;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\SubmitOrderDTO;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;
use TenantCloud\TazWorksSDK\Http\Serialization\SerializerFactory;
use TenantCloud\TazWorksSDK\Searches\SearchResultType;
use Webmozart\Assert\Assert;

require __DIR__ . '/../vendor/autoload.php';

$token = getenv('TAZ_WORKS_API_TOKEN');
$clientId = '7f8feafb-745b-4ea2-b50a-98b76da39c38';

$variants = [
	[
		'product'   => 'c7e67758-6758-4820-959a-e2131d47a5bf',
		'type'      => SearchResultType::NATIONAL_CRIMINAL_DATABASE_ALIAS,
		'applicant' => UpsertApplicantDTO::testGoodResults(),
		'set'       => 'regular/good',
	],
	[
		'product'   => 'c7e67758-6758-4820-959a-e2131d47a5bf',
		'type'      => SearchResultType::NATIONAL_CRIMINAL_DATABASE_ALIAS,
		'applicant' => UpsertApplicantDTO::testBadResults(),
		'set'       => 'regular/bad',
	],

	[
		'product'   => '3fff0153-13df-40d5-a7c2-c02ed8887abf',
		'type'      => SearchResultType::COUNTY_CRIMINAL_RECORD,
		'applicant' => UpsertApplicantDTO::testGoodResults(),
		'set'       => 'current/good',
	],
	[
		'product'   => '3fff0153-13df-40d5-a7c2-c02ed8887abf',
		'type'      => SearchResultType::COUNTY_CRIMINAL_RECORD,
		'applicant' => UpsertApplicantDTO::testBadResults(),
		'set'       => 'current/bad',
	],

	[
		'product'   => '02f4d895-871e-47f7-9fec-99ed59532c60',
		'type'      => SearchResultType::COUNTY_CRIMINAL_RECORD,
		'applicant' => UpsertApplicantDTO::testGoodResults(),
		'set'       => 'all/good',
	],
	[
		'product'   => '02f4d895-871e-47f7-9fec-99ed59532c60',
		'type'      => SearchResultType::COUNTY_CRIMINAL_RECORD,
		'applicant' => UpsertApplicantDTO::testBadResults(),
		'set'       => 'all/bad',
	],
];

$client = new HttpTazWorksClient(
	baseUrl: 'https://api-sandbox.instascreen.net',
	apiToken: $token,
	serializer: SerializerFactory::make()
);
$clientApi = $client->client($clientId);

foreach ($variants as $i => $variant) {
	['product' => $clientProductId, 'type' => $type, 'applicant' => $applicantData, 'set' => $set] = $variant;

	$applicant = $clientApi->applicants()->create($applicantData);

	$order = $clientApi->orders()->submit(new SubmitOrderDTO(
		applicantGuid: $applicant->id,
		clientProductGuid: $clientProductId,
	));

	sleep(5);

	$order = $clientApi->orders()->find($order->id);

	Assert::same(OrderStatus::COMPLETE, $order->status);

	$orderSearch = Arr::first(
		$clientApi->orders()->searches()->list($order->id),
		fn (OrderSearchDTO $orderSearch) => $orderSearch->type === $type,
	);

	// Extract raw "results" key of the results JSON response
	$rawResultsResponse = (string) $client->httpClient->get("/v1/clients/{$clientId}/orders/{$order->id}/searches/{$orderSearch->id}/results")->getBody();
	$resultsResponse = json_decode($rawResultsResponse, false, 512, JSON_THROW_ON_ERROR);
	$rawResult = json_encode($resultsResponse->results, JSON_THROW_ON_ERROR);

	file_put_contents(__DIR__ . "/../resources/results/{$type->value}/{$set}.json", $rawResult);

	echo 'Downloaded ' . ($i + 1) . '/' . count($variants) . "\n";
}

echo 'Done';
