<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase;
use PHPUnit\Framework\AssertionFailedError;

class ZeroTextAssertionTest extends TestCase
{
    public function test_missing_zero_must_fail_text_assertion(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        self::assertSame('hello', $response->getContent());

        $this->expectException(AssertionFailedError::class);

        $response->assertSeeText('0');
    }
}
