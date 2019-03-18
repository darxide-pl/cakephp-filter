<?php 

namespace Filter\Filter; 
use Cake\Routing\Router;
use Cake\Http\ServerRequest;
use Cake\Http\Session;
use Filter\Engine\FilterEngineInterface; 
use Filter\Storage\FilterStorageInterface;

interface FilterInterface {

    /**
     * 	Get list of all filtering methods in current class 
     * 	@return array
     */
    public function getFilters() :array;

    /**
     *  Get filter value by key 
     *  @param string $key - filter key 
     *  @return mixed
     */
    public function get(string $key);

    /**
     * 	Set filter value 
     * 	@param string $key 
     *  @param mixed $data 
     *  @return self
     */
    public function set(string $key, $data) :FilterInterface;

    /**
     * 	Get engine interface 
     * 	@return FilterEngineInterface
     */
    public function getEngine() :FilterEngineInterface;

    /**
     * 	Set engine 
     *  @param string $classname 
     * 	@return FilterEngineInterface
     */
    public function setEngine(string $classname) :FilterEngineInterface;

    /**
     * 	Get storage 
     * 	@return FilterStorageInterface|null
     */
    public function getStorage();

    /**
     *  Set storage 
     *  @param string $classname
     *  @return FilterStorageInterface
     */
    public function setStorage(string $classname) :FilterStorageInterface;

    /**
     * 	Get request inside filter
     * 	@return Request
     */
    public function getRequest() :ServerRequest;

    /**
     *  Get session inside filter 
     *  @return Session
     */
    public function getSession() :Session;

    /**
     * @inheritdoc from Cake\Datasource\ModelAwareTrait;
     */
    public function loadModel($model = null, $type = null);
}