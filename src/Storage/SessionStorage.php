<?php 

namespace Filter\Storage;
use Filter\Storage\BaseStorage; 
use Cake\Routing\Router;

class SessionStorage extends BaseStorage 
{
    /**
     *  Save filter data to session
     *  @param string $key 
     *  @param mixed $data
     *  @return bool
     */
    public function write(string $key, $data) :bool 
    {
        $key = $this->normalizeKey($key);
        Router::getRequest()
            ->getSession()
            ->write('Filter.'.$key, $data);
    
        return true;
    }

    /**
     *  Read value from storage 
     *  @param string $key 
     *  @return mixed
     */
    public function read(string $key) 
    {
        $key = $this->normalizeKey($key);       
        return Router::getRequest()
            ->getSession()
            ->read('Filter.'.$key);
    }

    /**
     * 	Remove value from storage 
     * 	@return bool
     */
    public function delete(string $key) :bool 
    {
        $key = $this->normalizeKey($key);
        return !!Router::getRequest()
            ->getSession()
            ->delete($key);
    }
}