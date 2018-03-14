<?php
/**
 * Contains the BaseSlice class.
 *
 * @copyright   Copyright (c) 2018 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2018-03-14
 *
 */


namespace Konekt\AppShell\Settings;

/**
 * Common base class for settings groups and tabs
 */
abstract class BaseSlice
{
    /** @var string */
    protected $id;

    /** @var string */
    protected $label;

    /** @var int */
    protected $order;

    /** @var \Illuminate\Support\Collection */
    protected $children;

    public function __construct(string $id, string $label, int $order = null)
    {
        $this->id       = $id;
        $this->label    = $label;
        $this->order    = $order;
        $this->children = collect();
    }

    /**
     * @inheritDoc
     */
    public function id(): string
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function label(): string
    {
        return $this->label;
    }

    /**
     * @inheritDoc
     */
    public function order()
    {
        return $this->order;
    }

    public function __toString()
    {
        return $this->label();
    }

    /**
     * @inheritDoc
     */
    abstract public function allowed(): bool;

    /**
     * @inheritDoc
     */
    abstract public function permission();
}
