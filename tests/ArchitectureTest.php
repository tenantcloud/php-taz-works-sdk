<?php

test('app')
	->expect('TenantCloud\TazWorksSDK\Searches\Results')
	->toBeFinal()
//	->toBeReadonly()
	->toExtendNothing();
