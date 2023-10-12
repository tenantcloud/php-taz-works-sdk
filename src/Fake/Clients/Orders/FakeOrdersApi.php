<?php

namespace TenantCloud\TazWorksSDK\Fake\Clients\Orders;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Str;
use TenantCloud\TazWorksSDK\Clients\Applicants\ApplicantDTO;
use TenantCloud\TazWorksSDK\Clients\Applicants\UpsertApplicantDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderDTO;
use TenantCloud\TazWorksSDK\Clients\Orders\OrdersApi;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderStatus;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderSubmittedEvent;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchesApi;
use TenantCloud\TazWorksSDK\Clients\Orders\SubmitOrderDTO;
use TenantCloud\TazWorksSDK\Fake\Clients\Orders\Searches\FakeOrderSearchesApi;
use TenantCloud\TazWorksSDK\Fake\FakeTazWorksClient;
use TenantCloud\TazWorksSDK\NotFoundException;
use TenantCloud\TazWorksSDK\Searches\SearchResultType;

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

	public function find(string $id): OrderDTO
	{
		return $this->tazWorksClient->cache->get($this->orderKey($id)) ?? throw new NotFoundException();
	}

	public function submit(SubmitOrderDTO $data): OrderDTO
	{
		$order = new OrderDTO(
			id: Str::uuid()->toString(),
			applicantId: $data->applicantGuid,
			clientProductId: $data->clientProductGuid,
			status: OrderStatus::COMPLETE,
			externalIdentifier: $data->externalIdentifier,
		);

		$this->tazWorksClient->cache->set($this->orderKey($order), $order);

		$this->tazWorksClient->events?->dispatch(new OrderSubmittedEvent($order, $this->clientId));

		return $order;
	}

	private function orderKey(string|OrderDTO $id): string
	{
		$id = $id instanceof OrderDTO ? $id->id : $id;

		return "clients.{$this->clientId}.orders.{$id}";
	}
}
