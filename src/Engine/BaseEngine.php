<?php 

namespace Filter\Engine; 
use Filter\Engine\FilterEngineInterface; 
use Cake\Routing\Router;
use Cake\Http\ServerRequest;

abstract class BaseEngine implements FilterEngineInterface 
{
    /**
     *  @var ServerRequest 
     */
    protected $request; 
    
    public function get(string $key) 
    {
        return NULL;
    }

    /**
     * 	Set request
     * 	@return ServerRequest
     */
    public function getRequest() :ServerRequest 
    {
        if(!$this->request) {
            $this->setRequest(Router::getRequest());
        }

        return $this->request;
    }

    /**
     * 	Set request 
     * 	@return ServerRequest
     */
    public function setRequest(ServerRequest $request) :ServerRequest 
    {
        return $this->request = $request;
    }
}