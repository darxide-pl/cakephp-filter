<?php 

namespace Filter\Utility; 
use Cake\Utility\Inflector; 

trait NormalizeKeyTrait 
{
    /**
     * 	Methods in filters SouldBe::camelCased() 
     *  But html input names="should_be[lowecased_with_underscore]"
     *  To resolve that we can use Cake's Inflector
     *  @param string $key - key to normalize 
     * 	@return sring - normalized key 
     */
    public function normalizeKey(string $key) :string 
    {
        return Inflector::underscore($key);
    }
}