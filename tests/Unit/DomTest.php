<?php

namespace Tests\Unit\Inc;

use Inc\Dom;
use Tests\TestCase;

/**
 * Class DomTest.
 *
 * @covers \Inc\Dom
 */
class DomTest extends TestCase
{
    /**
     * @var Dom
     */
    protected $dom;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->dom = new Dom();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->dom);
    }

    public function testExtract_hyperlinks(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }

    public function testCreate_sitemap(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
