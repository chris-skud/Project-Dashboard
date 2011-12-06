<?php
/**
 *  Base class for data access objects
 */
class Dao 
{
    /**
    * Private
    * $da stores data access object
    */
    var $da;
 
    /**
    * Constructs the Dao
    * @param $da instance of the DataAccess class
    */
    function Dao ( & $da ) 
	{
        $this->da=$da;
    }
 
    /**
    * For SELECT queries
    * @param $sql the query string
    * @return mixed either false if error or object DataAccessResult
    */
    function & select ($sql) 
	{
        $result=& $this->da->exec($sql);
        $arr = array();
		if (!$result) 
		{
            trigger_error($this->da->isError()." ".$sql);
			print $sql;
            return false;
        } 
		else 
		{
			if (mysql_num_rows($result) > 0)
			{
				$x=0;
					// iterate through resultset
					while($row = mysql_fetch_row($result))
					{
						foreach($row as $i => $value) {
							$column = mysql_field_name($result,$i);
							$data["$column"] = $value;
							$arr[$x] = $data;
						}
						$x++;
					}
			}
		return $arr;
        }
    }
 
    /**
    * For INSERT, UPDATE and DELETE queries
    * @param $sql the query string
    * @return boolean true if success
    */
    function update ($sql) 
	{
        $result=$this->da->exec($sql);
        if (!$result) 
		{
            trigger_error($this->da->isError());
			//trigger_error($mysql_error);
            return false;
        } 
		else 
		{
            // return inserted id if it was insert or 0 otherwise
			return mysql_insert_id();
		}
    }
}
?>