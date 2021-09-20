<?php

declare(strict_types=1);

/**
 * Contains the PartialMatchTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Tests\Unit\Filters;

use Konekt\AppShell\Filters\Generic\PartialMatch;
use Konekt\AppShell\Filters\PartialMatchPattern;
use Konekt\AppShell\Models\User;
use Konekt\AppShell\Tests\TestCase;

class PartialMatchTest extends TestCase
{
    /** @test */
    public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(PartialMatch::class, new PartialMatch('email'));
    }

    /** @test */
    public function id_can_be_assigned()
    {
        $filter = new PartialMatch('email');
        $this->assertEquals('email', $filter->id());
    }

    /** @test */
    public function the_possible_values_field_is_nullable()
    {
        $filter = new PartialMatch('email');
        $this->assertNull($filter->possibleValues());
    }

    /** @test */
    public function the_label_defaults_to_the_id_if_unspecified()
    {
        $filter = new PartialMatch('subject');

        $this->assertEquals('subject', $filter->label());
    }

    /** @test */
    public function the_label_can_be_specified()
    {
        $filter = new PartialMatch('subject', 'Subject');

        $this->assertEquals('Subject', $filter->label());
    }

    /** @test */
    public function the_placeholder_is_null_by_default()
    {
        $filter = new PartialMatch('description');

        $this->assertNull($filter->placeholder());
    }

    /** @test */
    public function the_placeholder_can_be_specified()
    {
        $filter = new PartialMatch('description');
        $filter->setPlaceholder('Description contains');

        $this->assertEquals('Description contains', $filter->placeholder());
    }

    /** @test */
    public function it_does_not_allow_multiple_values()
    {
        $this->assertFalse((new PartialMatch('title'))->allowsMultipleValues());
    }

    /** @test */
    public function it_can_be_applied_to_a_query_builder_instance()
    {
        $query = User::query();
        $filter = new PartialMatch('name');

        $filter->apply($query, 'Gatto');

        $whereClause = $query->getQuery()->wheres[0];
        $this->assertEquals('name', $whereClause['column']);
        $this->assertEquals('Basic', $whereClause['type']);
        $this->assertEquals('like', $whereClause['operator']);
        $this->assertEquals('Gatto%', $whereClause['value']);
    }

    /** @test */
    public function matching_pattern_can_be_specified()
    {
        $filter = new PartialMatch('name');

        $filter->matchingPattern(PartialMatchPattern::BEGINS_WITH());
        $beginsWithQuery = $filter->apply(User::query(), 'Gatto');
        $this->assertEquals('Gatto%', $beginsWithQuery->getQuery()->wheres[0]['value']);

        $filter->matchingPattern(PartialMatchPattern::ENDS_WITH());
        $endsWithQuery = $filter->apply(User::query(), 'Gatto');
        $this->assertEquals('%Gatto', $endsWithQuery->getQuery()->wheres[0]['value']);

        $filter->matchingPattern(PartialMatchPattern::ANYWHERE());
        $anywhereQuery = $filter->apply(User::query(), 'Gatto');
        $this->assertEquals('%Gatto%', $anywhereQuery->getQuery()->wheres[0]['value']);
    }
}
