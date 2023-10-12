<?php

use TenantCloud\TazWorksSDK\Searches\SearchResultType;

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

	'fake' => [
		'enabled' => env('TAZ_WORKS_FAKE_CLIENT', false),

		'clients' => [
			'7f8feafb-745b-4ea2-b50a-98b76da39c38' => [
				'products' => [
					'c7e67758-6758-4820-959a-e2131d47a5bf' => [
						'searches' => [
							[
								'type' => SearchResultType::NATIONAL_CRIMINAL_DATABASE_ALIAS,
								'display_name' => 'National Criminal, SSN Trace, Global Terrorist\/Government Sanctions search, OIG, OFAC, Lifetime address history, National Sex of',
								'set' => 'regular',
							],
						]
					],

					'3fff0153-13df-40d5-a7c2-c02ed8887abf' => [
						'searches' => [
							[
								'type' => SearchResultType::NATIONAL_CRIMINAL_DATABASE_ALIAS,
								'display_name' => 'National Crim, SSN Trace, OIG, OFAC, Lifetime Address, SSN Trace, Name Alias, Government sanctions\/ Terrorist Watch list, Curren',
								'set' => 'regular',
							],
							[
								'type' => SearchResultType::COUNTY_CRIMINAL_RECORD,
								'display_name' => 'County of Current',
								'set' => 'current',
							],
						]
					],

					'02f4d895-871e-47f7-9fec-99ed59532c60' => [
						'searches' => [
							[
								'type' => SearchResultType::NATIONAL_CRIMINAL_DATABASE_ALIAS,
								'display_name' => 'National Criminal, SSN Trace, Name Alias, OIG, OFAC, Terrorist Watch List, Government Sanctions, Sex offender, Address History',
								'set' => 'regular',
							],
							[
								'type' => SearchResultType::COUNTY_CRIMINAL_RECORD,
								'display_name' => '7 year Unlimited County Search',
								'set' => 'all',
							],
						]
					],
				],
			],
		],
	],
];
