<?php

class MyDBHandler {

    //Holdss the tablename and connection to the database
    private $tbname;
    private $conn;

    /*
     * constructor 
     * @param - $conn - connection to the database
     * @param - $tablename - name of the table to associate with object 
     */

    public function __construct($conn, $tablename) {
        $this->conn = $conn;
        $this->tbname = $tablename;
    }

    /*
     * function - getAll
     * @param - $fetchType - method of fetching the result eg. PDO::ASSCO , PDO::NUM,PDO::ASSOC
     * @returns - false,array
     * @return - false - if some error has occurred during exceuting the query such as no such table exists
     * @return - array - Holding the mulidimesional array of the fetched data from database
     */

    public function getall($fetchType = PDO::FETCH_ASSOC) {


        $statement = $this->conn->prepare("select * from $this->tbname");
        $result = $statement->execute();

        if ($result) {

            $result = $statement->fetchAll($fetchType);
            return $result;
        } else {
            return false;
        }
        
       
    }

    /*
     * function - get
     * @param - any number of parameters 
     * #Paramter rule#
     * # params must be even no
     * # a logical param is collection of 2 param 
     * # 1 param represents the name of the field in the database
     * # 2 param represents the value to be checked against that param
     * @returns - false,array
     * @return - false - if some error has occurred during exceuting the query such as no such table exists
     * @return - array - Holding fetched data from database
     */

    public function get() {

        $numargs = func_num_args();
      
        if ($numargs > 0 && $numargs % 2 == 0) {
            $arg_list = func_get_args();
            $query = "select * from $this->tbname where ";
            $i = 0;
            $param = 1;
            $fields = array();
            for (; $i <= ($numargs / 2) - 2; $i = $i + 2) {

                $query = $query . $arg_list[$i] . " = :param" . $param . " AND ";
                $param++;
                
            }

            $query = $query . $arg_list[$i] . " = :param" . $param;
              
            $i = 1;
            $paramcount = 1;
            
            for (; $i < $numargs; $i = $i + 2) {
                $fields[':param' . $paramcount] = $arg_list[$i];
                $paramcount++;
            }

            
            $statement = $this->conn->prepare($query);
            $result = $statement->execute($fields);
            $data = $statement->fetch(PDO::FETCH_ASSOC);
            
            
                return $data;
                
            
            
            } else
            return false;
    }
	
	/*
     * function - checkExistence
     * @param - any number of parameters 
     * @param - field - name of the field
     * @param - value - value to be mathced againt that field in database
     * @return - boolean
     * @return - true - exists in db
     * @return - false - doesn't exist in db
     */
    
    public function checkExistence() {

        $numargs = func_num_args();

        if ($numargs == 2) {
            $arg_list = func_get_args();
            $query = "select * from $this->tbname where ";
            $query = $query . $arg_list[0] . " = :param";
            $field = array();
            $field[':param'] = $arg_list[1];
            $statement = $this->conn->prepare($query);
            $result = $statement->execute($field);

            if ($result) {
                
                if($statement->rowCount() > 0)
                    return true;
                else return false;
            } else return false;
        } else return false;
    }
    
}
