<?php 

namespace Filter\Engine;
use Filter\Engine\BaseEngine;
use Cake\Routing\Router; 

class PostEngine extends BaseEngine 
{
    /**
     * 	Get value from post
     *  @param string $key
     * 	@return mixed
     */
    public function get(string $key) 
    {
        return $this->getRequest()->getData('filter.'.$key);
    }
}