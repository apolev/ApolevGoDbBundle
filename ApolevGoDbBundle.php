<?php

namespace Apolev\GoDbBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApolevGoDbBundle extends Bundle
{
    public function boot()
    {
        \go\DB\autoloadRegister();
    }
}
