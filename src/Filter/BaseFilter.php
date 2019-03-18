<?php 

namespace Filter\Filter;
use Filter\Filter\FilterInterface;
use Filter\Engine\FilterEngineInterface;
use Cake\Routing\Router;
use Cake\Http\ServerRequest;
use Cake\Http\Session;
use Cake\Datasource\ModelAwareTrait;
use Filter\Storage\FilterStorageInterface;
use Filter\Utility\NormalizeKeyTrait;
use Filter\Engine\RequestEngine;

/**
 *  That class is abstract filter 
 *  That class is not using session to store values 
 *  To use session you should init filter with FilterStorageInterface:
 *  @see Filter\Filter\SessionFilter
 */
abstract class BaseFilter implements FilterInterface 
{
    use ModelAwareTrait;
    use NormalizeKeyTrait;

    /**
     *  List of filter methods to execute
     *  @var array 
     */
    protected $filters = [];

    /**
     *  Filter engine
     *  @var FilterEngineInterface
     */
    protected $engine;

    /**
     *  Filter storage
     *  @var FilterStorageInterface|null
     */
    protected $storage;

    /**
     * 	Init filter 
     * 	@return void
     */
    public function initialize() 
    {
        $this->setEngine(RequestEngine::class);
    }

    /**
     * 	Get all filters
     * 	@return array
     */
    public function getFilters() :array 
    {
        return $this->filters;        
    }

    /**
     *  Get filter value
     * 	@return 
     */
    public function get(string $key) 
    {
        $key = $this->normalizeKey($key);

        if($value = $this->getEngine()->get($key)) {
            return $value;
        }

        if($this->getStorage() && $value === NULL) {
            return $this
                ->getStorage()
                ->read(static::class.'__'.$key);
        }

        return NULL;
    }

    /**
     *  @todo
     */
    public function set(string $key, $data) :FilterInterface
    {
        return $this;
    }

    /**
     * 	Get engine
     * 	@return 
     */
    public function getEngine() :FilterEngineInterface
    {
        return $this->engine;
    }

    /**
     * 	Set engine 
     * 	@return FilterEngineInterface 
     */
    public function setEngine(string $classname) :FilterEngineInterface 
    {
        return $this->engine = new $classname();
    }

    /**
     * 	Get filter storage
     * 	@return FilterStorageInterface|null
     */
    public function getStorage() 
    {
        return $this->storage;
    }

    /**
     * 	Set storage for current filter
     *  @param string $classname
     * 	@return FilterStorageInterface;
     */
    public function setStorage(string $classname) :FilterStorageInterface 
    {
        return $this->storage = new $classname();
    }

    /**
     * 	Get request inside filter 
     * 	@return Request
     */
    public function getRequest() :ServerRequest 
    {
        return Router::getRequest();
    }

    /**
     * 	Get session inside filters 
     * 	@return Session
     */
    public function getSession() :Session 
    {
        return Router::getRequest()->getSession();
    }
}