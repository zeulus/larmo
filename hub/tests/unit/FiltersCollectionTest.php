<?php

use FP\Larmo\Domain\Service\FiltersCollection;
use FP\Larmo\Domain\Service\MessageCollection;

class FiltersCollectionTest extends PHPUnit_Framework_TestCase
{
    private $filters;
    private $messages;

    public function setup()
    {
        $this->filters = array();

        for ($i = 1; $i <= 2; $i++) {
            $filterMock = $this->getMockBuilder('FP\Larmo\Domain\Service\MessageFilter')
                ->getMock();

            $this->filters[] = $filterMock;
        }

        $this->messages = new MessageCollection();
    }

    /**
     * @test
     */
    public function canCreateCollectionWithFilters()
    {
        $filters = new FiltersCollection($this->filters);
        $returnedFilters = $filters->asArray();
        $this->assertEquals($returnedFilters, $this->filters);
    }

    /**
     * @test
     */
    public function invalidFiltersWillBeRejected()
    {
        $most_stupid_filters = array(
            'Dumb filter',
            new stdClass()
        );

        $this->setExpectedException('PHPUnit_Framework_Error');
        $filters = new FiltersCollection($most_stupid_filters);
    }

    /**
     * @test
     */
    public function canAttachProperFilterToCollection()
    {
        $filters = new FiltersCollection();
        $single_filter = $this->filters[0];
        $filters->addFilter($single_filter);

        $this->setExpectedException('PHPUnit_Framework_Error');
        $filters->addFilter($this->messages);
    }

    /**
     * @text
     */
    public function filtersCollectionCanRunFiltersOnMessages()
    {
        $filters = new FiltersCollection($this->filters);
        $filters->execute($this->messages);
    }
}