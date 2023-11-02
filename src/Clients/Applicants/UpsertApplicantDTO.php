<?php

namespace TenantCloud\TazWorksSDK\Clients\Applicants;

use Carbon\CarbonImmutable;
use GoodPhp\Serialization\TypeAdapter\Primitive\BuiltIn\Date;
use GoodPhp\Serialization\TypeAdapter\Primitive\ClassProperties\Naming\SerializedName;
use TenantCloud\TazWorksSDK\TazAssert;

class UpsertApplicantDTO
{
	#[SerializedName('applicantGuid')]
	public ?string $id = null;

	public readonly bool $noMiddleName;

	public function __construct(
		public readonly string $firstName,
		public readonly ?string $middleName,
		public readonly string $lastName,
		public readonly string $email,
		public readonly ?string $ssn = null,
		#[Date(format: 'Y-m-d')]
		public readonly ?CarbonImmutable $dateOfBirth = null,
	) {
		if ($this->ssn) {
			TazAssert::ssn($this->ssn);
		}

		$this->noMiddleName = $this->middleName === null;
	}

	/**
	 * @see https://docs.developer.tazworks.com/#test-applicants
	 */
	public static function testGoodResults(): self
	{
		return new self(
			firstName: 'Joe',
			middleName: null,
			lastName: 'Clean',
			email: 'o.prypkhan@tenantcloud.com',
			ssn: '111-22-3333',
			dateOfBirth: CarbonImmutable::parse('1990-01-01'),
		);
	}

	/**
	 * @see https://docs.developer.tazworks.com/#test-applicants
	 */
	public static function testBadResults(): self
	{
		return new self(
			firstName: 'Hank',
			middleName: null,
			lastName: 'Mess',
			email: 'o.prypkhan@tenantcloud.com',
			ssn: '333-22-1111',
			dateOfBirth: CarbonImmutable::parse('1990-01-01'),
		);
	}
}
