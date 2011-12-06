<?php
require_once("DbConfig.php");
require_once("SnapshotDao.php");
require_once("DataAccess.php");
/**
 *  Business logic and some data modeling
 */
class SnapshotSvc {
    /**
    * Private
    * $dao stores data access object
    */
    var $dao; 
 
     
    /**
    * Constructs the SnapshotSvc
    * @param $da instance of the DataAccess class
    */
    function SnapshotSvc () 
	{
        $dbConfig = new DbConfig();
		$da = new DataAccess($dbConfig->host,$dbConfig->user,$dbConfig->pass,$dbConfig->db);
		$this->dao=& new SnapshotDao($da);
    }
 
 
	/**
    * Gets the current snapshot (most recent status)
    * @param project_$id 
    * @return snapshot object
    */
    function GetCurrentSnapshotForProjectId ($project_id) 
	{
        $snapshotArray = $this->dao->GetCurrentItem($project_id);
		return (object)$snapshotArray[0];
    }
	
 	/**
    * Get Snapshot for Project
    * @return new snapshot id
    */
    function GetActiveSnapshotsForProject ($project_id) 
	{
		// get the db records
		$a = $this->dao->GetActiveItemsForProject($project_id);
		
		// convert into array of objects (vs. just multi-dim array)
		// so we provide a nice interface (eg "ObjCollection[0]->member")
		$objColl = array();
		for($i = 0, $size = sizeof($a); $i < $size; ++$i)
		{			
			$objColl[] = (object)$a[$i];
		}
		return $objColl;
	}
	
	/**
    * Create Snapshot
    * @return new snapshot id
    */
    function CreateSnapshot ($snapshot) 
	{
		return $this->dao->SaveItem($snapshot);
	}
	
	/**
    * Update Snapshot
    * @return new snapshot id
    */
    function UpdateSnapshot ($snapshot) 
	{
		if ((isset($snapshot->snapshot_id)) && ($snapshot->snapshot_id > 0))
		{
			return $this->dao->SaveItem($snapshot);
		}
		else
		{
			trigger_error("No Snapshot ID was provided for update.");
		}
	}
	
	/**
    * Delete Snapshot
    * @return snapshot id
    */
    function DeleteSnapshot ($snapshot) 
	{
		if ((isset($snapshot->snapshot_id)) && ($snapshot->snapshot_id > 0))
		{
			// soft delete
			$snapshot->is_active = 0;
			return $this->UpdateSnapshot($snapshot);
		}
		else
		{
			trigger_error("No Snapshot ID was provided for update.");
		}
	}
	
    /**
    * Gets a snapshotCollection set
    * @return void
    */
    function GetAllActiveSnapshots () 
	{
		return $this->dao->GetAllItems();
	}
 
 
    /**
    * Gets a single Snapshot row by it's id
    * @param $id of the Snapshot row
    * @return void
    */
    function GetSnapshotById ($id) 
	{
        $snapshotArray = $this->dao->GetItem($id);
		return (object)$snapshotArray[0];
    }
}
?>