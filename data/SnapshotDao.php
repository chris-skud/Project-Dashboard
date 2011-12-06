<?php
require_once("DataAccess.php");
require_once("Dao.php");
/**
 *  Data Access Object for Snapshot Table
 */
class SnapshotDao extends Dao 
{
    /**
    * Constructs the Snapshot
    * @param $da instance of the DataAccess class
    */
    function SnapshotDao ( & $da ) 
	{
        Dao::Dao($da);
    }
 
    /**
    * Gets all active snapshots
    * @return object a result object
    */
    function & GetAllItems () 
	{
        $sql="SELECT * FROM snapshot WHERE is_active = 1 ORDER BY snapshot_id DESC"; // could be interesting to keep the order correct.
        return $this->select($sql);
    }
	
	/**
    * Gets current snapshots for a given project
    * @return object a result object
    */
    function & GetCurrentItem ($project_id) 
	{
        $sql="SELECT DISTINCT * FROM snapshot WHERE project_id = ".$project_id." AND is_active = 1 ORDER BY snapshot_id DESC LIMIT 1";
        return $this->select($sql);
    }
	
	
	/**
    * Gets active snapshots for a given project
    * @return object a result object
    */
    function & GetActiveItemsForProject ($project_id) 
	{
        $sql="SELECT * FROM snapshot WHERE project_id = ".$project_id." AND is_active = 1 ORDER BY snapshot_id DESC"; // could be interesting to keep the order correct.
        return $this->select($sql);
    }
    
    /**
    * Get a snapshot by id
    * @return object a result object
    */
    function & GetItem ($id) 
	{
        $sql="SELECT * FROM snapshot WHERE snapshot_id=".$id;
        return $this->select($sql);
    }

	/**
    * Save a snapshot.  Handles inserts and updates
    * @return object a result object
    */
	function SaveItem ($snapshot)
	{
		$sql = "";
		if ($snapshot->snapshot_id < 1)
		{
			$sql="INSERT INTO snapshot (project_id, snapshot_name, status_change_id
			, release_status_id, budget_status_id, risk_status_id, status_description, additional_details
			,highlights, issues_risks_strategies, time_updated, time_created) 
			VALUES (".$snapshot->project_id.", '".$snapshot->snapshot_name."', ".$snapshot->status_change_id."
			,".$snapshot->release_status_id.", ".$snapshot->budget_status_id.", ".$snapshot->risk_status_id."
			, '".$snapshot->status_description."', '".$snapshot->additional_details."', '".$snapshot->highlights."'
			, '".$snapshot->issues_risks_strategies."' , NULL, NULL)";
			
		}
		else
		{
			
			$sql="UPDATE snapshot SET 
				project_id = ".$snapshot->project_id.",
				snapshot_name = '".$snapshot->snapshot_name."',
				status_change_id = ".$snapshot->status_change_id.",
				release_status_id = ".$snapshot->release_status_id.",
				budget_status_id = ".$snapshot->budget_status_id.",
				risk_status_id = ".$snapshot->risk_status_id.",
				status_description = '".$snapshot->status_description."',
				additional_details = '".$snapshot->additional_details."',
				highlights = '".$snapshot->highlights."',
				issues_risks_strategies = '".$snapshot->issues_risks_strategies."'
			WHERE snapshot_id = ".$snapshot->snapshot_id;
		}
		return $this->update($sql);
	}
	
	function & TotalRows () {
        $sql="SELECT count(*) as count FROM snapshot";
        return $this->select($sql);
    }
}
?>