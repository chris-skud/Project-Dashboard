<?php
require_once("DataAccess.php");
require_once("Dao.php");
/**
 *  Data Access Object for status category tables
 */
class StatusCategoryDao extends Dao 
{
    /**
    * Constructs the StatusCategory
    * @param $da instance of the DataAccess class
    */
    function StatusCategoryDao ( & $da ) 
	{
        Dao::Dao($da);
    }
 
    /**
    * Gets all status cats
    * @return object a result object
    */
    function & GetStatusChangeCategoryItems () 
	{
        $sql="SELECT * FROM statuschangecategory ORDER BY sort_order ASC"; // could be interesting to keep the order correct.
        return $this->select($sql);
    }
	
	function & GetStatusChangeCategoryShortNameById ($category_change_id) 
	{
		$sql="SELECT shortname FROM statuschangecategory WHERE statuschangecategory_id = ".$category_change_id; // could be interesting to keep the order correct.
		return $this->select($sql);
	}
	
	/**
    * Gets all change status cats
    * @return object a result object
    */
    function & GetStatusCategoryItems () 
	{
        $sql="SELECT * FROM statuscategory  ORDER BY sort_order ASC"; // could be interesting to keep the order correct.
        return $this->select($sql);
    }
	
	function & GetStatusCategoryShortNameById ($status_category_id) 
	{
        $sql="SELECT shortname FROM statuscategory where statuscategory_id = ".$status_category_id; // could be interesting to keep the order correct.
        return $this->select($sql);
    }
	
	function & TotalRows () {
        $sql="SELECT count(*) as count FROM statuslookup";
        return $this->select($sql);
    }
}
?>