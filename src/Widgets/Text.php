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
use Konekt\AppShell\Theme\ThemeColor;
use Konekt\AppShell\Traits\RendersThemedWidget;
use Konekt\AppShell\Traits\ResolvesSubstitutions;
use Konekt\AppShell\Widgets\Concerns\CalculatesContextualColors;
use Konekt\AppShell\Widgets\Concerns\HasModifier;
use Konekt\AppShell\Widgets\Concerns\SupportsConditionalRendering;

class Text implements Widget
{
    use CalculatesContextualColors;
    use RendersThemedWidget;
    use ResolvesSubstitutions;
    use SupportsConditionalRendering;
    use HasModifier;

    protected const DEFAULT_WRAP = 'span';

    protected static $allowedTagAttributes = [
        'class',
        'style',
        'title'
    ];

    /** @var callable */
    private $text;

    private ?string $wrap;

    private array $tagAttributes = [];

    private bool $bold = false;

    private string $prefix = '';

    private string $suffix = '';

    private null|array|string $colorDef = null;

    private ?string $hexColor = null;

    private ?string $themeColor = null;

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
                $instance->wrap = self::DEFAULT_WRAP;
            }
        }

        if (isset($options['prefix'])) {
            $instance->prefix = (string) $options['prefix'];
        }

        if (isset($options['suffix'])) {
            $instance->suffix = (string) $options['suffix'];
        }

        $instance->colorDef = $options['color'] ?? null;

        foreach (self::$allowedTagAttributes as $allowedTagAttribute) {
            if (isset($options[$allowedTagAttribute])) {
                $instance->tagAttributes[$allowedTagAttribute] = $options[$allowedTagAttribute];
            }
        }

        $instance->processRenderingConditions($options);

        return $instance;
    }

    public function render($data = null): string
    {
        if ($this->shouldNotRender($data)) {
            return '';
        }

        $text = $this->text;

        $color = $this->parseColorDefinition(
            is_string($this->colorDef) ? $this->resolveSubstitutions($this->colorDef, $data) : $this->colorDef,
            $data,
            ThemeColor::NONE,
            true,
        );

        if (null !== $color->style) {
            $this->tagAttributes['style'] = ($this->tagAttributes['style'] ?? '') . $color->style;
        }

        if ($color->isNotEmpty() && null === $this->wrap) {
            $this->wrap = self::DEFAULT_WRAP;
        }

        return $this->renderViewFromTheme('text', [
            'text' => $this->modify($text($data, $this)),
            'wrap' => $this->wrap,
            'tagAttributes' => $this->tagAttributes,
            'color' => $color,
            'bold' => $this->bold,
            'prefix' => $this->resolveSubstitutions($this->prefix, $data),
            'suffix' => $this->resolveSubstitutions($this->suffix, $data),
        ]);
    }
}
