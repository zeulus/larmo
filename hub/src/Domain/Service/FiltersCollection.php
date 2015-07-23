<?php

namespace FP\Larmo\Domain\Service;

class FiltersCollection
{

    private $filters = array('data' => array());

    public function __construct(array $filters = array())
    {
        $this->addFilters($filters);
    }

    public function addFilters(array $filters)
    {
        foreach ($filters as $filter => $value) {
            $this->addFilter($filter, $value);
        }
    }

    public function addFilter($filter, $value)
    {
        switch ($filter) {
            case 'limit':
            case 'offset':
                if (!is_numeric($value) || $value <= 0) {
                    throw new \InvalidArgumentException("'$filter' value should be positive integer");
                }
                $this->filters[$filter] = (int)$value;
                break;

            // timestamp to avoid caching issues, not relevant
            case 't':
                break;

            default:
                if ($this->fieldNameIsAcceptable($filter)) {
                    $cleanValue = $this->trimValues($value);
                    if (!empty($cleanValue)) {
                        $this->filters['data'][$filter] = $cleanValue;
                    }
                } else {
                    throw new \InvalidArgumentException("field names can only contain English letters and underscore character");
                }
        }
    }

    private function trimValues($value)
    {
        if (is_array($value)) {
            array_walk($value, function (&$v, $k) {
                $v = trim($v);
            });
            $value = array_filter($value);
        } else {
            $value = trim($value);
        }

        return $value;
    }

    private function fieldNameIsAcceptable($field)
    {
        return preg_match('/^[a-zA-Z_]{1,30}$/', $field);
    }

    public function asArray()
    {
        return $this->filters;
    }

    public function getFilter($name)
    {
        return (isset($this->filters[$name])) ? $this->filters[$name] : null;
    }

    public function hasFilter($name)
    {
        return isset($this->filters[$name]);
    }
}