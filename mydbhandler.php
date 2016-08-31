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
        if(!$this->tableexists())
        {
            die("NO SUCH TABLE");
        }
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

            for (; $i < $numargs-2; $i = $i + 2) {

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
     * @param - 2 parameters 
     * @param - field - name of the field
     * @param - value - value to be mathced againt that field in database
     * @return - boolean
     * @return - true - exists in db
     * @return - false - doesn't exist in db
     */

    public function checkexistence() {

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

                if ($statement->rowCount() > 0)
                    return true;
                else
                    return false;
            } else
                return false;
        } else
            return false;
    }
    
    /*
     * function - insertset
     * #Paramter rule#
     * # params must be even no
     * # a logical param is collection of 2 param 
     * # 1 param represents the name of the field in the database
     * # 2 param represents the value to be checked against that param
     * @returns - boolean
     * @return - false - if data is not added into the table
     * @return - array - data is added into the table
     */

    public function insert() {

        $numargs = func_num_args();

        if ($numargs > 0 && $numargs % 2 == 0) {
            $arg_list = func_get_args();
            $query = "Insert INTO $this->tbname SET ";
            $i = 0;
            $param = 1;
            $fields = array();
            for (; $i < $numargs-2; $i = $i + 2) {

                $query = $query . $arg_list[$i] . " = :param" . $param . ", ";
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

            if ($result) {

                return true;
            } else {
                return false;
            }
        } else
            return false;
    }
    
    /*
     * function - delete
     * @param - 2 parameters 
     * @param - field - name of the field
     * @param - value - value to be mathced againt that field in database
     * @return - boolean
     * @return - true - deleted
     * @return - false - some error has occured
     */
  public function delete(){
      
       $numargs = func_num_args();
       
        if ($numargs > 0 && $numargs % 2 == 0) {
        
            $arg_list = func_get_args();
            $query = "delete from $this->tbname where  ";
         
             $query = $query . $arg_list[0] . " = :param";
             $fields = array();
             $fields[':param'] = $arg_list[1];
             $statement = $this->conn->prepare($query);
             $result  = $statement->execute($fields);
             
             if(!$this->checkexistence($arg_list[0],$arg_list[1])){
                 
                 return true;
             }
             
             if($result){
                 return true;
             } else return true;
             
        }
        
       
  }

  function tableexists() {

    try {
        $result = $this->conn->query("SELECT 1 FROM $this->tbname LIMIT 1");
    } catch (Exception $e) {
        return FALSE;
    }

    return true;
}

    /*
     * fucntion - getfields
     * @param - any number of param
     * ****param rules*******
     * #1 param - specifies the no of fields to select
     * #2 - list of fields to select
     * #3 - rules to select the param (can be empty)
     * # after specifying the fields next is the rule (fileds checked against specified value) 
     * # rules must be in pair
     * # first param must be a name of field and second is the value to check against that field
     * @returns - false,array
     * @return - false - some error has occured
     * @return - array - associative array of fetched data from database
     */

    public function getfields() {

        $numargs = func_num_args();

        if ($numargs > 0) {
            $fields = array();
            $arg_list = func_get_args();
            $fieldsno = $arg_list[0];
            $query = "select ";
            $i = 1;
            for (; $i < $fieldsno; $i++) {
                $query = $query . $arg_list[$i] . ", ";
            }

            if ($fieldsno > 0) {
                $query = $query . $arg_list[$i] . " ";
                $i++;
            }

            $query = $query . "from $this->tbname ";

            $numargs = $numargs - $i;
            array_splice($arg_list, 0, $i);
        
            if ($numargs > 0 && $numargs % 2 == 0) {

                $query = $query . " where ";
                $i = 0;
                $param = 1;

                for (; $i < $numargs - 2; $i = $i + 2) {

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
            }
            $statement = $this->conn->prepare($query);
            $result = $statement->execute($fields);

            $data = $statement->fetchAll(PDO::FETCH_ASSOC);
            if ($result) {
               
                return $data;
            } else
                return false;
        }
    }

	
    /*
     * function - update
     * #Paramter rule#
     * # can be n no of parameters
     * # n >= 5
     * # 1 param represents the no of the field to update in the database
     * # 2 - valueof(param(1)) param represents the field name and value to update
     * # after the no of valueof(param(1)) - param reprsents a pair of params checked againt database
     *  # 1 param represnts the field name in database
     *  # 2 param represents the value
     * @returns - boolean
     * @return - false - if data is not updated into table
     * @return - true - data is updated into the table
     */
    public function update() {

        $numargs = func_num_args();

        if ($numargs >= 5) {

            $query = "update $this->tbname set ";
            $arg_list = func_get_args();

            if ($arg_list[0] == 0)
                return false;
            $fields = array();
            $i = 1;
            $paramcount = 1;
            for (; $i <= ($arg_list[0] * 2 - 2); $i = $i + 2, $paramcount++) {
                $query = $query . $arg_list[$i] . "= :param" . $paramcount . ", ";
                $fields[':param' . $paramcount] = $arg_list[$i + 1];
            }

            $query = $query . $arg_list[$i] . "= :param" . $paramcount . " where ";
            $fields[':param' . $paramcount] = $arg_list[$i + 1];
            array_splice($arg_list, 0, $i + 2);
            $numargs = count($arg_list);
            $k = 0;
            $paramcount++;
            for (; $k < $numargs - 2; $k = $k + 2, $paramcount++) {
                $query = $query . $arg_list[$k] . "= :param" . $paramcount . " AND ";
                $fields[':param' . $paramcount] = $arg_list[$k + 1];
            }

            $query = $query . $arg_list[$k] . "= :param" . $paramcount;
            $fields[':param' . $paramcount] = $arg_list[$k + 1];

            $statement = $this->conn->prepare($query);
            $result = $statement->execute($fields);
            if($result)
                return true;
            else return false;
            
            } else
            return fasle;
    }
   

}
