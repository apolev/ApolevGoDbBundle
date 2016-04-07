<?php

namespace Apolev\GoDbBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder;
        $rootNode    = $treeBuilder->root('apolev_godb');
        $rootNode->useAttributeAsKey('name');

        /** @var NodeDefinition|ArrayNodeDefinition $prototype */
        $prototype = $rootNode->prototype('array');


        $connectionBuilder = $prototype->children();
        $connectionBuilder->enumNode('_adapter')
            ->isRequired()
            ->values(['pgsql', 'mysql', 'mysqlold', 'pgsql', 'sqlite'])
            ->cannotBeEmpty()
            ->info('Database adapter')
        ->end();

        $this->addDbParameters($connectionBuilder);

        $connectionBuilder->scalarNode('_lazy')->defaultTrue()->cannotBeEmpty()->info('Initialize connection only when first request will be sent.')->end();
        $connectionBuilder->scalarNode('_prefix')->defaultNull()->info('Set prefix for all queries. See https://github.com/vasa-c/go-db/wiki/prefix for more details.')->end();
        $connectionBuilder->scalarNode('_debug')->defaultNull()->info('Switch to debug mode. Go to https://github.com/vasa-c/go-db/wiki/debug for more details.')->end();
        $connectionBuilder->scalarNode('_compat')->defaultFalse()->info('Switch to compatible mode. Go to https://github.com/vasa-c/go-db/wiki/Compat for more details.')->end();

        $connectionBuilder->end();

        return $treeBuilder;
    }

    private function addDbParameters(NodeBuilder $builder)
    {
        $parameters = [
            'host', 'username', 'password', 'dbname', 'port', 'socket',
            'charset', 'options', 'hostaddr', 'connection_timeout', 'sslmode',
            'service'
        ];

        foreach ($parameters as $parameter) {
            $builder->scalarNode($parameter)->defaultNull()->end();
        }
    }
}
