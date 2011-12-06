<?php
require_once("DbConfig.php");
require_once("StatusCategoryDao.php");
require_once("DataAccess.php");
/**
 *  Business logic and some data modeling
 */
class StatusCategorySvc {
    /**
    * Private
    * $dao stores data access object
    */
    var $dao; 
 
     
    /**
    * Constructs the StatusCategorySvc
    * @param $da instance of the DataAccess class
    */
    function StatusCategorySvc () 
	{
        $dbConfig = new DbConfig();
		$da = new DataAccess($dbConfig->host,$dbConfig->user,$dbConfig->pass,$dbConfig->db);
		$this->dao=& new StatusCategoryDao($da);
    }
 
    function GetStatusChangeCategoryItems () 
	{
        // get the db records
		return $this->dao->GetStatusChangeCategoryItems();
    }
	
	function GetStatusChangeCategoryShortNameById ($category_change_id) 
	{
        // get the db records
		$tmp = $this->dao->GetStatusChangeCategoryShortNameById($category_change_id);
		return (object)$tmp[0];
    }
	
    function GetStatusCategoryItems () 
	{
		// get the db records
		return $this->dao->GetStatusCategoryItems();
	}
	
	function GetStatusCategoryShortNameById($status_category_id)
	{
		// get the db records
		$tmp = $this->dao->GetStatusCategoryShortnameById($status_category_id);
		return (object)$tmp[0];
	}
	/**
    * Create Snapshot
    * @return new status id
    */
    function CreateSnapshot ($status) 
	{
		//stub
	}
	
	/**
    * Update Snapshot
    * @return new status id
    */
    function UpdateSnapshot ($status) 
	{
		//stub
	}
	
	/**
    * Delete Snapshot
    * @return status id
    */
    function DeleteSnapshot ($status) 
	{
		//stub
	}
	
    
}
?>