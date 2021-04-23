<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * Class TestCase
 *
 * @package Tests
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param array $items
     * @return array
     */
    protected function responseCollectionStructure($items = []): array
    {
        return [
            'data' => [
                'items' => [
                    '*' => $items,
                ]
            ],
            'message'
        ];
    }

    /**
     * @param array $items
     * @return array
     */
    protected function responseResourceStructure($items = []): array
    {
        return [
            'data' => $items,
            'message'
        ];
    }

    /**
     * @return array
     */
    protected function responseErrorStructure(): array
    {
        return [
            'message',
            'errors',
            'description'
        ];
    }
}
