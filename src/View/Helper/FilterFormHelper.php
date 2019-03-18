<?php 

namespace Filter\View\Helper; 
use Cake\View\Helper\FormHelper; 
use Filter\Filter\FilterInterface;
use Filter\Engine\FilterEngineInterface;
use Filter\Engine\RequestEngine;
use Filter\Storage\FilterStorageInterface;

/**
 *  Helper class for filters
 */
class FilterFormHelper extends FormHelper 
{
    /**
     * 	@inheritdoc 
     *  @param $classname - classname for filter
     * 
     *  @example 
     *  You should create filters in App\Model\Filter namespace 
     *  FilterFormHelper will load class from there. 
     *  You can create your filters in subfolders also
     *  - then use dots in $classname param
     * 
     *  $this->FilterForm->create('Users') 
     *  will load App\Model\Filter\UsersFilter.php 
     *  
     *  $this->FilterForm->create('Users.Payments') 
     *  will load App\Model\Filter\Users\PaymentsFilter.php 
     */
    public function create($classname = NULL, array $options = [])  
    {
        $classname = str_replace('.', '\\', $classname);
        $classname = '\\App\\Model\\Filter\\'.$classname.'Filter';

        if(!class_exists($classname)) {
            throw new \RuntimeException(__('Class {0} does not exists' , [
                $classname
            ]));
        }

        $filter = new $classname();
        $filter->initialize();
        $this->setFilter($filter);

        return parent::create(NULL, $options);
    }

    /**
     * 	Create input for filter 
     *  Will automatically get value from filter if exists 
     *  
     *  @example $this->FilterForm->conrol('role' , [
     *      'type' => 'number'
     *  ]);
     * 
     * 	@param string $field - filter name 
     *  @param array $options 
     *  @return string HTML
     */
    public function control($field, array $options = []) 
    {
        // For checkbox
        if(isset($options['type']) && $options['type'] == 'checkbox') {
           if($value = $this->getFilter()->get($field)) {
               $options['checked'] = TRUE;
           }
           return parent::control('filter.'.$field, $options);
        }

        // For other
        if($value = $this->getFilter()->get($field)) {
            $options['value'] = $value;
        }

        return parent::control('filter.'.$field, $options);
    }

    /**
     * 	Set filter  
     *  @param FilterInterface $filter
     * 	@return FilterInterface
     */
    public function setFilter(FilterInterface $filter) :FilterInterface 
    {
        return $this->filter = $filter;
    }

    /**
     *  Get filter
     * 	@return FilterInterface
     */
    public function getFilter() :FilterInterface 
    {
        return $this->filter;
    }
}
