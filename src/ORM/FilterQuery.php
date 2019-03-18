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
        return $this;
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

        $classname = $this->filter; 
        $filter = new $classname();
        $filter->initialize();

        foreach ($filter->getFilters() as $name) {

            if(isset($this->disabled[$name])) {
                continue;
            }

            if($value = $filter->get($name)) {
                $filter->{$name}($this, $value);
            }

            if($filter->getStorage()) {
                $key = get_class($filter).'__'.$name;
                $filter
                    ->getStorage()
                    ->write($key, $value);
            }
        }        

        return parent::all();
    }
}