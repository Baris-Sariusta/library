<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Seeder;

/**
 * Run the predefined sets of architecture tests.
 */
arch()->preset()->php();
arch()->preset()->laravel()->ignoring(['App\\Contracts', 'App\\Http\\Controllers\\AuthController']);
arch()->preset()->security();

/**
 * Define the architecture tests for all App files.
 */
arch('all App\\ files should use strict types')
    ->expect('App')
    ->toUseStrictTypes();

arch('all classes should be final')
    ->expect('App')
    ->classes()
    ->toBeFinal()
    ->ignoring('App\Contracts');

/**
 * Define the architecture tests for all Database files.
 */
arch('all Database\\ files should use strict types')
    ->expect('Database')
    ->toUseStrictTypes();

/**
 * Define the architecture tests for all Contracts.
 */
arch('all contracts should be abstract')
    ->expect('App\Contracts')
    ->toBeAbstract();

/**
 * Define the architecture tests for all Exceptions.
 */
arch('all exceptions should end with "Exception"')
    ->expect('App\Exceptions')
    ->toHaveSuffix('Exception');

/**
 * Define the architecture tests for all Controllers.
 */
arch('all controllers should end with "Controller"')
    ->expect('App\Http\Controllers')
    ->toHaveSuffix('Controller');

/**
 * Define the architecture tests for all ServiceProviders.
 */
arch('all service providers should end with "Provider"')
    ->expect('App\Providers')
    ->toHaveSuffix('Provider');

arch('all service providers should contain the register() method')
    ->expect('App\Providers')
    ->toHaveMethod('register');

arch('all service providers should contain the boot() method')
    ->expect('App\Providers')
    ->toHaveMethod('boot');

/**
 * Define the architecture tests for all Factories.
 */
arch('all factories should be final')
    ->expect('Database\Factories')
    ->classes()
    ->toBeFinal();

arch('all factories should extend the base factory')
    ->expect('Database\Factories')
    ->classes()
    ->toExtend(Factory::class);

arch('all factories should end with "Factory"')
    ->expect('Database\Factories')
    ->classes()
    ->toHaveSuffix('Factory');

/**
 * Define the architecture tests for all Seeders.
 */
arch('all seeders should be final')
    ->expect('Database\Seeders')
    ->classes()
    ->toBeFinal();

arch('all seeders should extend the base seeder')
    ->expect('Database\Seeders')
    ->classes()
    ->toExtend(Seeder::class);

arch('all seeders should end with "Seeder"')
    ->expect('Database\Seeders')
    ->classes()
    ->toHaveSuffix('Seeder');
