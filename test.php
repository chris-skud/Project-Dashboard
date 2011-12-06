<?php
require_once("dbUtils.php");
require_once("ProjectDao.php");
require_once("ProjectSvc.php");
$ProjectDao = new ProjectDao($dataAccess);
$ProjectSvc = new ProjectSvc($ProjectDao);

/*
$project["project_id"] = 2;
$project["product_id"] = 1;
$project["project_name"] = "Blah";
$project["is_active"] = 0;
$project["product_manager"] = "Art Gillson";
$project["project_manager"] = "Tim Brown";
$project["dev_team"] = "Black";
$project["dev_team_size"] = 4;
$project["qa_team_size"] = 2;
$project["iteration0_start_date"] = "12/4/2008";
$project["iteration1_start_date"] = "12/4/2008";
$project["target_release_date"] = "12/4/2008";
$project["committed_release_date"] = "12/4/2008";
$project["iteration_release_date_committed"] = 5;
//print_r($ProjectSvc->UpdateProject($project));
*/

$project = $ProjectSvc->GetProjectById(1);
echo $project->project_manager." -- ".$project->product_manager;
?>