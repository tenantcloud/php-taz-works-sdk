<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders\Searches;

interface OrderSearchesApi
{
	/**
	 * @return OrderSearchDTO[]
	 */
	public function list(string $orderId): array;

	public function results(string $orderId, string $orderSearchId): OrderSearchWithResultsDTO;
}
