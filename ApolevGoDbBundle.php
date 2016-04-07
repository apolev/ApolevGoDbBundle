<?php

namespace Apolev\GoDbBundle;

use go\DB\DB;
use go\DB\Storage;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ApolevGoDbBundle extends Bundle
{
    public function boot()
    {
        \go\DB\autoloadRegister();

        $storage = new Storage();
        $this->container->set('apolev_godb.storage', $storage);

        $databases = $this->container->getParameter('apolev_godb');

        if ($databases) {
            foreach ($databases as $name => $parameters) {
                $db = DB::create($parameters);
                $storage->set($db, $name);

                if (!empty($parameters['_inject_to_container'])) {
                    $id = 'apolev_godb_' . $name;
                    $this->container->set($id, $db);
                }
            }
        }
    }
}
