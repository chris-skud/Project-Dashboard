<?php
require_once("DataAccess.php");
require_once("Dao.php");
/**
 *  Data Access Object for Project Table
 */
class ProjectDao extends Dao 
{
    /**
    * Constructs the Project
    * @param $da instance of the DataAccess class
    */
    function ProjectDao ( & $da ) 
	{
        Dao::Dao($da);
    }
 
    /**
    * Gets all active projects
    * @return object a result object
    */
    function & GetActiveProjectsByProduct ($product_id) 
	{
        $sql="SELECT * FROM project WHERE is_active = true AND product_id = ".$product_id." ORDER BY project_name DESC";
        return $this->select($sql);
    }
 
     
    /**
    * Get a project by id
    * @return object a result object
    */
    function & GetItem ($id) 
	{
        $sql="SELECT * FROM project WHERE project_id='".$id."' AND is_active = true";
        return $this->select($sql);
    }

	/**
    * Save a project.  Handles inserts and updates
    * @return object a result object
    */
	function SaveItem ($project)
	{
		if ($project->project_id < 1)
			$sql="INSERT INTO project (product_id, project_name, product_manager
			, project_manager, dev_team, dev_team_size, qa_team_size, iteration0_start_date
			,iteration1_start_date, target_release_date, committed_release_date, iteration_release_date_committed
			,time_updated,time_created) 
			VALUES (".$project->product_id.", '".$project->project_name."', '".$project->product_manager."', '".$project->project_manager."', '".$project->dev_team."'
			,".$project->dev_team_size.", ".$project->qa_team_size.", '".$project->iteration0_start_date."'
			, '".$project->iteration1_start_date."', '".$project->target_release_date."', '".$project->committed_release_date."'
			, ".$project->iteration_release_date_committed." , NULL, NULL)";
		else
			$sql="UPDATE project SET 
				product_id = ".$project->product_id.",
				project_name = '".$project->project_name."',
				is_active = ".$project->is_active.",
				product_manager = '".$project->product_manager."',
				project_manager = '".$project->project_manager."',
				dev_team = '".$project->dev_team."',
				dev_team_size = ".$project->dev_team_size.",
				qa_team_size = ".$project->qa_team_size.",
				iteration0_start_date = '".$project->iteration0_start_date."',
				iteration1_start_date = '".$project->iteration1_start_date."',
				target_release_date = '".$project->target_release_date."',
				committed_release_date = '".$project->committed_release_date."',
				iteration_release_date_committed = '".$project->iteration_release_date_committed."'
			WHERE project_id = ".$project->project_id;
		
		return $this->update($sql);
		
	}
	
    function & TotalRows () {
        $sql="SELECT count(*) as count FROM project";
        return $this->select($sql);
    }
}
?>