<?php
/**
 * Contains the AssetTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-10-30
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Assets\Script;
use Konekt\AppShell\Assets\Stylesheet;
use PHPUnit\Framework\TestCase;

class AssetTest extends TestCase
{
    /** @test */
    public function stylesheet_without_attributes_renders_properly()
    {
        $css = new Stylesheet('/style.css', [], 'strtolower');

        $html = $css->renderHtml();

        $this->assertStringStartsWith('<link ', $html);
        $this->assertStringEndsWith(' />', $html);
        $this->assertStringContainsString('href="/style.css"', $html);
    }

    /** @test */
    public function stylesheet_with_attributes_renders_properly()
    {
        $css = new Stylesheet('/style.css', ['crossorigin' => 'anonymous'], 'strtolower');

        $html = $css->renderHtml();

        $this->assertStringStartsWith('<link ', $html);
        $this->assertStringEndsWith(' />', $html);
        $this->assertStringContainsString('href="/style.css"', $html);
        $this->assertStringContainsString('crossorigin="anonymous"', $html);
    }

    /** @test */
    public function script_without_attributes_renders_properly()
    {
        $js = new Script('js/appshell.js', [], 'strtolower');

        $html = $js->renderHtml();

        $this->assertStringStartsWith('<script ', $html);
        $this->assertStringEndsWith('</script>', $html);
        $this->assertStringContainsString('src="js/appshell.js"', $html);
    }

    /** @test */
    public function script_with_attributes_renders_properly()
    {
        $js = new Script('//cdn.example.com/js/chunk-vendors.725265d6.js', [
            'crossorigin' => 'anonymous',
            'integrity'   => 'sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC'
        ], 'strtolower');

        $html = $js->renderHtml();

        $this->assertStringStartsWith('<script ', $html);
        $this->assertStringEndsWith('</script>', $html);
        $this->assertStringContainsString('src="//cdn.example.com/js/chunk-vendors.725265d6.js"', $html);
        $this->assertStringContainsString('crossorigin="anonymous"', $html);
        $this->assertStringContainsString('integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"', $html);
    }

    /** @test */
    public function script_with_custom_attribute_function_transforms_the_url()
    {
        $js = new Script('/app.js', [], 'strtoupper');

        $html = $js->renderHtml();

        $this->assertStringStartsWith('<script ', $html);
        $this->assertStringEndsWith('</script>', $html);
        $this->assertStringContainsString('src="/APP.JS"', $html);
    }

    /** @test */
    public function metadata_can_be_added_via_constructor()
    {
        $js = new Script('some.js', [], 'asset', [
            'location' => 'header',
            'haveidea' => 'idont'
        ]);

        $this->assertEquals('header', $js->getMetaValue('location'));
        $this->assertEquals('idont', $js->getMetaValue('haveidea'));
        $this->assertCount(2, $js->metadata());
        $this->assertArrayHasKey('location', $js->metadata()->toArray());
        $this->assertArrayHasKey('haveidea', $js->metadata()->toArray());
    }

    /** @test */
    public function metadata_can_be_added_after_object_was_created()
    {
        $js = new Script('app.js');

        $this->assertCount(0, $js->metadata());

        $js->addMetaValue('some', 'value');
        $this->assertCount(1, $js->metadata());
        $this->assertEquals('value', $js->getMetaValue('some'));

        $js->addMetaValue('other', 'thing');
        $this->assertCount(2, $js->metadata());
        $this->assertEquals('thing', $js->getMetaValue('other'));
    }
}
