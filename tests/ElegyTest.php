<?php

namespace Javanile\Elegy\Tests;

use Javanile\Producer;
use PHPUnit\Framework\TestCase;
use Javanile\Elegy\Elegy;

Producer::addPsr4([
    'Javanile\Elegy\\' => __DIR__.'/../src',
    'Javanile\Elegy\\Tests\\' => __DIR__,
]);

final class ElegyTest extends TestCase
{
    public function testCreateAnInstance()
    {
        $object = new Elegy();
        $this->assertInstanceOf('Javanile\Elegy\Elegy', $object);

        $output = "Hello World!";
        $this->assertRegexp('/World/i', $output);
    }
}
