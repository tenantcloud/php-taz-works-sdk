<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders;

use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchesApi;

interface OrdersApi
{
	public function searches(): OrderSearchesApi;

	/**
	 * @return OrderDTO[]
	 */
	public function listByApplicant(string $applicantId): array;

	public function find(string $id): OrderDTO;

	public function submit(SubmitOrderDTO $data): OrderDTO;
}
