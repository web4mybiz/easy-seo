<?php

namespace Tests\Unit\Inc;

use Inc\Admin;
use Tests\TestCase;

/**
 * Class AdminTest.
 *
 * @covers \Inc\Admin
 */
class AdminTest extends TestCase
{
    /**
     * @var Admin
     */
    protected $admin;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = new Admin();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->admin);
    }

    public function testSettings_link(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testEasy_seo_admin_menu(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testEasy_seo_admin_page(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testTrigger_crawl(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testSave_as_html(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testDisplay_results(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testRecurring_crawl_task(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testSitemap_link(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
