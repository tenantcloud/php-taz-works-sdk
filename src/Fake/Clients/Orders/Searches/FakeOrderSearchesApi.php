<?php

namespace TenantCloud\TazWorksSDK\Fake\Clients\Orders\Searches;

use GoodPhp\Serialization\TypeAdapter\Json\JsonTypeAdapter;
use Illuminate\Support\Str;
use InvalidArgumentException;
use TenantCloud\TazWorksSDK\Clients\Applicants\UpsertApplicantDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchesApi;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchStatus;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchWithResultsDTO;
use TenantCloud\TazWorksSDK\Fake\FakeTazWorksClient;
use TenantCloud\TazWorksSDK\NotFoundException;
use TenantCloud\TazWorksSDK\Searches\Results\CriminalResult;
use TenantCloud\TazWorksSDK\Searches\Results\NationalCriminalDatabaseAlias\NationalCriminalResult;
use Webmozart\Assert\Assert;

/**
 * @phpstan-type CacheOrderSearch array{ search: OrderSearchDTO, set: string }
 */
class FakeOrderSearchesApi implements OrderSearchesApi
{
	public function __construct(
		private readonly FakeTazWorksClient $tazWorksClient,
		private readonly string $clientId,
	) {}

	public function find(string $orderId, string $orderSearchId): OrderSearchDTO
	{
		/** @var CacheOrderSearch $data */
		$data = $this->tazWorksClient->cache->get($this->orderSearchKey($orderId, $orderSearchId)) ?? throw new NotFoundException();

		return $data['search'];
	}

	public function list(string $orderId): array
	{
		$this->upsertOrderSearches($orderId);

		/** @var string[] $searchIds */
		$searchIds = $this->tazWorksClient->cache->get($this->orderSearchesKey($orderId));

		return array_map(fn (string $id) => $this->find($orderId, $id), $searchIds);
	}

	public function results(string $orderId, string $orderSearchId): OrderSearchWithResultsDTO
	{
		$this->upsertOrderSearches($orderId);

		/** @var CacheOrderSearch $data */
		$data = $this->tazWorksClient->cache->get($this->orderSearchKey($orderId, $orderSearchId)) ?? throw new NotFoundException();

		return new OrderSearchWithResultsDTO(
			search: $data['search'],
			results: $this->searchData($data['search'], $data['set'])
		);
	}

	private function searchData(OrderSearchDTO $orderSearch, string $set): CriminalResult|NationalCriminalResult
	{
		$raw = file_get_contents(__DIR__ . "/../../../../../resources/results/{$orderSearch->type->value}/{$set}.json");

		if ($raw === false) {
			throw new InvalidArgumentException("Fake report results '{$set}' not found");
		}

		/** @var CriminalResult|NationalCriminalResult */
		return $this->tazWorksClient
			->serializer
			->adapter(JsonTypeAdapter::class, $orderSearch->type->className())
			->deserialize($raw);
	}

	private function upsertOrderSearches(string $orderId): void
	{
		if ($this->tazWorksClient->cache->has($this->orderSearchesKey($orderId))) {
			return;
		}

		$order = $this->tazWorksClient
			->client($this->clientId)
			->orders()
			->find($orderId);

		Assert::string($order->applicantId);
		Assert::string($order->clientProductId);

		$applicant = $this->tazWorksClient
			->client($this->clientId)
			->applicants()
			->find($order->applicantId);

		Assert::keyExists($this->tazWorksClient->clients, $this->clientId);
		Assert::keyExists($this->tazWorksClient->clients[$this->clientId]['products'], $order->clientProductId);

		$productSearches = $this->tazWorksClient->clients[$this->clientId]['products'][$order->clientProductId]['searches'];

		$searchIds = [];

		foreach ($productSearches as $search) {
			$set = $search['set'];
			$subSet = $applicant->ssn === UpsertApplicantDTO::testBadResults()->ssn ? 'bad' : 'good';

			$orderSearch = new OrderSearchDTO(
				id: Str::uuid()->toString(),
				type: $search['type'],
				displayName: $search['display_name'],
				status: OrderSearchStatus::COMPLETE,
			);
			$searchIds[] = $orderSearch->id;

			$this->tazWorksClient->cache->set($this->orderSearchKey($orderId, $orderSearch), [
				'search' => $orderSearch,
				'set'    => "{$set}/{$subSet}",
			]);
		}

		$this->tazWorksClient->cache->set($this->orderSearchesKey($orderId), $searchIds);
	}

	private function orderSearchKey(string $orderId, string|OrderSearchDTO $id): string
	{
		$id = $id instanceof OrderSearchDTO ? $id->id : $id;

		return $this->orderSearchesKey($orderId) . ".{$id}";
	}

	private function orderSearchesKey(string $orderId): string
	{
		return "clients.{$this->clientId}.orders.{$orderId}.searches";
	}
}
