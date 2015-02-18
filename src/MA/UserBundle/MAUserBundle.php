<?php

namespace MA\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MAUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
