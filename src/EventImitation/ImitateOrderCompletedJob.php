<?php

namespace TenantCloud\TazWorksSDK\EventImitation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Str;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderCompletedEvent;
use TenantCloud\TazWorksSDK\Clients\Orders\Searches\OrderSearchCompletedEvent;

class ImitateOrderCompletedJob implements ShouldQueue
{
	use Queueable;

	public function __construct(private readonly string $orderId) {}

	public function handle(Dispatcher $events): void
	{
		$events->dispatch(new OrderSearchCompletedEvent(Str::uuid()->toString(), $this->orderId));
		$events->dispatch(new OrderCompletedEvent($this->orderId));
	}
}
