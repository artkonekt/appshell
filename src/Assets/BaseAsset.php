<?php
/**
 * Contains the BaseAsset abstract class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-10-30
 *
 */

namespace Konekt\AppShell\Assets;

use Illuminate\Support\Collection;
use Konekt\AppShell\Contracts\Asset;

abstract class BaseAsset implements Asset
{
    /** @var string */
    protected $url;

    /** @var array */
    protected $attributes;

    /** @var array */
    protected $defaultAttributes = [];

    /** @var bool Whether the asset tag should be rendered as self closing: <link /> vs. non self closing: <script></script>  */
    protected $selfClosing = true;

    /** @var string */
    protected $urlAttribute = '';

    /** @var string */
    protected $tag = '';

    protected $assetFunction;

    public function __construct(string $url, array $attributes = [], $assetFunction = 'asset')
    {
        $this->url           = $url;
        $this->attributes    = collect($attributes);
        $this->assetFunction = $assetFunction;
    }

    public function url(): string
    {
        return $this->url;
    }

    public function tag(): string
    {
        return $this->tag;
    }

    public function attributes(): Collection
    {
        return $this->attributes;
    }

    public function renderHtml(): string
    {
        $template = $this->selfClosing ? '<%1$s %2$s="%3$s"%4$s />' : '<%1$s %2$s="%3$s"%4$s></%1$s>';

        return sprintf($template,
            $this->tag(),
            $this->urlAttribute,
            $this->asset($this->url()),
            $this->attributesSpread()->reduce(function ($result, $attr) {
                return $result .= sprintf(' %s="%s"', $attr['attr'], $attr['value']);
            }, '')
        );
    }

    protected function attributesSpread(): Collection
    {
        return collect($this->defaultAttributes)
            ->merge($this->attributes())
            ->transform(function ($item, $key) {
                return [
                    'attr'  => $key,
                    'value' => $item
                ];
            });
    }

    protected function asset(string $url)
    {
        return call_user_func($this->assetFunction, $url);
    }
}
