<?php

namespace Apolev\GoDbBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder;
        $rootNode    = $treeBuilder->root('godb');

        /** @var NodeDefinition|ArrayNodeDefinition $prototype */
        $prototype = $rootNode->prototype('array');
        $prototype->useAttributeAsKey('name');

        $connectionBuilder = $prototype->children();
        $connectionBuilder->arrayNode('_adapter')
            ->isRequired()
            ->useAttributeAsKey('name')
            ->cannotBeEmpty()
            ->info('Database adapter parameters')
        ->end();

        $connectionBuilder->scalarNode('_lazy')->defaultTrue()->cannotBeEmpty()->info('Initialize connection only when first request will be sent.')->end();
        $connectionBuilder->scalarNode('_prefix')->defaultNull()->info('Set prefix for all queries. See https://github.com/vasa-c/go-db/wiki/prefix for more details.')->end();
        $connectionBuilder->scalarNode('_debug')->defaultNull()->info('Switch to debug mode. Go to https://github.com/vasa-c/go-db/wiki/debug for more details.')->end();
        $connectionBuilder->scalarNode('_compat')->defaultFalse()->info('Switch to compatible mode. Go to https://github.com/vasa-c/go-db/wiki/Compat for more details.')->end();

        $connectionBuilder->end();
        return $treeBuilder;
    }
}
