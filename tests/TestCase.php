<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use InteractsWithDatabase;
    use RefreshDatabase;
}
