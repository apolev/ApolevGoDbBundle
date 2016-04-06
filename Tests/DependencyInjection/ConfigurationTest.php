<?php

namespace Apolev\GoDbBundle\Tests\DependencyInjection;

use Apolev\GoDbBundle\DependencyInjection\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{
    /** @var Configuration */
    private $configuration;

    public function setUp()
    {
        $this->configuration = new Configuration;
    }

    public function testBuild()
    {
        $treeBuilder = $this->configuration->getConfigTreeBuilder();
        $treeBuilder->buildTree();
    }
}
