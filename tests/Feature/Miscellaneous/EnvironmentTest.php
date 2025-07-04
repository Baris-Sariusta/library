<?php

declare(strict_types=1);

it('uses the testing environment', function ()
{
    expect(app()->environment())
        ->toBe('testing');
});

it('uses the test database', function ()
{
    expect(config('database.connections.mysql.database'))->toBe('library_tests');
});
