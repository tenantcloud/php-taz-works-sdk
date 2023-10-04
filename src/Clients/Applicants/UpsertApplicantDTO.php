<?php

namespace TenantCloud\TazWorksSDK\Clients\Applicants;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Crell\Serde\Attributes\DateField;
use Crell\Serde\Attributes\Field;
use TenantCloud\TazWorksSDK\TazAssert;
use Webmozart\Assert\Assert;

class UpsertApplicantDTO
{
	#[Field(serializedName: 'applicantGuid')]
	public ?string $id = null;

	public readonly bool $noMiddleName;

	public function __construct(
		public readonly string              $firstName,
		public readonly ?string              $middleName,
		public readonly string              $lastName,
		public readonly string              $email,
		public readonly ?string             $ssn = null,
		#[DateField(format: 'Y-m-d')]
		public readonly ?\DateTimeImmutable $dateOfBirth = null,
	)
	{
		if ($ssn) {
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
