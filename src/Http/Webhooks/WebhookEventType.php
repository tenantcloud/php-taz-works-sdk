<?php

namespace TenantCloud\TazWorksSDK\Http\Webhooks;

enum WebhookEventType: string
{
	case ORDER_COMPLETED = 'order.completed';
	case ORDER_CREATED = 'order.created';
	case ORDER_CANCELED = 'order.canceled';
	case ORDER_SEARCH_COMPLETED = 'order.search.completed';
	case ORDER_SEARCH_CREATED = 'order.search.created';
	case CLIENT_UPDATED = 'client.updated';
	case CLIENT_CREATED = 'client.created';
	case CLIENT_DELETED = 'client.deleted';
}
