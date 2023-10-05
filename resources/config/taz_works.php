<?php

return [
	'base_url' => env('TAZ_WORKS_BASE_URL', 'https://api-sandbox.instascreen.net'),
	'api_token' => env('TAZ_WORKS_API_TOKEN', ''),

	'clients' => [
		'test' => [
			'id' => '12341234-1234-1234-1234-123412341234',
			'products' => [

			],
		]
	],

	'webhooks' => [
		'authorization' => env('TAZ_WORKS_WEBHOOKS_AUTHORIZATION', 'test'),

		'prefix' => 'webhooks/taz_works',

		'imitate' => env('TAZ_WORKS_IMITATE_EVENTS', true),
	],
];
