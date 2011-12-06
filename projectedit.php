<?php
require_once("ProjectSvc.php");
require_once("PortfolioSvc.php");
require_once("ProductSvc.php");
require_once("utils.php");
$projectSvc = new ProjectSvc();
$portfolioSvc = new PortfolioSvc();
$productSvc = new ProductSvc();
$request = htmlEncodeRequest($_REQUEST);
$project;
if ($request["is_update"] == true)
{
	$projectSvc->UpdateProject((object)$request);
}

if ($request["project_id"])
{
	$project = $projectSvc->GetProjectById((int)$_REQUEST["project_id"]);
	$project->product = $productSvc->GetProductById($project->product_id);
	$project->portfolio = $portfolioSvc->GetPortfolioById($project->product->portfolio_id);
	
}
else
{
	print "bad request.  i need a project_id in the request to render this page.";
	exit;
}

$activePortfolios = $portfolioSvc->GetAllActivePortfolios();
$activeProducts = $productSvc->GetProductsByPortfolio($project->product->product_id);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Product/Program Status</title>
<LINK REL="stylesheet" HREF="style.css">
</head>
<body>

<form name="editProject" id="editProject" action="projectedit.php" method="post">
<input type="hidden" name="project_id" value="<?=$request['project_id']?>">
<input id="is_update" type="hidden" name="is_update" value="true">
<input id="is_active" type="hidden" name="is_active" value="1">
<h1><?=$project->project_name?>: Edit</h1> 
<div class="buttonlist">
		<ul>
			<li><input type="button" value="Save Changes" onclick="this.form.submit()"></li>
			<li><input type="button" value="Cancel" onclick="location.href='projectedit.php'"></li>
		</ul>
</div> 
<div class="editBox">
	<div class="normal_form">
		<div>
            <label for="portfolio_id">Portfolio:</label>
            <select name="portfolio_name" id="portfolio_name">
				<option></option>
				<?php
					foreach ($activePortfolios as $portfolio)
					{
						if ($portfolio->portfolio_id == $project->portfolio->portfolio_id)
							print '<option id="'.$portfolio->portfolio_id.'" value="'.$portfolio->portfolio_id.'" selected>'.$portfolio->portfolio_name.'</option>';
						else
							print '<option id="'.$portfolio->portfolio_id.'" value="'.$portfolio->portfolio_id.'">'.$portfolio->portfolio_name.'</option>';
					}
				?>
			</select>
        </div>
		<div>
            <label for="product_id">Product / Program:</label>
            <select name="product_id" id="product_id">
				<option></option>
				<?php
					foreach ($activeProducts as $product)
					{
						if ($product->product_id == $project->product->product_id)
							print '<option id="'.$product->product_id.'" value="'.$product->product_id.'" selected>'.$product->product_name.'</option>';
						else
							print '<option id="'.$product->product_id.'" value="'.$product->product_id.'">'.$product->product_name.'</option>';
					}
				?>
			</select>
        </div>
		<div>
            <label for="project_name">Project Name:</label>
            <input type="text" name="project_name" id="project_name" style="width:300px;" maxlength="100" value="<?=$project->project_name?>">
        </div>
		<div>
            <label for="product_manager">Product Manager:</label>
            <input type="text" name="product_manager" id="product_manager" style="width:300px;" maxlength="100" value="<?=$project->product_manager?>">
        </div>
		<div>
            <label for="project_manager">Project Manager:</label>
            <input type="text" name="project_manager" id="project_manager" style="width:300px;" maxlength="100" value="<?=$project->project_manager?>">
        </div>
		<div>
            <label for="dev_team">Dev Team:</label>
            <input type="text" name="dev_team" id="dev_team" style="width:300px;" maxlength="100" value="<?=$project->dev_team?>">
        </div>
		<div>
            <label for="dev_team_size">Team Size:</label>
            # Devs: <input type="text" name="dev_team_size" id="dev_team_size" style="width:25px;" maxlength="3" value="<?=$project->dev_team_size?>">&nbsp;&nbsp;# QA: <input type="text" name="qa_team_size" id="qa_team_size" style="width:25px;" maxlength="3" value="<?=$project->qa_team_size?>">
        </div>
		<div>
            <label for="iteration0_start_date">Iteration Zero Start Date:</label>
           <input type="text" name="iteration0_start_date" id="iteration0_start_date" style="width:150px;" maxlength="40" value="<?=$project->iteration0_start_date?>"> MM/DD/YYYY
        </div>
		<div>
            <label for="iteration1_start_date">Iteration One Start Date:</label>
           <input type="text" name="iteration1_start_date" id="iteration1_start_date" style="width:150px;" maxlength="40" value="<?=$project->iteration1_start_date?>"> MM/DD/YYYY
        </div>
		<div>
            <label for="target_release_date">Target Release Date:</label>
           <input type="text" name="target_release_date" id="target_release_date" style="width:300px;" maxlength="40" value="<?=$project->target_release_date?>">
        </div>
		<div>
            <label for="committed_release_date">Commit Release Date:</label>
           <input type="text" name="committed_release_date" id="committed_release_date" style="width:300px;" maxlength="40" value="<?=$project->committed_release_date?>">
        </div>
		<div>
            <label for="iteration_release_date_committed">Committed in Iteration #:</label>
           <input type="text" name="iteration_release_date_committed" id="iteration_release_date_committed" style="width:25px;" maxlength="3" value="<?=$project->iteration_release_date_committed?>">
        </div>
	</div>
