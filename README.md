PHP PDO SQL QUERY LIBRARY
========================

As Rightly said **Need is The Mother OF Invention** . I created this library as I have to write same functions many times and I realized that  recreating the wheel isn't good. 
----------



####**Functions**

* get - Conditional Select Statement
* getAll - Selects All
* checkexistence - Checks the field against database
* insert - inserts the data into database
* delete - deletes the entry specified
* getfields - conditional select statement (returns selected field)


#**Usage**

Setup
====
create a object of **MyDBHandler** class and pass the PDO connection and name of the table.


	$conn -> holds the connection to the database 
	$dboperations = new MyDbHandler($conn,"students");
---------
**getall**
=========
``public function getall($fetchType = PDO::FETCH_ASSOC)``

* @param - **$fetchType** - method of fetching the result eg. PDO::NUM,PDO::ASSOC
* Fetches all rows available
* @returns - false,array
     * @return - false - if some error has occurred during exceuting the query such as no such table exists
     * @return - array - Holding the multidimensional array of the fetched data from database

eg.-
 
    $dboperations ->getall() ->  Fetches rows associatively
	
    $dboperations->getall(PDO::FETCH_NUM)->  Fetches row as array but numeric index

------------
**get**
======
######The function uses typed parameter internally
``public function get(any number of param)``


* @param - any number of parameters 
	* no of params must be even no
	* a logical param is collection of 2 param 
	* 1 param represents the name of the field in the database
	* 2 param represents the value to be checked against that param
* @returns - false,array
     * @return - false - if some error has occurred during exceuting the query 		such as no such table exists
     * @return - array - Holding fetched data from database

eg.- 
		
    a databse has field namely collegeid(int),name(varchar)

	$dboperations->get("collegeid",456,"name","IIT DELHI") -> checks the field collgeid against 456, name ,"IIT Delhi" and returns the object
	
    $dboperations->get("collegeid",456,"name","IIT DELHI") -> **ERROR** - returns false 

--------------

**getfields**
======
######The function uses typed parameter internally
``public function get(any number of param)``


* @param - any number of parameters 
	 * 1 param - specifies the no of fields to select
     * 2 - list of fields to select
     * 3 - rules to select the param (can be empty)
     *  after specifying the fields next is the rule (fileds checked against specified value) 
     *  rules must be in pair
     *  first param must be a name of field and second is the value to check against that field

* @returns - false,array
     * @return - false - some error has occured
     * @return - array - associative array of fetched data from database

eg.- 
		
    a databse has field namely collegeid(int),name(varchar)

	 $dboperations->getfields("2","id","name") -> select id,name from table 
	
    $dboperations->get("1",name","id",1234) -> select name from table where id = 1234
---------------

**checkexistence**
======
``public function checkexistence($field,$value)``
* @param - $field,$value 
	 * @param - any number of parameters 
     * @param - field - name of the field
* @return - boolean
     * @return - true - exists in db
     * @return - false - doesn't exist in db


eg - 
	
    $dboperations->checkExistence("id","1234")` -> true if table has 1234 entry or false if no such entry exits

--------------

**insert**
======

######The function uses typed parameter internally

``public function insert(any number of param)``

* @param - any number of parameters 
	* no of params must be even no
	* a logical param is collection of 2 param 
	* 1 param represents the name of the field in the database
	* 2 param represents the value to be inserted against that param
* @returns - boolean
     * @return - false - if data is not added into the table
     * @return - array - data is added into the table

eg.- 
	
    a database has field namely collegeid(int),name(varchar)

	$dboperations->insert("collegeid",456,"name","IIT DELHI")-> inserts the data into db and return true
	
    $dboperations->insert("collegeid",456,"name","IIT DELHI") **ERROR** - returns false 
    
-------
**delete**
======
######The function uses typed parameter internally

``public function delete($field,$value)``
* @param - $field,$value 
	 * @param - any number of parameters 
     * @param - field - name of the field
* @return - boolean
     * @return - true - deleted from db
     * @return - false - some error has occurred


eg - 
	
    $dboperations->delete("id","1234")` -> true if table has 1234 entry or false if some error has occurred ( if the entry doesnt exits its returns true because its logically deleted)

--------------