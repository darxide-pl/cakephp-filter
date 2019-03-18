<?php 

namespace Filter\Engine; 
use Filter\Engine\BaseEngine; 
use Cake\Routing\Router;

class QueryEngine extends BaseEngine 
{
    /**
     * 	Get value from query string 
     *  @param string $key - query param name
     * 	@return mixed
     */
    public function get(string $key) 
    {
        return Router::getRequest()->getQuery('filter.'.$key);
    }
}