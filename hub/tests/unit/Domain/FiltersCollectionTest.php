<?php

use FP\Larmo\Domain\Service\FiltersCollection;
use FP\Larmo\Domain\Service\MessageCollection;

class FiltersCollectionTest extends PHPUnit_Framework_TestCase
{
    private $messages;

    public function setup()
    {
        $this->messages = new MessageCollection();
    }

    public function offsetAndLimitAreSpecialFilters()
    {
        $limit = 12;
        $offset = 3;

        $filters = compact('limit', 'offset');

        $collection = new FiltersCollection($filters);
        $this->assertTrue($collection->hasFilter('limit'));
        $this->assertEquals($limit, $collection->getFilter('limit'));
        $this->assertTrue($collection->hasFilter('offset'));
        $this->assertEquals($offset, $collection->getFilter('offset'));
    }

    /**
     * @test
     */
    public function filtersOtherThanLimitAndOffsetAreStoredInDataFilter()
    {
        $limit = 12;
        $offset = 3;
        $name = 'aaaa';

        $filters = compact('limit', 'offset', 'name');

        $collection = new FiltersCollection($filters);
        $this->assertTrue($collection->hasFilter('data'));
        $this->assertEquals(array('name' => $name), $collection->getFilter('data'));
    }

    /**
     * @test
     */
    public function invalidFilterNameWillBeRejected()
    {
        $filters = array('\FP\Larmo' => 'asdasd');

        $this->setExpectedException('InvalidArgumentException', 'field names can only contain English letters and underscore character');
        $collection = new FiltersCollection($filters);
    }

    /**
     * @test
     */
    public function singleFilterCanBeAttachedToExistingFilters()
    {
        $filters = new FiltersCollection();
        $filters->addFilters(array(
           'limit' => 12,
            'offset' => 4
        ));

        $filters->addFilter('username', 'someone');

        $this->assertEquals(array('username' => 'someone'), $filters->getFilter('data'));
        $this->assertEquals(12, $filters->getFilter('limit'));
        $this->assertEquals(4, $filters->getFilter('offset'));
    }
}