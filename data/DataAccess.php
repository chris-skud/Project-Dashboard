<?php
/**
 *  A simple class for querying MySQL
 */
class DataAccess 
{
    /**
    * Private
    * $db stores a database resource
    */
    var $db;
 
    /**
    * Constucts a new DataAccess object
    * @param $host string hostname for dbserver
    * @param $user string dbserver user
    * @param $pass string dbserver user password
    * @param $db string database name
    */
    function DataAccess ($host,$user,$pass,$db) 
	{
        $this->db=mysql_pconnect($host,$user,$pass);
        mysql_select_db($db,$this->db);
    }
 
    /**
    * Fetches a query resources and stores it in a local member
    * @param $sql string the database query to run
    * @return object result
    */
    function & exec($sql) 
	{
        if ( $result=mysql_query($sql,$this->db) )
            return $result;
        else
            return false;
    }
 
    /**
    * Returns any MySQL errors
    * @return string a MySQL error
    */
    function isError () 
	{
        return mysql_error($this->db);
    }
}

?>