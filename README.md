PHP PDO SQL QUERY LIBRARY
========================

As Rightly said **Need is The Mother OF Invention** . I created this library as I have to write same functions many times and I realized that  recreating the wheel isn't good. 
----------



####**Functions**

get - Conditional Select Statement
getAll - Selects All   

--------------------------


**Usage**
==========

##Setup

create a object of **MyDBHandler** class and pass the PDO connection and name of the table.

>eg. -
      $conn \-\> holds the connection to the database 
       \$dboperations = new MyDbHandler($conn,"students");
        
##**getall**
public function getall($fetchType = PDO::FETCH_ASSOC) 

>* @param - **$fetchType** - method of fetching the result eg. PDO::ASSCO , PDO::NUM,PDO::ASSOC  
>* Fetches all rows available  
>* @returns - false,array
     * @return - false - if some error has occurred during exceuting the query such as no such table exists
     * @return - array - Holding the multidimensional array of the fetched data from database

> eg.- 
> $dboperations ->getall() ->  _Fetches rows as associatively_
> $dboperations->getall(PDO::FETCH_NUM) -> _Fetches row as array but numeric index_


