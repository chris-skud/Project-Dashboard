<?php
require_once("DbConfig.php");
require_once("ProjectDao.php");
require_once("DataAccess.php");

/**
 *  Business logic and some data modeling
 */
class ProjectSvc {
    /**
    * Private
    * $dao stores data access object
    */
    var $dao; 
 
     
    /**
    * Constructs the ProjectSvc
    * @param $da instance of the DataAccess class
    */
    function ProjectSvc () 
	{
        $dbConfig = new DbConfig();
		$da = new DataAccess($dbConfig->host,$dbConfig->user,$dbConfig->pass,$dbConfig->db);
		$this->dao=& new ProjectDao($da);
    }
 
 	/**
    * Create Project
    * @return new project id
    */
    function CreateProject ($project) 
	{
		return $this->dao->SaveItem($project);
	}
	
	/**
    * Update Project
    * @return new project id
    */
    function UpdateProject ($project) 
	{
		if (isset($project->project_id) && $project->project_id > 0)
			return $this->dao->SaveItem($project);
		else
			trigger_error("No Project ID was provided for update.");
	}
	
	/**
    * Delete Project
    * @return project id
    */
    function DeleteProject ($project) 
	{
		if (isset($project["is_active"]) && $project["is_active"] == 0)
		{
			// soft delete
			return $this->UpdateProject($project);
		}
		else
		{
			trigger_error("No Project ID was provided for update.");
		}
	}
	
    /**
    * Gets a projectCollection set
    * @return void
    */
    function GetActiveProjectsByProduct ($product_id) 
	{
		$a = $this->dao->GetActiveProjectsByProduct($product_id);
		// convert into array of objects (vs. just multi-dim array)
		// so we provide a nice interface (eg "ObjCollection[0]->member")
		$projectArr = array();
		for($i = 0, $size = sizeof($a); $i < $size; ++$i)
		{			
			$projectArr[] = (object)$a[$i];
		}
		return $projectArr;
	}
 
 
    /**
    * Gets a single Project row by it's id
    * @param $id of the Project row
    * @return void
    */
    function GetProjectById ($id) 
	{
        $projectArray = $this->dao->GetItem($id);
		return (object)$projectArray[0];
    }
}
?>