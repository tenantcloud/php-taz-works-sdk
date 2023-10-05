<?php

namespace TenantCloud\TazWorksSDK\EventImitation;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderCompletedEvent;

class ImitateOrderCompletedJob implements ShouldQueue
{
	use Queueable;

	public function __construct(private readonly int $orderId) {}

	public function handle(Dispatcher $events): void
	{
		$events->dispatch(new OrderCompletedEvent($this->orderId));
	}
}
