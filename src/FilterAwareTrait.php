<?php 

namespace Filter;
use Filter\ORM\FilterQuery;

trait FilterAwareTrait 
{
    /**
     * 	To enable filtering we should use extended Query
     * 	@return FilterQuery
     */
    public function query() :FilterQuery
    {
        return new FilterQuery($this->getConnection(), $this);
    }
}