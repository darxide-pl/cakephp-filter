<?php 

namespace Filter\Storage; 

interface FilterStorageInterface {

    /**
     *  Save filter data 
     *  @param string $key - filter key 
     *  @param mixed $data - could be anything
     *  @return bool - true if saved successfully
     */
    public function write(string $key, $data) :bool;

    /**
     * 	Read data from storage
     *  @param string $key - key to read 
     * 	@return mixed
     */
    public function read(string $key);

    /**
     *  Delete value from storage by key 
     *  @param string $key 
     *  @return bool - true if value was successfully removed
     */
    public function delete(string $key) :bool;

    /**
     * 	Keys normalization - should be underscored, lowecased
     *  Methods in filters is usually camelCased 
     *  but html input name="should_be_underscored"
     *  @param string $key 
     * 	@return string
     */
    public function normalizeKey(string $key) :string;
}