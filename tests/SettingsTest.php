<?php
/**
 * Contains the SettingsTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-05-27
 *
 */

namespace Konekt\AppShell\Tests;

use Konekt\AppShell\Contracts\SettingsTree;
use Konekt\Gears\UI\Node;
use Konekt\Gears\UI\Tree;

class SettingsTest extends TestCase
{
    /**
     * @test
     */
    public function it_returns_the_settings_tree_by_interface()
    {
        $tree = app(SettingsTree::class);

        $this->assertInstanceOf(Tree::class, $tree);
    }

    /**
     * @test
     */
    public function the_tree_contains_the_general_group_and_the_appname_setting_within()
    {
        /** @var Tree $tree */
        $tree = app(SettingsTree::class);

        $this->assertArrayHasKey('general', $tree->nodes());
        $generalTab = $tree->findNode('general');
        $this->assertInstanceOf(Node::class, $generalTab);

        $appGroup = $generalTab->getChild('general_app');
        $this->assertInstanceOf(Node::class, $appGroup);

        $this->assertEquals('appshell.ui.name', $appGroup->items()[0]->getSetting()->key());
    }
}
