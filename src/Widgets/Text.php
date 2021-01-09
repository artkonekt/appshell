<?php

declare(strict_types=1);

/**
 * Contains the Text class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-01-09
 *
 */

namespace Konekt\AppShell\Widgets;

use Konekt\AppShell\Contracts\Theme;
use Konekt\AppShell\Contracts\Widget;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Traits\ResolvesSubstitutions;

class Text implements Widget
{
    use RendersThemedWidget;
    use ResolvesSubstitutions;

    protected static $allowedTagAttributes = [
        'class',
        'style',
        'title'
    ];

    /** @var callable */
    private $text;

    private ?string $wrap;

    private array $tagAttributes = [];

    public function __construct(Theme $theme, callable $text, ?string $wrap = null)
    {
        $this->theme = $theme;
        $this->text = $text;
        $this->wrap = $wrap;
    }

    public static function create(Theme $theme, array $options = []): Text
    {
        $text = self::makeCallable($options['text'] ?? null);
        $instance = new static($theme, $text, $options['wrap'] ?? null);

        foreach (self::$allowedTagAttributes as $allowedTagAttribute) {
            if (isset($options[$allowedTagAttribute])) {
                $instance->tagAttributes[$allowedTagAttribute] = $options[$allowedTagAttribute];
            }
        }

        return $instance;
    }

    public function render($data = null): string
    {
        $text = $this->text;

        return $this->renderViewFromTheme('text', [
            'text' => $text($data, $this),
            'wrap' => $this->wrap,
            'tagAttributes' => $this->tagAttributes,
        ]);
    }
}
