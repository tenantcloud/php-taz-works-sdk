<?php

namespace TenantCloud\TazWorksSDK\EventImitation;

use Carbon\CarbonInterval;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Queue\SyncQueue;
use Psr\EventDispatcher\EventDispatcherInterface;
use Illuminate\Contracts\Queue\Factory as QueueConnectionFactory;
use TenantCloud\TazWorksSDK\Clients\Orders\OrderSubmittedEvent;

class EventImitatingEventDispatcher implements EventDispatcherInterface
{
	public function __construct(
		private readonly Dispatcher $bus,
		private readonly QueueConnectionFactory $queueConnectionFactory,
	)
	{
	}

	public function dispatch(object $event)
	{
		if ($event instanceof OrderSubmittedEvent) {
			// Imitate events when imitation is enabled and queue supports delayed jobs, otherwise it doesn't make sense.
			// ... welcome to Laravel - a world of inconsistent behaviour. Sync queue doesn't do delays :/
			if ($this->queueConnectionFactory->connection() instanceof SyncQueue) {
				sleep(5);
			}

			$this->bus->dispatch(
				(new ImitateOrderCompletedJob($event->order->id, $event->clientId))
					->delay(CarbonInterval::seconds(5))
					->afterCommit()
			);
		}
	}
}
