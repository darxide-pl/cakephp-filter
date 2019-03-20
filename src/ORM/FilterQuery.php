<?php 

namespace Filter\ORM; 
use Cake\ORM\Query; 
use Filter\Filter\FilterInterface;
use Filter\Utility\NormalizeKeyTrait;

class FilterQuery extends Query {

    use NormalizeKeyTrait;

    /**
     *  Intance of FilterInterface
     *  @var FilterInterface
     */
    protected $filter;

    /**
     *  List of disabled filters
     *  @var array 
     */
    protected $disabled = [];

    /**
     * 	Disable selected filter method 
     *  @param string $name - method name to disable  
     * 	@return FilterQuery
     */
    public function disableFilter(string $name) :FilterQuery 
    {
        $this->disabled[$name] = TRUE;
        return $this;
    }

    /**
     * 	Enable selected filter method 
     *  @param string $name - filter method name 
     * 	@return FilterQuery
     */
    public function enableFilter(string $name) :FilterQuery 
    {
        if(isset($this->disabled[$name])) {
            unset($this->disabled[$name]);
        }

        return $this;
    }

    /**
     * 	Set filter class for current query
     * 	@return FilterQuery
     */
    public function setFilterClass(string $classname) :FilterQuery
    {
        $this->filter = new $classname();
        if(!$this->filter instanceof FilterInterface) {
            throw new \RuntimeException(__('Filter should implement FilterInterface'));
        }
        return $this;
    }

    /**
     *  Get instance of current filter or null if filter was not set
     *  @return FilterInterface|null
     */
    public function getFilter() 
    {
        return $this->filter;
    }

    /**
     *  Apply filters, store values and get result
     * 	@inheritdoc 
     * 	@return ResultSet 
     */
    public function all() {

        if(!$this->filter) {
            return parent::all();
        }

        $this->filter->initialize();

        foreach ($this->filter->getFilters() as $name) {

            if(isset($this->disabled[$name])) {
                continue;
            }

            if($value = $this->filter->get($name)) {
                $this->filter->{$name}($this, $value);
            }

            if($this->filter->getStorage()) {
                $key = get_class($this->filter).'__'.$name;
                $this->filter
                    ->getStorage()
                    ->write($key, $value);
            }
        }        

        return parent::all();
    }
}