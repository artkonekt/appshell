<?php

declare(strict_types=1);

/**
 * Contains the ExactMatchTest class.
 *
 * @copyright   Copyright (c) 2021 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2021-09-18
 *
 */

namespace Konekt\AppShell\Tests\Unit\Filters;

use Konekt\AppShell\Filters\Generic\ExactMatch;
use Konekt\AppShell\Models\User;
use Konekt\AppShell\Tests\TestCase;
use Konekt\User\Models\UserType;
use PHPUnit\Framework\Attributes\Test;

class ExactMatchTest extends TestCase
{
    #[Test] public function it_can_be_instantiated()
    {
        $this->assertInstanceOf(ExactMatch::class, new ExactMatch('yo'));
    }

    #[Test] public function id_can_be_assigned()
    {
        $filter = new ExactMatch('yo');
        $this->assertEquals('yo', $filter->id());
    }

    #[Test] public function the_possible_values_field_is_nullable()
    {
        $filter = new ExactMatch('yo');
        $this->assertNull($filter->possibleValues());
    }

    #[Test] public function possible_values_can_be_specified()
    {
        $filter = new ExactMatch('yo', null, ['hey', 'ho']);
        $this->assertEquals(['hey', 'ho'], $filter->possibleValues());
    }

    #[Test] public function the_label_defaults_to_the_id_if_unspecified()
    {
        $filter = new ExactMatch('is_active');

        $this->assertEquals('is_active', $filter->label());
    }

    #[Test] public function the_label_can_be_specified()
    {
        $filter = new ExactMatch('is_active', 'Active Status');

        $this->assertEquals('Active Status', $filter->label());
    }

    #[Test] public function the_placeholder_is_null_by_default()
    {
        $filter = new ExactMatch('status');

        $this->assertNull($filter->placeholder());
    }

    #[Test] public function the_placeholder_can_be_specified()
    {
        $filter = new ExactMatch('status');
        $filter->setPlaceholder('Select Status');

        $this->assertEquals('Select Status', $filter->placeholder());
    }

    #[Test] public function it_does_not_allow_multiple_values()
    {
        $this->assertFalse((new ExactMatch('project_id'))->allowsMultipleValues());
    }

    #[Test] public function it_can_be_applied_to_a_query_builder_instance()
    {
        $query = User::query();
        $filter = new ExactMatch('type');

        $filter->apply($query, UserType::ADMIN);

        $whereClause = $query->getQuery()->wheres[0];
        $this->assertEquals('type', $whereClause['column']);
        $this->assertEquals('Basic', $whereClause['type']);
        $this->assertEquals('=', $whereClause['operator']);
        $this->assertEquals(UserType::ADMIN, $whereClause['value']);
    }
}
