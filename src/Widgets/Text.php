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
use Konekt\AppShell\WidgetModifiers;

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

    /** @var null|string|callable */
    private $modifier = null;

    private ?string $wrap;

    private array $tagAttributes = [];

    private bool $bold = false;

    private string $prefix = '';

    private string $suffix = '';

    public function __construct(Theme $theme, callable $text, ?string $wrap = null)
    {
        $this->theme = $theme;
        $this->text = $text;
        $this->wrap = $wrap;
    }

    public static function create(Theme $theme, array $options = []): Text
    {
        $text = self::makeCallable($options['text'] ?? '$model');
        $instance = new static($theme, $text, $options['wrap'] ?? null);

        if (isset($options['modifier'])) {
            $instance->setModifier($options['modifier']);
        }

        if (isset($options['bold'])) {
            $instance->bold = (bool) $options['bold'];
            if ($instance->bold && null === $instance->wrap) {
                $instance->wrap = 'span';
            }
        }

        if (isset($options['prefix'])) {
            $instance->prefix = (string) $options['prefix'];
        }

        if (isset($options['suffix'])) {
            $instance->suffix = (string) $options['suffix'];
        }

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
            'text' => $this->modify($text($data, $this)),
            'wrap' => $this->wrap,
            'tagAttributes' => $this->tagAttributes,
            'bold' => $this->bold,
            'prefix' => $this->prefix,
            'suffix' => $this->suffix,
        ]);
    }

    public function setModifier($modifier): void
    {
        $this->modifier = $modifier;
    }

    protected function modify($text): string
    {
        if (null === $this->modifier) {
            return (string) $text;
        }

        if (is_string($this->modifier) && WidgetModifiers::exists($this->modifier)) {
            return WidgetModifiers::make($this->modifier)->handle($text);
        }

        return (string) call_user_func($this->modifier, $text);
    }
}
