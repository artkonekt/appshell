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
        $this->assertContains('href="/style.css"', $html);
    }

    /** @test */
    public function stylesheet_with_attributes_renders_properly()
    {
        $css = new Stylesheet('/style.css', ['crossorigin' => 'anonymous'], 'strtolower');

        $html = $css->renderHtml();

        $this->assertStringStartsWith('<link ', $html);
        $this->assertStringEndsWith(' />', $html);
        $this->assertContains('href="/style.css"', $html);
        $this->assertContains('crossorigin="anonymous"', $html);
    }

    /** @test */
    public function script_without_attributes_renders_properly()
    {
        $js = new Script('js/appshell.js', [], 'strtolower');

        $html = $js->renderHtml();

        $this->assertStringStartsWith('<script ', $html);
        $this->assertStringEndsWith('</script>', $html);
        $this->assertContains('src="js/appshell.js"', $html);
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
        $this->assertContains('src="//cdn.example.com/js/chunk-vendors.725265d6.js"', $html);
        $this->assertContains('crossorigin="anonymous"', $html);
        $this->assertContains('integrity="sha384-oqVuAfXRKap7fdgcCY5uykM6+R9GqQ8K/uxy9rx7HNQlGYl1kPzQho1wx4JwY8wC"', $html);
    }

    /** @test */
    public function script_with_custom_attribute_function_transforms_the_url()
    {
        $js = new Script('/app.js', [], 'strtoupper');

        $html = $js->renderHtml();

        $this->assertStringStartsWith('<script ', $html);
        $this->assertStringEndsWith('</script>', $html);
        $this->assertContains('src="/APP.JS"', $html);
    }
}
