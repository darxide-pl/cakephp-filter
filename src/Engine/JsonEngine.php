<?php 

namespace Filter\Engine;
use Filter\Engine\BaseEngine; 
use Cake\Utility\Hash;
use Cake\Routing\Router;

/**
 *  Proper way to filter queries using json input 
 */
class JsonEngine extends BaseEngine 
{
    /**
     * 	Get filter value from json input
     *  @param string $key
     * 	@return mixed
     */
    public function get(string $key) 
    {
        $data = Router::getRequest()->input('json_decode');
        return Hash::get($data, 'filter.'.$key);
    }
}