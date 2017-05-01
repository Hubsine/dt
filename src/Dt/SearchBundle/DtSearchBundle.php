<?php

namespace Dt\SearchBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DtSearchBundle extends Bundle
{
    public function getParent() {
        return 'FOSElasticaBundle';
    }
}