</div>
<div class="editBox">
	
	<div class="normal_form">
		<div>
            <label for="showIteration1">Iteration 1:</label>
            <input type="checkbox" name="showIteration1" id="showIteration1">Display in project view
		</div>
		<div>
			<label for="Iteration1Status">&nbsp;&nbsp;I-1 Status:</label>
			Release <select id="iteration1Release" name="iteration1Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration1Budget" name="iteration1Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration1Risk" name="iteration1Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration1End">&nbsp;&nbsp;I-1 End Date:</label>
			<input type="text" name="Iteration1End" id="Iteration1End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration1Velocity">&nbsp;&nbsp;I-1 Velocity:</label>
            Target: <input type="text" name="Iteration1TargetVelocity" id="Iteration1TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration1ActualVelocity" id="Iteration1ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration1Defects">&nbsp;&nbsp;I-1 Defects:</label>
            <input type="text" name="Iteration1Defects" id="Iteration1Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration1Grade">&nbsp;&nbsp;I-1 Grade:</label>
            <input type="text" name="Iteration1Grade" id="Iteration1Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration1RallyURL">&nbsp;&nbsp;I-1 Rally URL:</label>
            <input type="text" name="Iteration1RallyURL" id="Iteration1RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration2">Iteration 2:</label>
            <input type="checkbox" name="showIteration2" id="showIteration2">Display in project view
		</div>
		<div>
			<label for="Iteration2Status">&nbsp;&nbsp;I-2 Status:</label>
            Release <select id="iteration2Release" name="iteration2Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration2Budget" name="iteration2Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration2Risk" name="iteration2Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration2End">&nbsp;&nbsp;I-2 End Date:</label>
			<input type="text" name="Iteration2End" id="Iteration2End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration2Velocity">&nbsp;&nbsp;I-2 Velocity:</label>
            Target: <input type="text" name="Iteration2TargetVelocity" id="Iteration2TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration1ActualVelocity" id="Iteration1ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration2Defects">&nbsp;&nbsp;I-2 Defects:</label>
            <input type="text" name="Iteration2Defects" id="Iteration2Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration2Grade">&nbsp;&nbsp;I-2 Grade:</label>
            <input type="text" name="Iteration2Grade" id="Iteration2Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration2RallyURL">&nbsp;&nbsp;I-2 Rally URL:</label>
            <input type="text" name="Iteration2RallyURL" id="Iteration2RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration3">Iteration 3:</label>
            <input type="checkbox" name="showIteration3" id="showIteration3">Display in project view
		</div>
		<div>
			<label for="Iteration3Status">&nbsp;&nbsp;I-3 Status:</label>
            Release <select id="iteration3Release" name="iteration3Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration3Budget" name="iteration3Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration3Risk" name="iteration3Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration3End">&nbsp;&nbsp;I-3 End Date:</label>
			<input type="text" name="Iteration3End" id="Iteration3End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration3Velocity">&nbsp;&nbsp;I-3 Velocity:</label>
            Target: <input type="text" name="Iteration3TargetVelocity" id="Iteration3TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration3ActualVelocity" id="Iteration3ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration3Defects">&nbsp;&nbsp;I-3 Defects:</label>
            <input type="text" name="Iteration3Defects" id="Iteration3Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration3Grade">&nbsp;&nbsp;I-3 Grade:</label>
            <input type="text" name="Iteration3Grade" id="Iteration3Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration3RallyURL">&nbsp;&nbsp;I-3 Rally URL:</label>
            <input type="text" name="Iteration3RallyURL" id="Iteration3RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration4">Iteration 4:</label>
            <input type="checkbox" name="showIteration4" id="showIteration4">Display in project view
		</div>
		<div>
			<label for="Iteration4Status">&nbsp;&nbsp;I-4 Status:</label>
            Release <select id="iteration4Release" name="iteration4Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration4Budget" name="iteration4Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration4Risk" name="iteration4Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration4End">&nbsp;&nbsp;I-4 End Date:</label>
			<input type="text" name="Iteration4End" id="Iteration4End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration4Velocity">&nbsp;&nbsp;I-4 Velocity:</label>
            Target: <input type="text" name="Iteration4TargetVelocity" id="Iteration4TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration4ActualVelocity" id="Iteration4ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration4Defects">&nbsp;&nbsp;I-4 Defects:</label>
            <input type="text" name="Iteration4Defects" id="Iteration4Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration4Grade">&nbsp;&nbsp;I-4 Grade:</label>
            <input type="text" name="Iteration4Grade" id="Iteration4Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration4RallyURL">&nbsp;&nbsp;I-4 Rally URL:</label>
            <input type="text" name="Iteration4RallyURL" id="Iteration4RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration5">Iteration 5:</label>
            <input type="checkbox" name="showIteration5" id="showIteration5">Display in project view
		</div>
		<div>
			<label for="Iteration5Status">&nbsp;&nbsp;I-5 Status:</label>
            Release <select id="iteration5Release" name="iteration5Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration5Budget" name="iteration5Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration5Risk" name="iteration5Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration5End">&nbsp;&nbsp;I-5 End Date:</label>
			<input type="text" name="Iteration5End" id="Iteration5End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration5Velocity">&nbsp;&nbsp;I-5 Velocity:</label>
            Target: <input type="text" name="Iteration5TargetVelocity" id="Iteration5TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration5ActualVelocity" id="Iteration5ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration5Defects">&nbsp;&nbsp;I-5 Defects:</label>
            <input type="text" name="Iteration5Defects" id="Iteration5Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration5Grade">&nbsp;&nbsp;I-5 Grade:</label>
            <input type="text" name="Iteration5Grade" id="Iteration5Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration5RallyURL">&nbsp;&nbsp;I-5 Rally URL:</label>
            <input type="text" name="Iteration5RallyURL" id="Iteration5RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration6">Iteration 6:</label>
            <input type="checkbox" name="showIteration6" id="showIteration6">Display in project view
		</div>
		<div>
			<label for="Iteration6Status">&nbsp;&nbsp;I-6 Status:</label>
            Release <select id="iteration6Release" name="iteration6Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration6Budget" name="iteration6Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration6Risk" name="iteration6Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration6End">&nbsp;&nbsp;I-6 End Date:</label>
			<input type="text" name="Iteration6End" id="Iteration6End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration6Velocity">&nbsp;&nbsp;I-6 Velocity:</label>
            Target: <input type="text" name="Iteration6TargetVelocity" id="Iteration6TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration6ActualVelocity" id="Iteration6ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration6Defects">&nbsp;&nbsp;I-6 Defects:</label>
            <input type="text" name="Iteration6Defects" id="Iteration6Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration6Grade">&nbsp;&nbsp;I-6 Grade:</label>
            <input type="text" name="Iteration6Grade" id="Iteration6Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration6RallyURL">&nbsp;&nbsp;I-6 Rally URL:</label>
            <input type="text" name="Iteration6RallyURL" id="Iteration6RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration7">Iteration 7:</label>
            <input type="checkbox" name="showIteration7" id="showIteration7">Display in project view
		</div>
		<div>
			<label for="Iteration7Status">&nbsp;&nbsp;I-7 Status:</label>
            Release <select id="iteration7Release" name="iteration7Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration7Budget" name="iteration7Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration7Risk" name="iteration7Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration7End">&nbsp;&nbsp;I-7 End Date:</label>
			<input type="text" name="Iteration7End" id="Iteration7End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration7Velocity">&nbsp;&nbsp;I-7 Velocity:</label>
            Target: <input type="text" name="Iteration7TargetVelocity" id="Iteration7TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration7ActualVelocity" id="Iteration7ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration7Defects">&nbsp;&nbsp;I-7 Defects:</label>
            <input type="text" name="Iteration7Defects" id="Iteration7Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration7Grade">&nbsp;&nbsp;I-7 Grade:</label>
            <input type="text" name="Iteration7Grade" id="Iteration7Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration7RallyURL">&nbsp;&nbsp;I-7 Rally URL:</label>
            <input type="text" name="Iteration7RallyURL" id="Iteration7RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration8">Iteration 8:</label>
            <input type="checkbox" name="showIteration8" id="showIteration8">Display in project view
		</div>
		<div>
			<label for="Iteration8Status">&nbsp;&nbsp;I-8 Status:</label>
            Release <select id="iteration8Release" name="iteration8Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration8Budget" name="iteration8Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration8Risk" name="iteration8Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration8End">&nbsp;&nbsp;I-8 End Date:</label>
			<input type="text" name="Iteration8End" id="Iteration8End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration8Velocity">&nbsp;&nbsp;I-8 Velocity:</label>
            Target: <input type="text" name="Iteration8TargetVelocity" id="Iteration8TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration8ActualVelocity" id="Iteration8ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration8Defects">&nbsp;&nbsp;I-8 Defects:</label>
            <input type="text" name="Iteration8Defects" id="Iteration8Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration8Grade">&nbsp;&nbsp;I-8 Grade:</label>
            <input type="text" name="Iteration8Grade" id="Iteration8Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration8RallyURL">&nbsp;&nbsp;I-8 Rally URL:</label>
            <input type="text" name="Iteration8RallyURL" id="Iteration8RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration9">Iteration 9:</label>
            <input type="checkbox" name="showIteration9" id="showIteration9">Display in project view
		</div>
		<div>
			<label for="Iteration9Status">&nbsp;&nbsp;I-9 Status:</label>
            Release <select id="iteration9Release" name="iteration9Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration9Budget" name="iteration9Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration9Risk" name="iteration9Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration9End">&nbsp;&nbsp;I-9 End Date:</label>
			<input type="text" name="Iteration9End" id="Iteration9End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration9Velocity">&nbsp;&nbsp;I-9 Velocity:</label>
            Target: <input type="text" name="Iteration9TargetVelocity" id="Iteration9TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration9ActualVelocity" id="Iteration9ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration9Defects">&nbsp;&nbsp;I-9 Defects:</label>
            <input type="text" name="Iteration9Defects" id="Iteration9Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration9Grade">&nbsp;&nbsp;I-9 Grade:</label>
            <input type="text" name="Iteration9Grade" id="Iteration9Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration9RallyURL">&nbsp;&nbsp;I-9 Rally URL:</label>
            <input type="text" name="Iteration9RallyURL" id="Iteration9RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration10">Iteration 10:</label>
            <input type="checkbox" name="showIteration10" id="showIteration10">Display in project view
		</div>
		<div>
			<label for="Iteration10Status">&nbsp;&nbsp;I-10 Status:</label>
            Release <select id="iteration10Release" name="iteration10Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration10Budget" name="iteration10Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration10Risk" name="iteration10Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration10End">&nbsp;&nbsp;I-10 End Date:</label>
			<input type="text" name="Iteration10End" id="Iteration10End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration10Velocity">&nbsp;&nbsp;I-10 Velocity:</label>
            Target: <input type="text" name="Iteration10TargetVelocity" id="Iteration10TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration10ActualVelocity" id="Iteration10ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration10Defects">&nbsp;&nbsp;I-10 Defects:</label>
            <input type="text" name="Iteration10Defects" id="Iteration10Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration10Grade">&nbsp;&nbsp;I-10 Grade:</label>
            <input type="text" name="Iteration10Grade" id="Iteration10Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration10RallyURL">&nbsp;&nbsp;I-10 Rally URL:</label>
            <input type="text" name="Iteration10RallyURL" id="Iteration10RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration11">Iteration 11:</label>
            <input type="checkbox" name="showIteration11" id="showIteration11">Display in project view
		</div>
		<div>
			<label for="Iteration11Status">&nbsp;&nbsp;I-11 Status:</label>
            Release <select id="iteration11Release" name="iteration11Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration11Budget" name="iteration11Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration11Risk" name="iteration11Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration11End">&nbsp;&nbsp;I-11 End Date:</label>
			<input type="text" name="Iteration11End" id="Iteration11End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration11Velocity">&nbsp;&nbsp;I-11 Velocity:</label>
            Target: <input type="text" name="Iteration11TargetVelocity" id="Iteration11TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration11ActualVelocity" id="Iteration11ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration11Defects">&nbsp;&nbsp;I-11 Defects:</label>
            <input type="text" name="Iteration11Defects" id="Iteration11Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration11Grade">&nbsp;&nbsp;I-11 Grade:</label>
            <input type="text" name="Iteration11Grade" id="Iteration11Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration11RallyURL">&nbsp;&nbsp;I-11 Rally URL:</label>
            <input type="text" name="Iteration11RallyURL" id="Iteration11RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration12">Iteration 12:</label>
            <input type="checkbox" name="showIteration12" id="showIteration12">Display in project view
		</div>
		<div>
			<label for="Iteration3Status">&nbsp;&nbsp;I-12 Status:</label>
            Release <select id="iteration12Release" name="iteration12Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration12Budget" name="iteration12Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration12Risk" name="iteration12Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration12End">&nbsp;&nbsp;I-12 End Date:</label>
			<input type="text" name="Iteration12End" id="Iteration12End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration12Velocity">&nbsp;&nbsp;I-12 Velocity:</label>
            Target: <input type="text" name="Iteration12TargetVelocity" id="Iteration12TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration12ActualVelocity" id="Iteration12ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration12Defects">&nbsp;&nbsp;I-12 Defects:</label>
            <input type="text" name="Iteration12Defects" id="Iteration12Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration12Grade">&nbsp;&nbsp;I-12 Grade:</label>
            <input type="text" name="Iteration12Grade" id="Iteration12Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration12RallyURL">&nbsp;&nbsp;I-12 Rally URL:</label>
            <input type="text" name="Iteration12RallyURL" id="Iteration12RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration13">Iteration 13:</label>
            <input type="checkbox" name="showIteration13" id="showIteration13">Display in project view
		</div>
		<div>
			<label for="Iteration13Status">&nbsp;&nbsp;I-13 Status:</label>
            Release <select id="iteration13Release" name="iteration13Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration13Budget" name="iteration13Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration13Risk" name="iteration13Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration13End">&nbsp;&nbsp;I-13 End Date:</label>
			<input type="text" name="Iteration13End" id="Iteration13End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration13Velocity">&nbsp;&nbsp;I-13 Velocity:</label>
            Target: <input type="text" name="Iteration13TargetVelocity" id="Iteration13TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration13ActualVelocity" id="Iteration13ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration13Defects">&nbsp;&nbsp;I-13 Defects:</label>
            <input type="text" name="Iteration13Defects" id="Iteration13Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration13Grade">&nbsp;&nbsp;I-13 Grade:</label>
            <input type="text" name="Iteration13Grade" id="Iteration13Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration13RallyURL">&nbsp;&nbsp;I-13 Rally URL:</label>
            <input type="text" name="Iteration13RallyURL" id="Iteration13RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration14">Iteration 14:</label>
            <input type="checkbox" name="showIteration14" id="showIteration14">Display in project view
		</div>
		<div>
			<label for="Iteration3Status">&nbsp;&nbsp;I-14 Status:</label>
            Release <select id="iteration14Release" name="iteration14Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration14Budget" name="iteration14Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration14Risk" name="iteration14Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration3End">&nbsp;&nbsp;I-14 End Date:</label>
			<input type="text" name="Iteration14End" id="Iteration14End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration14Velocity">&nbsp;&nbsp;I-14 Velocity:</label>
            Target: <input type="text" name="Iteration14TargetVelocity" id="Iteration14TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration14ActualVelocity" id="Iteration14ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration14Defects">&nbsp;&nbsp;I-14 Defects:</label>
            <input type="text" name="Iteration14Defects" id="Iteration14Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration14Grade">&nbsp;&nbsp;I-14 Grade:</label>
            <input type="text" name="Iteration14Grade" id="Iteration14Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration14RallyURL">&nbsp;&nbsp;I-14 Rally URL:</label>
            <input type="text" name="Iteration14RallyURL" id="Iteration14RallyURL" style="width:300px;" maxlength="255">
        </div>
		<BR>
		<div>
            <label for="showIteration15">Iteration 15:</label>
            <input type="checkbox" name="showIteration15" id="showIteration15">Display in project view
		</div>
		<div>
			<label for="Iteration15Status">&nbsp;&nbsp;I-15 Status:</label>
            Release <select id="iteration15Release" name="iteration15Release"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Budget <select id="iteration15Budget" name="iteration15Budget"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>&nbsp;&nbsp;
			Risk <select id="iteration15Risk" name="iteration15Risk"><option></option><option>TBD</option><option>N/A</option><option>Green</option><option>Yellow</option><option>Red</option></select>
		</div>
		<div>
            <label for="Iteration15End">&nbsp;&nbsp;I-15 End Date:</label>
			<input type="text" name="Iteration15End" id="Iteration15End" style="width:150px;" maxlength="40"> MM/DD/YYYY
        </div>
		<div>
            <label for="Iteration15Velocity">&nbsp;&nbsp;I-15 Velocity:</label>
            Target: <input type="text" name="Iteration15TargetVelocity" id="Iteration15TargetVelocity" style="width:25px;" maxlength="3">&nbsp;&nbsp;Actual: <input type="text" name="Iteration15ActualVelocity" id="Iteration15ActualVelocity" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration15Defects">&nbsp;&nbsp;I-3 Defects:</label>
            <input type="text" name="Iteration15Defects" id="Iteration15Defects" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration15Grade">&nbsp;&nbsp;I-15 Grade:</label>
            <input type="text" name="Iteration15Grade" id="Iteration15Grade" style="width:25px;" maxlength="3">
		</div>
		<div>
            <label for="Iteration15RallyURL">&nbsp;&nbsp;I-15 Rally URL:</label>
            <input type="text" name="Iteration15RallyURL" id="Iteration15RallyURL" style="width:300px;" maxlength="255">
        </div>
	</div>
</div>
<div class="buttonlist">
	<ul>
		<li><input type="button" value="Save Changes" onclick="this.form.submit()"></li>
		<li><input type="button" value="Cancel" onclick="location.href='projectedit.php'"></li>
	</ul>
</div> 

</form>


<BR><BR>


</body>
</html>

