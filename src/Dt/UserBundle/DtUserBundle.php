<?php

namespace Dt\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DtUserBundle extends Bundle
{
    public function getParent() {
        return 'FOSUserBundle';
    }
}
