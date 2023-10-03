<?php

namespace TenantCloud\TazWorksSDK\Clients\Orders;

enum OrderStatus : string
{
	case APP_PENDING = 'app-pending';
	case APP_READY = 'app-ready';
	case CANCELED = 'canceled';
	case CLIENT_MESSAGE = 'client message';
	case COMPLETE = 'complete';
	case DISPATCHED_QC = 'dispatched qc';
	case DRAFT = 'draft';
	case END_USER = 'end-user';
	case INTERNAL_ERROR = 'internal-error';
	case NEW = 'new';
	case PENDING = 'pending';
	case PENDING_REVIEW = 'pending review';
	case PRE_PULL = 'pre-pull';
	case QA_REVIEW = 'qa review';
	case ARCHIVED = 'archived';
}
