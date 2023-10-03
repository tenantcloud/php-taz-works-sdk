<?php

use Crell\Serde\Attributes\ClassSettings;

test('app')
	->expect('TenantCloud\TazWorksSDK\Searches\Results')
	->toBeFinal()
//	->toBeReadonly()
	->toExtendNothing()
	->toHaveAttribute(ClassSettings::class);
