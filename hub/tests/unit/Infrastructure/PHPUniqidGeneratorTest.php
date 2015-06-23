<?php

use FP\Larmo\Infrastructure\Adapter\PhpUniqidGenerator;

class PHPUniqidGeneratorTest extends PHPUnit_Framework_TestCase
{

    /**
     * @test\
     * @covers FP\Larmo\Domain\Service\UniqueIdGenerator
     */
    public function checkUniqueThousandItems()
    {
        $generator = new PhpUniqidGenerator();

        $this->assertInstanceOf('FP\Larmo\Domain\Service\UniqueIdGenerator', $generator);

        $ids = array();
        for ($i = 0; $i < 1000; $i++) {
            $ids[] = $generator->generate();
        }

        $this->assertEquals(count($ids), count(array_unique($ids)));
    }
}