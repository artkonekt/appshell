<?php
/**
 * Contains the AssetCollectionTest class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-11-04
 *
 */

namespace Konekt\AppShell\Tests\Unit;

use Konekt\AppShell\Assets\AssetCollection;
use PHPUnit\Framework\TestCase;

class AssetCollectionTest extends TestCase
{
    /** @test */
    public function it_can_be_created_from_an_array()
    {
        $assets = AssetCollection::createFromArray([
            'js'  => ['/jquery.js', 'https://cdn/bootstrap.js', '/app.js'],
            'css' => ['/style.css', '/bootstrap.css']
        ]);

        $scripts = $assets->scripts();
        $this->assertCount(3, $scripts);
        $this->assertEquals('/jquery.js', $scripts->first()->url());
        $this->assertEquals('https://cdn/bootstrap.js', $scripts[1]->url());
        $this->assertEquals('/app.js', $scripts->last()->url());

        $stylesheets = $assets->stylesheets();
        $this->assertCount(2, $stylesheets);
        $this->assertEquals('/style.css', $stylesheets[0]->url());
        $this->assertEquals('/bootstrap.css', $stylesheets[1]->url());
    }

    /** @test */
    public function asset_attributes_can_be_specified()
    {
        $assets = AssetCollection::createFromArray([
            'js'  => [
                '/jquery.js' => [
                    'what' => 'ever',
                    'ever' => 'else'
                ]
            ],
            'css' => ['/style.css' => [
                'integrity' => 'abcedfg'
            ]]
        ]);

        $this->assertCount(1, $assets->scripts());

        $jquery = $assets->scripts()->first();
        $this->assertEquals('/jquery.js', $jquery->url());
        $this->assertCount(2, $jquery->attributes());
        $this->assertEquals('ever', $jquery->attributes()['what']);
        $this->assertEquals('else', $jquery->attributes()['ever']);

        $this->assertCount(1, $assets->stylesheets());

        $css = $assets->stylesheets()->first();
        $this->assertEquals('/style.css', $css->url());
        $this->assertEquals('abcedfg', $css->attributes()['integrity']);
    }

    /** @test */
    public function asset_function_can_be_specified_in_config()
    {
        $assets = AssetCollection::createFromArray([
            'js'  => [
                '/jquery.js' => [
                    'what'          => 'ever',
                    'ever'          => 'else',
                    'assetFunction' => 'strtoupper'
                ]
            ],
            'css' => ['style.css' => [
                'integrity'     => 'abcedfg',
                'assetFunction' => 'ucfirst'
            ]]
        ]);

        $this->assertCount(1, $assets->scripts());

        $jquery = $assets->scripts()->first();
        $this->assertContains('src="/JQUERY.JS"', $jquery->renderHtml());
        $this->assertCount(2, $jquery->attributes());
        $this->assertEquals('ever', $jquery->attributes()['what']);
        $this->assertEquals('else', $jquery->attributes()['ever']);

        $this->assertCount(1, $assets->stylesheets());

        $css = $assets->stylesheets()->first();
        $this->assertContains('href="Style.css"', $css->renderHtml());
        $this->assertEquals('abcedfg', $css->attributes()['integrity']);
    }
}
