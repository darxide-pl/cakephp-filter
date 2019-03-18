
# Filter plugin for CakePHP

## Installation

You can install this plugin into your CakePHP application using [composer](https://getcomposer.org).

The recommended way to install composer packages is:

```
composer require darxide-pl/cakephp-filter
```

## Intro 

In real life applications, filtering queries by user input can quickly growth into enormous queries controlled by tons of inputs. 

The main idea of this plugin is keep the code clean and readable. 

Every query can have many filters as separated methods in `App\Model\Filter` namespace, and queries are passed into these filters as parameters, so filters are easy to test and maintain.

Plugin allows you to filtering queries using get variables, post variables, json input. 

Plugin has also implemented "memory" of filter in session (optional) and has easily extendable interfaces to help You with write your own implementations.

There are also `FilterForm` Helper which helps with building forms with filters.


## Quick example

1. cmd: `./bin/cake plugin load Filter` 
2. Load helper in `/src/View/AppView.php` 

```php
<?php

namespace App\View;
use Cake\View\View;

class AppView extends View
{
    public function initialize()
    {
        $this->loadHelper('Filter.FilterForm');
    }
}
```

3. Use `Filter\FilterAwareTrait` in Your `Table` class 
(notice: this requires the creation of a table or just use existing one)
(notice2: Traits needs to declare `use` inside `class` declatarion)
example file is `/src/Model/Table/UsersTable.pgp`

```php
<?php
namespace App\Model\Table;
use Filter\FilterAwareTrait;
// rest of used classes and traits...

class UsersTable extends Table
{
    use FilterAwareTrait;
    // rest of code ...
}
```

4. Create file named `UsersFilter.php` in `/src/Model/Filter/`

```php 
<?php

namespace App\Model\Filter;
use Filter\Filter\BaseFilter;
use Cake\ORM\Query;

class UsersFilter extends BaseFilter
{
	/**
	* Used filter methods should be listed in this property
	* @var  array
	*/
	protected $filters = [
		'name',
		'role'
	];

	/**
	* Filter results by user name
	* By default, filter will look for variable $_GET[filter][name] or $_POST[filter][name] in this case
	* @see Filter\Engine\RequestEngine::get() 
	* 
	* @return Query
	*/
	public function name(Query $query, string $value) :Query
	{
		return $query
			->where([
				'Users.name LIKE' => '%'.$value.'%'
			]);
	}
	
	/**
	* Filter users list by role id
	* @return Query
	*/
	public  function role(Query $query, int $role_id) :Query
	{
		return $query->where(['Users.role_id'  => $role_id]);
	}
}
```

5. Now, we can bind that filter to query in controller and|or paginate this query (in example `/src/Controller/PagesController.php`)

```php
<?php  

namespace App\Controller;
use App\Model\Filter\UsersFilter;

class PagesController extends AppController
{
	public  function display(...$path)
	{
		$this->loadModel('Users');
		$query =  $this
			->Users
			->find()
			->setFilterClass(UsersFilter::class);

		$results =  $this->paginate($query);
		$this->set(compact('results'));
		
		$this
			->viewBuilder()
			->setTemplate('filter_example');
	}
}
```

6. The last step is html form template. Create `/src/Template/Pages/filter_example.ctp` file

```php
<?=  $this->FilterForm->create('Users') ?>
<?=  $this->FilterForm->control('name') ?>
<?=  $this->FilterForm->end() ?>

<?php dump($results->toArray()) ?>
```

### Docs 
Today is 18.03.2019 and I promise I will complete docs asap.
