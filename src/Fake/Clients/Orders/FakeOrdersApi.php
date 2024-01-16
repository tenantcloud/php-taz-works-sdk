<?php

namespace TenantCloud\TazWorksSDK\Fake\Clients\Orders;

use Illuminate\Support\Str;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\OrdersApi;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderStatus;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderSubmittedEvent;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchesApi;
use TenantCloud\TazWorksSDK\Clients\Orders\SubmitOrderDTO;
use TenantCloud\TazWorksSDK\Fake\Clients\Orders\Searches\FakeOrderSearchesApi;
use TenantCloud\TazWorksSDK\Fake\FakeTazWorksClient;
use TenantCloud\TazWorksSDK\NotFoundException;

class FakeOrdersApi implements OrdersApi
{
	public function __construct(
		private readonly FakeTazWorksClient $tazWorksClient,
		private readonly string $clientId,
	) {}

	public function searches(): OrderSearchesApi
	{
		return new FakeOrderSearchesApi($this->tazWorksClient, $this->clientId);
	}

	public function listByApplicant(string $applicantId): array
	{
		/** @var array<int, string> $orderIds */
		$orderIds = $this->tazWorksClient->cache->get($this->applicantOrdersKey($applicantId));

		return array_map(fn (string $id) => $this->find($id), $orderIds);
	}

	public function find(string $id): OrderDTO
	{
		/** @var OrderDTO */
		return $this->tazWorksClient->cache->get($this->orderKey($id)) ?? throw new NotFoundException();
	}

	public function submit(SubmitOrderDTO $data): OrderDTO
	{
		$order = new OrderDTO(
			id: Str::uuid()->toString(),
			status: OrderStatus::COMPLETE,
			externalIdentifier: $data->externalIdentifier,
			applicantId: $data->applicantGuid,
			clientProductId: $data->clientProductGuid,
		);

		$this->tazWorksClient->cache->set($this->orderKey($order), $order);

		/** @var string[] $ids */
		$ids = $this->tazWorksClient->cache->get($this->applicantOrdersKey($data->applicantGuid)) ?? [];
		$this->tazWorksClient->cache->set($this->applicantOrdersKey($data->applicantGuid), [...$ids, $order->id]);

		// For whatever reason, HTTP api doesn't return applicantGuid and clientProductGuid fields on submit. So we won't too.
		$order = new OrderDTO(
			id: $order->id,
			status: OrderStatus::NEW,
			externalIdentifier: $data->externalIdentifier,
		);

		$this->tazWorksClient->events?->dispatch(new OrderSubmittedEvent($order, $this->clientId));

		return $order;
	}

	private function orderKey(string|OrderDTO $id): string
	{
		$id = $id instanceof OrderDTO ? $id->id : $id;

		return "clients.{$this->clientId}.orders.{$id}";
	}

	private function applicantOrdersKey(string $applicantId): string
	{
		return "clients.{$this->clientId}.applicants.{$applicantId}.orders";
	}
}
