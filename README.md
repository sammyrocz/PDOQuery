PHP PDO SQL QUERY LIBRARY
========================

As Rightly said **Need is The Mother OF Invention** . I created this library as I have to write same functions many times and I realized that  recreating the wheel isn't good. 
----------



####**Functions**

* get - Conditional Select Statement
* getAll - Selects All
* checkexistence - Checks the field against database
* insert - inserts the data into database
* delete - delets the entry from the table

#**Usage**

Setup
====
create a object of **MyDBHandler** class and pass the PDO connection and name of the table.


	$conn -> holds the connection to the database 
	$dboperations = new MyDbHandler($conn,"students");

If no such table exists die error is thrown

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
 
    $dboperations ->getall() ->  _Fetches rows associatively_
	
    $dboperations->getall(PDO::FETCH_NUM)-> _Fetches row as array but numeric index_

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