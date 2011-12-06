<?php
require_once("SnapshotSvc.php");
require_once("StatusCategorySvc.php");
require_once("utils.php");
$snapshotSvc = new SnapshotSvc();
$request = htmlEncodeRequest($_REQUEST);

if ($request["is_update"] == true)
{
	$snapshotSvc->UpdateSnapshot((object)$request);
}

if ($request["snapshot_id"])
{
	$snapshot = $snapshotSvc->GetSnapshotById((int)$_REQUEST["snapshot_id"]);
}
else if ($request["project_id"])
{
	$snapshot = $snapshotSvc->GetCurrentSnapshotForProjectId((int)$_REQUEST["project_id"]);
}
else
{
	print "bad request.  i need a project_id or snapshot_id in the request to render this page.";
	exit;
}

//build up the data for the status dropdowns.
$statusCategorySvc = new StatusCategorySvc();
$statusCatItems = $statusCategorySvc->GetStatusCategoryItems();
$statusChangeCatItems = $statusCategorySvc->GetStatusChangeCategoryItems();

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Project Status Edit</title>
<LINK REL="stylesheet" HREF="style.css">
</head>
<body>
<form action="statusedit.php" method="post" name="editStatus" id="editStatus">
<input type="hidden" name="snapshot_id" value="<?=$snapshot->snapshot_id?>">
<input type="hidden" name="project_id" value="<?=$request['project_id']?>">
<input id="is_update" type="hidden" name="is_update" value="true">
<input id="snapshot_name" type="hidden" name="snapshot_name" value="<?=$snapshot->snapshot_name?>">
<h1>CM Threads Status - id=<?=$snapshot->project_id?>: <?=$snapshot->snapshot_name?></h1> 
<div class="buttonlist">
		<ul>
			<li><input type="button" value="Save Changes" onclick="this.form.submit()"></li>
			<li><input type="button" value="Cancel" onclick="location.href='index.php'"></li>
		</ul>
</div> 
<div class="editBox">
	<div class="normal_form">
		<div>
            <label for="status_change_id">Status Change:</label>
            <select name="status_change_id" id="status_change_id">
				<option></option>
				<?php
					foreach ($statusChangeCatItems as $k => $v)
					{
						if ($v['statuschangecategory_id'] == $snapshot->status_change_id)
							print '<option id="'.$v['statuschangecategory_id'].'" value="'.$v['statuschangecategory_id'].'" selected>'.$v['shortname'].'</option>';
						else
							print '<option id="'.$v['statuschangecategory_id'].'" value="'.$v['statuschangecategory_id'].'">'.$v['shortname'].'</option>';
					}
				?>
			</select>&nbsp;&nbsp;
		</div>
		<div>
            <label for="release_status_id">Release Status:</label>
            <select name="release_status_id" id="release_status_id">
				<option></option>
				<?php
					foreach ($statusCatItems as $k => $v)
					{
						if ($v['statuscategory_id'] == $snapshot->release_status_id)
							print '<option id="'.$v['statuscategory_id'].'" value="'.$v['statuscategory_id'].'" selected>'.$v['shortname'].'</option>';
						else
							print '<option id="'.$v['statuscategory_id'].'" value="'.$v['statuscategory_id'].'">'.$v['shortname'].'</option>';
					}
				?>
			</select>
		</div>
		<div>
            <label for="budget_status_id">Budget Status:</label>
            <select name="budget_status_id" id="budget_status_id">
				<option></option>
				<?php
					foreach ($statusCatItems as $k => $v)
					{
						if ($v['statuscategory_id'] == $snapshot->budget_status_id)
							print '<option id="'.$v['statuscategory_id'].'" value="'.$v['statuscategory_id'].'" selected>'.$v['shortname'].'</option>';
						else
							print '<option id="'.$v['statuscategory_id'].'" value="'.$v['statuscategory_id'].'">'.$v['shortname'].'</option>';
					}
				?>
			</select>
		</div>
		<div>
            <label for="risk_status_id">Risk Status:</label>
            <select name="risk_status_id" id="risk_status_id">
				<option></option>
				<?php
					foreach ($statusCatItems as $k => $v)
					{
						if ($v['statuscategory_id'] == $snapshot->risk_status_id)
							print '<option id="'.$v['statuscategory_id'].'" value="'.$v['statuscategory_id'].'" selected>'.$v['shortname'].'</option>';
						else
							print '<option id="'.$v['statuscategory_id'].'" value="'.$v['statuscategory_id'].'">'.$v['shortname'].'</option>';
					}
				?>
			</select>
		</div>
		<div>
           <label for="status_description">Where in Process:</label>
           <input type="text" name="status_description" id="status_description" style="width:300px;" maxlength="255" value="<?=$snapshot->status_description?>">
        </div>
		<div>
           <label for="additional_details">Additional Details:</label>
           <textarea name="additional_details" id="additional_details" style="width:300px;" rows="4" cols="75"><?=$snapshot->additional_details?></textarea>
        </div>
		<div>
           <label for="highlights">Highlights:</label>
           <textarea name="highlights" id="highlights" style="width:450px;" rows="10" cols="90"><?=$snapshot->highlights?></textarea>
        </div>
		<div>
           <label for="issues_risks_strategies">Blocking Issues, Risks and Strategies:</label>
           <textarea name="issues_risks_strategies" id="issues_risks_strategies" style="width:450px;" rows="10" cols="90"><?=$snapshot->issues_risks_strategies?></textarea>
        </div>
	</div>
</div>
<div class="buttonlist">
	<ul>
		<li><input type="button" value="Save Changes" onclick="this.form.submit()"></li>
		<li><input type="button" value="Cancel" onclick="location.href='index.php'"></li>
	</ul>
</div> 

</form>



<BR><BR>


</body>
</html>

