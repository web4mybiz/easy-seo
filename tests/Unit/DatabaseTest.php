<?php

namespace Tests\Unit\Inc;

use Inc\Database;
use Tests\TestCase;

/**
 * Class DatabaseTest.
 *
 * @covers \Inc\Database
 */
class DatabaseTest extends TestCase
{
    /**
     * @var Database
     */
    protected $database;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->database = new Database();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->database);
    }

    public function testStore_results(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testGet_stored_results(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCreate_crawl_results_table(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testDelete_crawl_results_table(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testRemove_crawl_results_table(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCrawl_plugin_activation(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCrawl_plugin_deactivation(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
