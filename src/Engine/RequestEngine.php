<?php 

namespace Filter\Engine;
use Filter\Engine\BaseEngine;
use Cake\Routing\Router;

class RequestEngine extends BaseEngine 
{
    /**
     * 	Get value from post or get
     *  Query params shuld have higher priority than post values - i think - becouse query params are visible in url, so replacing values comes from url can be confusing for user
     * 
     *  @param string $key 
     * 	@return mixed
     */
    public function get(string $key) 
    {
        if($value = Router::getRequest()->getQuery('filter.'.$key)) {
            return $value;
        }

        return Router::getRequest()->getData('filter.'.$key);
    }
}