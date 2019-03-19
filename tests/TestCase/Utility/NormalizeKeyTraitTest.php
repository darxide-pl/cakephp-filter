<?php 

namespace Filter\Test\TestCase\Utility; 
use Cake\TestSuite\TestCase; 

class NormalizeKeyTraitTest extends TestCase {
 
    public function testKeysNotChangedWhenNoCamelace() 
    {
        
        $mock = $this->getMockForTrait('Filter\Utility\NormalizeKeyTrait');

        $keys = [
            'lastname', 'my_address',
            'role_id', 'asdas.sdasd'
        ];

        foreach ($keys as $key) {
            $this->assertTrue($mock->normalizeKey($key) === $key);
        }
    }

    public function testIfKeysIsNormalizedCorrectly() {
    
        $mock = $this->getMockForTrait('Filter\Utility\NormalizeKeyTrait');

        $keys = [
            'roleId' => 'role_id',
            'camelCasedKey' => 'camel_cased_key', 
            'PascalCasedKey' => 'pascal_cased_key'
        ];

        foreach ($keys as $k => $v) {
            $this->assertTrue($mock->normalizeKey($k) === $v);
        }
    }
}