<?php

namespace Utopia\Tests\Storage;

use Exception;
use PHPUnit\Framework\TestCase;
use Utopia\Storage\Device\Local;
use Utopia\Storage\Storage;

Storage::setDevice('disk-a', new Local(__DIR__.'/../resources/disk-a'));
Storage::setDevice('disk-b', new Local(__DIR__.'/../resources/disk-b'));

class StorageTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function tearDown(): void
    {
    }

    public function testGetters()
    {
        $this->assertEquals(get_class(Storage::getDevice('disk-a')), 'Utopia\Storage\Device\Local');
        $this->assertEquals(get_class(Storage::getDevice('disk-b')), 'Utopia\Storage\Device\Local');

        try {
            get_class(Storage::getDevice('disk-c'));
            $this->fail('Expected exception not thrown');
        } catch (Exception $e) {
            $this->assertEquals('The device "disk-c" is not listed', $e->getMessage());
        }
    }

    public function testExists()
    {
        $this->assertEquals(Storage::exists('disk-a'), true);
        $this->assertEquals(Storage::exists('disk-b'), true);
        $this->assertEquals(Storage::exists('disk-c'), false);
    }

    /**
     * @throws Exception
     */
    public function testMoveIdenticalName()
    {
        $file = '/kitten-1.jpg';
        $device = Storage::getDevice('disk-a');

        try {
            $device->move($file, $file);
            $this->fail('Failed to throw exception');
        } catch (\Exception $e) {
            $this->assertEquals('Source and target can not be identical!', $e->getMessage());
        }

    }
}
