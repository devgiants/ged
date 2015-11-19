<?php

namespace devgiants\ged\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class devGiantsGedUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
