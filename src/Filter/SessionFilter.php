<?php 

namespace Filter\Filter; 
use Filter\Filter\BaseFilter;
use Filter\Engine\RequestEngine;
use Filter\Storage\SessionStorage;

/**
 *  That class can be a basement to build filters which uses session as storage
 */
abstract class SessionFilter extends BaseFilter 
{

    /**
     *  Init filter with engine and storage
     * 	@return void
     */
    public function initialize() 
    {
        $this->setEngine(RequestEngine::class);
        $this->setStorage(SessionStorage::class);
    }
}