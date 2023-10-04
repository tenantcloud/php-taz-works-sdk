<?php

use Carbon\CarbonImmutable;
use TenantCloud\TazWorksSDK\Clients\Applicants\ApplicantDTO;
use TenantCloud\TazWorksSDK\Clients\Applicants\UpsertApplicantDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\SubmitOrderDTO;
use TenantCloud\TazWorksSDK\Http\HttpTazWorksClient;
use TenantCloud\TazWorksSDK\Searches\SearchResultType;

test('something works', function () {
	$client = (new HttpTazWorksClient(
		baseUrl: 'https://api-sandbox.instascreen.net',
		apiToken: '',
	));
	$clientApi = $client->client('7f8feafb-745b-4ea2-b50a-98b76da39c38');
//	$clientProductGuid = '3fff0153-13df-40d5-a7c2-c02ed8887abf'; // Background +Plus
//	$clientProductGuid = 'c7e67758-6758-4820-959a-e2131d47a5bf'; // Background
	$clientProductGuid = '02f4d895-871e-47f7-9fec-99ed59532c60'; // Essential  Background

	$applicant = $clientApi->applicants()->create(
		UpsertApplicantDTO::testGoodResults()
	);

	$applicant = $clientApi->applicants()->update(
		$applicant->id,
		UpsertApplicantDTO::testBadResults()
	);

	$order = $clientApi->orders()->submit(new SubmitOrderDTO(
		applicantGuid: $applicant->id,
		clientProductGuid: $clientProductGuid,
	));

	sleep(5);

	var_dump((string) $client->httpClient->get("v1/clients/7f8feafb-745b-4ea2-b50a-98b76da39c38/orders/{$order->id}/resultsAsPdf")->getBody());

//	foreach ($clientApi->orders()->searches()->list($order->id) as $orderSearch) {
//		var_dump(
//			$clientApi->orders()->searches()->results($order->id, $orderSearch->id)
//		);
//	}
});
