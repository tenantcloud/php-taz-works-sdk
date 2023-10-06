<?php

namespace TenantCloud\TazWorksSDK\EventImitation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderCompletedEvent;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderStatus;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchCompletedEvent;
use TenantCloud\TazWorksSDK\TazWorksClient;

class ImitateOrderCompletedJob implements ShouldQueue
{
	use Queueable;

	public function __construct(
		private readonly string $clientId,
		private readonly string $orderId,
	) {}

	public function handle(TazWorksClient $tazWorks, Dispatcher $events): void
	{
		$order = $tazWorks
			->client($this->clientId)
			->orders()
			->find($this->orderId);

		if ($order->status->partiallyComplete() || $order->status === OrderStatus::COMPLETE) {
			$events->dispatch(new OrderSearchCompletedEvent(Str::uuid()->toString(), $this->orderId));
		}

		if ($order->status === OrderStatus::COMPLETE) {
			$events->dispatch(new OrderCompletedEvent($this->orderId));
		}
	}
}
