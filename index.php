<?php
require_once("utils.php");
require_once("ProgramSummarySvc.php");
$programSvc = new ProgramSummarySvc();
$statusCollection = $programSvc->GetProgramSummaryObject();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Program Management Status Report</title>
<LINK REL="stylesheet" HREF="style.css">

</head>
<body>

<h1>Program Management Summary Status Report</h1> 

<h2>as of <select><option>April 3, 2009</option><option>March 27, 2009</option></select></h2>

<div id="status_key">
	<h3>Status Key</h3> 
		<div>
			<h4>Release Status</h4>
			<dl>
				<dt><span class="green" title="Green">Green</span></dt> <dd>: within 0 – 10% of estimated date at time of Release Planning</dd>
				<dt><span class="yellow" title="Yellow">Yellow</span></dt> <dd>: within 10 – 20% of estimated date at time of Release Planning</dd>
				<dt><span class="red" title="Red">Red</span></dt> <dd>: over 20% of estimated date at time of Release Planning</dd>
			  
			 </dl>
		</div>
		<div>
			<h4>Budget Status</h4>
			<dl>
				<dt><span class="green" title="Green">Green</span></dt>  <dd>: within 0 – 10% of estimated date at time of Release Planning</dd>
				<dt><span class="yellow" title="Yellow">Yellow</span></dt> <dd>: within 10 – 20% of estimated date at time of Release Planning</dd>
				<dt><span class="red" title="Red">Red</span></dt> <dd>: over 20% of estimated date at time of Release Planning</dd>
			</dl>
		</div>
		<div>
			<h4>Change Status</h4>
			<dl>
				<dt><span class="unchanged" title="Unchanged">Unchanged</span></dt><dd>= Status Unchanged</dd>
				<dt><span class="upgraded" title="Upgraded">Upgraded</span></dt><dd>= Status Upgraded</dd>    
				<dt><span class="downgraded" title="Downgraded">Downgraded</span></dt> <dd>= Status Downgraded</dd>
			</dl>
		</div>
</div>

<table width="98%" cellpadding="0" cellspacing="0" summary="Project Information" id="project_info">
	<col id="prod_projects" />
	<col id="prod_changes"/>
	<col id="placement" />
	<col id="rel_status" />
	<col id="rel_date" />
	<col id="bud_status" />
	<col id="overall_risk" />
	<col id="add_details" />
	<col id="products" />
	<col id="updated" />
	
 <thead>
	
     <tr>
		<th align="left" id="product_program"width="15%">Product/Program</th>
        <th align="left" id="projects"width="15%">Project</th>
		<th align="center" id="project_changes">Changes</th>
        <th align="left" id="process_placement" width="15%">Where in Process</th>
        <th align="left" id="release_date" width="10%">Release Date</th>
		<th align="center" id="release_status" width="5%">Release</th>
        <th align="center" id="budget_status" width="5%">Budget</th>
        <th align="center" id="over_all_risk" width="5%">Risk</th>
        <th align="left" id="additional_details" width="15%">Additional Details</th>
		<th align="left" id="updated" width="15%">Updated</th>
     </tr>
 </thead>
 <tbody>
 	<?php
		foreach ($statusCollection as $portfolio)
		{
			print '<tr class="section_head">';
			print '<th align="left" colspan="10" id="portfolio_'.$portfolio->portfolio_id.'"><a href="#">'.$portfolio->portfolio_name.'</a></th>';
			print '</tr>';
			
			
			foreach ($portfolio->products as $product)
			{
				foreach ($product->projects as $project)
				{
					$snapshot = $project->current_snapshot;
					print '<tr>';
					print '<td align="left"><a href="#">'.$product->product_name.'</a></td>';
					print '<td align="left"><a href="Project.htm">'.$project->project_name.'</a></td>';
					switch ($snapshot->status_change->shortname)
					{
						case "Status Unchanged":
							print '	<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>';
							break;
						case "Status Upgraded":
							print '	<td align="center"><span class="upgraded" title="Upgraded">Upgraded</span></td>';
							break;
						case "Status Downgraded":
							print '<td align="center"><span class="downgraded" title="downgraded">Downgraded</span></td>';
							break;
						default:
							print '<td align="center">N/A</td>';							
					}
					print '<td align="left">'.$snapshot->status_description.'</td>';
					print '<td align="left">'.$project->target_release_date.'</td>';
					switch ($snapshot->release_status->shortname)
					{
						case "TBD":
							print '	<td align="center">TBD</td>';
							break;
						case "Green":
							print '	<td align="center"><span class="green" title="Green">Green</span></td>';
							break;
						case "Yellow":
							print '<td align="center"><span class="yellow" title="Yellow">Yellow</span></td>';
							break;
						case "Red":
							print '<td align="center"><span class="red" title="Red">Red</span></td>';
							break;
						default:
							print '<td align="center">N/A</td>';							
					}
					switch ($snapshot->budget_status->shortname)
					{
						case "TBD":
							print '	<td align="center">TBD</td>';
							break;
						case "Green":
							print '	<td align="center"><span class="green" title="Green">Green</span></td>';
							break;
						case "Yellow":
							print '<td align="center"><span class="yellow" title="Yellow">Yellow</span></td>';
							break;
						case "Red":
							print '<td align="center"><span class="red" title="Red">Red</span></td>';
							break;
						default:
							print '<td align="center">N/A</td>';							
					}
					switch ($snapshot->risk_status->shortname)
					{
						case "TBD":
							print '	<td align="center">TBD</td>';
							break;
						case "Green":
							print '	<td align="center"><span class="green" title="Green">Green</span></td>';
							break;
						case "Yellow":
							print '<td align="center"><span class="yellow" title="Yellow">Yellow</span></td>';
							break;
						case "Red":
							print '<td align="center"><span class="red" title="Red">Red</span></td>';
							break;
						default:
							print '<td align="center">N/A</td>';							
					}
					print '<td align="left">'.$snapshot->additional_details.'</td>';
					print '<td align="left" nowrap>'.GetDateFromSqlTimestamp($snapshot->time_updated).'</td>';
					print '</tr>';
					
				}
			}
		}
		
	?>
	
	<!--
	<tr class="section_head">
		<th align="left" colspan="10" id="teaching_solutions"><a href="Portfolio.htm">Teaching Solutions</a></th>
	</tr>
	-->
	<!--
    <tr>
		<td align="left"><a href="Program.htm">.NExT</a></td>
        <td align="left"><a href="Project.htm">.NExT Maint 1</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left">RT17 in Prod</td>
		<td align="left">On Time 3/19/09</td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center">N/A</td>
        <td align="center">N/A</td>
        <td align="left"><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Release_Train_Schedule">Release Train Schedule</a></td>
		<td align="left" nowrap>3/19/09</td>
	</tr>
	 <tr class="odd">
		<td align="left"><a href="Program.htm">.NExT</td>
        <td align="left"><a href="Project.htm">.NExT Maint</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left">RT18 in Integ</td>
		<td align="left">Planned 4/09/09</td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center">N/A</td>
        <td align="center">N/A</td>
        <td align="left"><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Release_Train_Schedule">Release Train Schedule</a></td>
		<td align="left" nowrap>3/19/09</td>
	</tr>
	 <tr>
		<td align="left"><a href="Program.htm">.NExT</a></td>
        <td align="left"><a href="Project.htm">.NExT Maint</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left">RT17 in Prod</td>
		<td align="left"></td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center">N/A</td>
        <td align="center">N/A</td>
        <td align="left"><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Release_Train_Schedule">Release Train Schedule</a></td>
		<td align="left" nowrap>3/19/09</td>
	 </tr>
     <tr class="odd">
		<td align="left"><a href="Program.htm">.NExT</a></td>
        <td align="left"><a href="Project.htm">.NExT PR Team (Team Mercury)</a> </td>
		<td align="center"><span class="downgraded" title="downgraded">Downgraded</span></td>
        <td align="left">Weekly Releases</td>
		<td align="left">Weekly</td>
        <td align="center">N/A</td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center"><span class="red" title="red">Red</span></td>
        <td align="left">Backlog increasing in size</td>
		<td align="left" nowrap>3/19/09</td>
	</tr>
	<tr>
        <td align="left"><a href="Program.htm">.NExT</a></td>
        <td align="left"><a href="Project.htm">.NExT Rapid Enhancements</a> </td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left">Iteration 1</td>
		<td align="left">April 15</td>
        <td align="center"><span class="green" title="Green">Targeted by CiTE</span></td>
        
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center"><span class="red" title="red">Red</span></td>
        <td align="left">Course Persona</td>
		<td align="left"nowrap>3/19/09</td>
	 </tr>
	<tr class="odd">
		<td align="left"><a href="Program.htm">.NExT</a></td>
        <td align="left"><a href="Project.htm">.NExT Equality</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left">VizEd Planning</td>
		<td align="left">April 9</td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="left">VizEd Performance Enh.<br/>VizEd tTrack<br/>Block Multi-VizEd Project</td>
		<td align="left" nowrap>3/19/09</td>
	</tr>
	<tr>
		<td align="left"><a href="Program.htm">.NExT</a></td>
        <td align="left"><a href="Project.htm">SIMCA</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left">RT16 (in QA)</td>
		<td align="left">RT16</td>
        <td align="center"><span class="yellow" title="yellow">Yellow</span></td>
        <td align="center"><span class="red" title="red">Red</span></td>
        <td align="center"><span class="yellow" title="yellow">Yellow</span></td>
        <td align="left"><a href="https://ecollege.updatelog.com/projects/2137874/project/log">Basecamp site</a></td>
		<td align="left" nowrap>3/19/09</td>
	 </tr>
    <tr class="odd">
		<td align="left"><a href="Program.htm">.NExT</a></td>
        <td align="left"><a href="Project.htm">CM Threads</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left">Iteration 3</td>
        <td align="left">8/1</td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="left"><a href="https://ecollege.updatelog.com/projects/2730373/project/log">Basecamp site</a></td>
		<td align="left" nowrap>3/19/09</td>
	</tr>
	<tr>
		<td align="left"><a href="Program.htm">LOM</a></td>
        <td align="left"><a href="Project.htm">Superior</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left">Iteration 6 of 7</td>
		<td align="left">RT17</td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="left"><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Superior"> Superior wiki</a></td>
		<td align="left" nowrap>3/19/09</td>
	 </tr>
     <tr class="odd">
		<td align="left"><a href="Program.htm">Tapestry</a></td>
        <td align="left" ><a href="Project.htm">Tapestry  Integrations</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left">Iteration 2 of TBD</td>
		<td align="left">TBD</td>
        <td align="center"><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center"><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="left"><a href="https://ecollege.updatelog.com/projects/2629322/project/log">Basecamp site</a></td>
		<td align="left" nowrap>3/19/09</td>
	 </tr>
    <tr>
		<td align="left"><a href="Program.htm">Teaching Solutions (Legacy)</a></td>
        <td align="left" ><a href="Project.htm">Respondus Upgrade</a></td>
		<td align="center"><span class="upgraded" title="Upgraded">Upgraded</span></td>
        <td align="left"  >Iteration 7 of 8</td>
		<td align="left" >Mid-Feb </td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="center"  >N/A</td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="left"  ></td>
		<td align="left"   nowrap>3/19/09</td>
	</tr>
    <tr class="odd">
		<td align="left" id="dot_next"><a href="Program.htm">Teaching Solutions (Legacy)</a></td>
        <td align="left" ><a href="Project.htm">Elluminate Upgrade</a></td>
		<td align="center"  ><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left"  >Iteration 0</td>
		<td align="left"  >Target by CITE: April 15</td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
      	<td align="center"  >N/A</td>
        <td align="center"  ><span class="green" title="Green">Green</span> </td>
        <td align="left"  ></td>
		<td align="left"   nowrap>3/19/09</td>
	</tr>
	
	<tr class="section_head">
		<th align="left" colspan="10" id="admin_solutions">Admin Solutions</th>
	</tr>
	
	 <tr>
        <td align="left" class="odd"><a href="Program.htm">Campus Administration</a></td>
        <td align="left" ><a href="Project.htm">Parent Release 1</a></td>
		<td align="center"><span class="downgraded" title="Downgraded">Downgraded</span></td>
        <td align="left">In QA for Release 1</td>
		<td align="left">2/12</td>
        <td align="center"><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center"><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="left"><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Parent_User_Project">Parent Wiki Page</a> Issue: performance testing will not be completed prior to production push 2/12. Team assessment is this is low risk.</td>
		<td align="left"  nowrap>3/22/09</td>
	</tr>
    <tr class="odd">
        <td align="left" class="odd"><a href="Program.htm">Campus Administration</a></td>
        <td align="left"><a href="Project.htm">Admin G11n -Release 1</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left">Iteration 4 of 6</td>
		<td align="left">March</td>
        <td align="center"><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="left">Release 1 of 3</td>
		<td align="left" nowrap>3/22/09</td>
    </tr>
	<tr>
        <td align="left"><a href="Program.htm">Portal</a></td>
        <td align="left"><a href="Project.htm">Portal Replacement R2</a></td>
		<td align="center"><span class="upgraded" title="Upgraded">Upgraded</span></td>
        <td align="left">Iteration 7 of 12</td>
		<td align="left">April</td>
        <td align="center"><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center"><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="left"><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Campus_Portal">Portal Wiki page</a></td>
		<td align="left" nowrap>3/23/09</td>
	</tr>
    <tr class="odd">
        <td align="left" class="odd"><a href="Program.htm">Enterprise Reporting</a></td>
        <td align="left"><a href="Project.htm">Rubix</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left">Iteration 2 of 2</td>
		<td align="left">Q1</td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center">TBD</td>
        <td align="center"><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="left"><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Enterprise_Reporting">ER Wiki Page</a></td>
		<td align="left" nowrap>3/24/09</td>
	</tr>
	 
	<tr>
        <td align="left"><a href="Program.htm">Campus Interoperability</a></td>
          <td align="left"><a href="Project.htm">SIF – Release 1</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
          <td align="left">Iteration 9 of N</td>
		  <td align="left">April</td>
          <td align="center"><span class="red" title="Red">Red</span></td>
          <td align="center"><span class="green" title="Green">Green</span></td>
          <td align="center"><span class="red" title="Red">Red</span></td>
          <td align="left" ><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=SIF">SIF Wiki Page</a>  Risk (formerly Issue): PowerSchool – The setup of PowerSchool at Chandler, AZ should be available next week for the install of the ZIS and PowerSchool Agent with the help of our team, and we’ll start to discuss how to utilize both instances available to us.</td>
		<td align="left" nowrap>3/24/09</td>
	 </tr>
    <tr class="odd">
		<td align="left"><a href="Program.htm">Campus Interoperability</a></td>
          <td align="left"><a href="Project.htm">BizTalk 2006/ Snickerdoodle</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
          <td align="left">In QA</td>
		  <td align="left">Feb</td>
          <td align="center"><span class="red" title="Red">Red</span></td>
          <td align="center"><span class="green" title="Green">Green</span></td>
          <td align="center"><span class="red" title="Red">Red</span></td>
		<td align="left"><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Snickerdoodle">BizTalk 2006/Snickerdoodle Wiki Page</a></td>
		<td align="left" nowrap>3/24/09</td>
	</tr>
    <tr>
		<td align="left"><a href="Program.htm">Campus Interoperability</a></td>
          <td align="left"><a href="Project.htm">BCCT Rewrite</a></td>
		<td align="center" ><span class="unchanged" title="Unchanged">Unchanged</span></td>
          <td align="left">Product Definition</td>
		  <td align="left">TBD</td>
          <td align="center" >TBD</td>
          <td align="center">TBD</td>
          <td align="center">TBD</td>
          <td align="left"><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=BCCT_Replacement">BCCT Rewrite Wiki Page</a></td>
		<td align="left" nowrap>3/24/09</td>
	</tr>
    <tr class="odd">
		<td align="left"><a href="Program.htm">Campus Interoperability</a></td>
          <td align="left"><a href="Project.htm">Fortune Cookie Remaining Objects</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
          <td align="left">In Dev</td>
		  <td align="left">TBD</td>
          <td align="center"><span class="green" title="Green">Green</span></td>
          <td align="center"><span class="green" title="Green">Green</span></td>
          <td align="center"><span class="green" title="Green">Green</span></td>
          <td align="left">See Marconi for additional information on Fortune Cookie Remaining objects</td>
		<td align="left" nowrap>3/24/09</td>
	</tr>
	
	<tr class="section_head">
		<th align="left" colspan="10" id="cros_prod">Cross Product Initiatives</th>
	</tr>
	<tr>
        <td align="left" class="odd"><a href="Program.htm">Tapestry</a></td>
        <td align="left"><a href="Project.htm">Portal</a></td>
		<td align="center" ><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left">Iteration 8 of 12</td>
		<td align="left">April</td>
        <td align="center"><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"><span class="green" title="Green">Green</span></td>
        <td align="center"><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="left"><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Portal">Portal wiki</a></td>
		<td align="left" nowrap>3/24/09</td>
	</tr>
    <tr class="odd"> 
		<td align="left" class="odd"><a href="Program.htm">Tapestry</a></td>
          <td align="left"><a href="Project.htm">Parent</a></td>
		<td align="center"><span class="unchanged" title="Unchanged">Unchanged</span></td>
          <td align="left">In QA for Release 1</td>
		<td align="left">Feb</td>
          <td align="center"><span class="yellow" title="Yellow">Yellow</span></td>
          <td align="center"><span class="green" title="Green">Green</span></td>
          <td align="center"><span class="green" title="Green">Green</span></td>
          <td align="left ><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Parent_User_Project">parent wiki</a></td>
		<td align="left" nowrap>3/24/09</td>
	</tr>
    <tr>
		<td align="left" class="odd"><a href="Program.htm">Tapestry</a></td>
          <td align="left"><a href="Project.htm">SIF</a></td>
		<td align="center"><span class="downgraded" title="Downgraded">Downgraded</span></td>
          <td align="left" >Iteration 7 of 9</td>
		  <td align="left">Q1</td>
          <td align="center"><span class="red" title="Red">Red</span></td>
          <td align="center"><span class="green" title="Green">Green</span></td>
          <td align="center"><span class="red" title="Red">Red</span></td>
          <td align="left ><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=SIF">SIF wiki</a></td>
		<td align="left" nowrap>3/24/09</td>
	</tr>
    <tr class="odd"> 
		<td align="left" class="odd"><a href="Program.htm">Tapestry</a></td>
        <td align="left" ><a href="Project.htm">eLMS Integrations</a></td>
		<td align="center"  ><span class="unchanged" title="Unchanged">Unchanged</span></td>
          <td align="left"  >Iteration 2 of TBD</td>
		<td align="left"  >TBD</td>
          <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
          <td align="center"  ><span class="green" title="Green">Green</span></td>
          <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
          <td align="left"  >&nbsp;</td>
		<td align="left"   nowrap>3/24/09</td>
	</tr>
	
	<tr class="section_head">
		<th align="left" colspan="10" id="enterprise_infast_status">Enterprise Infrastructure Status </th>
	</tr>
	<tr>
          <td align="left"><a href="Program.htm">Enterprise Infrastructure</a></td>
          <td align="left" ><a href="Project.htm">Affinity Phase 1</a> </td>
		<td align="center"  ><span class="unchanged" title="Unchanged">Unchanged</span></td>
          <td align="left"  >Iteration 0</td>
		  <td align="left"  >TBD</td>
          <td align="center"  >TBD</td>
          
          <td align="center"  ><span class="green" title="Green">Green</span></td>
          <td align="center"  ><span class="green" title="Green">Green</span></td>
          <td align="left"  ><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Enterprise_Infrastructure#Projects">EI Wiki Page</a> Regarding the production release date: The Teaching Solutions team will determine when these efforts are Production-ready; the User Profile piece of Affinity will be ready to demonstrate at CiTE, with only the back-end architecture being Production-ready at or soon after that time</td>
		<td align="left"   nowrap>3/25/09</td>
	</tr>
    <tr class="odd"> 
		<td align="left"><a href="Program.htm">Enterprise Infrastructure</a></td>
          <td align="left" ><a href="Project.htm">Marconi</a></td>
		<td align="center"  ><span class="unchanged" title="Unchanged">Unchanged</span></td>
          <td align="left"  >In Prod</td>
		  <td align="left"  >Jan</td>
          <td align="center"  ><span class="green" title="Green">Green</span></td>
          
          <td align="center"  ><span class="red" title="Red">Red</span></td>
          <td align="center"  ><span class="red" title="Red">Red</span></td>
          <td align="left"  ><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Marconi">Marconi Wiki Page</a> 	It does not appear that CMS issues were resolved due to the Millau release. It is unclear at this time if the issues are on the Enterprise Messaging side or the CMS side. Research on this issue is underway.</td>
		<td align="left"   nowrap>3/25/09</td>
	 </tr>
	 
	<tr class="section_head">
		<th align="left" colspan="10" id="MIS">MIS</th>
	</tr>
	<tr>
        <td align="left" class="odd"><a href="Program.htm">Opus</a></td>
        <td align="left" ><a href="Project.htm">Opus OX</a></td>
		<td align="center"  ><span class="upgraded" title="Upgraded">Upgraded</span></td>
        <td align="left"  >Dev</td>
		<td align="left"  >Feb 09</td>
        <td align="center"  ><span class="red" title="Red">Red</span></td>
        <td align="center"  ><span class="red" title="Red">Red</span></td>
        <td align="center"  ><span class="red" title="Red">Red</span></td>
        <td align="left"  ><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Opus">Opus Wiki</a></td>
		<td align="left"   nowrap>3/24/09</td>
	</tr>
    <tr class="odd"> 
		<td align="left" class="odd"><a href="Program.htm">Opus</a></td>
        <td align="left" ><a href="Project.htm">Opus OER</a></td>
		<td align="center"  ><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left"  >Dev</td>
		<td align="left"  >Feb 09</td>
        <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="left"  ><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Opus">Opus Wiki</a></td>
		<td align="left"   nowrap>3/24/09</td>
	 </tr>
	<tr>
        <td align="left"><a href="Program.htm">Communication Tools</a></td>
        <td align="left" ><a href="Project.htm">DA</a></td>
		<td align="center"  ></td>
        <td align="left"  >Design</td>
		<td align="left"  >TBD</td>
        <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="left"  ></td>
		<td align="left"   nowrap>3/24/09</td>
    </tr>
	<tr class="section_head">
		<th align="left" colspan="10" id="prod_infa_pipeline">Production &amp; Infrastructure and Release Pipeline</th>
	</tr>
	<tr class="odd">
        <td align="left" class="odd"><a href="Program.htm">Hosting Initiatives</a></td>
        <td align="left" ><a href="Project.htm">CTG DR</a></td>
		<td align="center"  ><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left"  >Application Design; Hardware Implementation</td>
		<td align="left"  >Q1</td>
        <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="left"  >SLA work is in process, and further direction for eCollege is forthcoming from CTG. This has moved to yellow risk. Phase 1 of this project was targeted for completion by January, a date that is in jeopardy. </td>
		<td align="left"   nowrap>3/24/09</td>
	</tr>
    <tr>
        <td align="left"><a href="Program.htm">Data Center Management</a></td>
        <td align="left" ><a href="Project.htm">Cornell Infrastructure Build Out</a></td>
		<td align="center"  ><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left"  >Design</td>
		<td align="left"  >Q2</td>
        <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="left"  >The target March date for being in the data center is in jeopardy so long as the team cannot begin their activities – network buildout is anticipated a minimum of 8 -12 weeks. </td>
		<td align="left"   nowrap>3/24/09</td>
	</tr>
    <tr class="odd">
		<td align="left"><a href="Program.htm">Data Center Management</a></td>
        <td align="left" ><a href="Project.htm">Cornell Migration Phase 1: Arapahoe</a></td>
		<td align="center"  ><span class="upgraded" title="Upgraded">Upgraded</span></td>
        <td align="left"  >Analysis</td>
		<td align="left"  >Q2</td>
        <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"  >N/A</td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="left"  >PMO is assigning a Business Analyst/PM to commence work on this project</td>
		<td align="left"   nowrap>3/24/09</td>
	</tr>
    <tr>
        <td align="left" class="odd"><a href="Program.htm">Storage</a></td>
        <td align="left" ><a href="Project.htm">DAM</a></td>
		<td align="center"  ><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left"  >Implementation; Wave 4 of 4</td>
		<td align="left"  ></td>
        <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="left"  >9TB of data has been moved to tier 2 storage this week.</td>
		<td align="left"   nowrap>3/24/09</td>
	</tr>
    <tr class="odd">
        <td align="left"><a href="Program.htm">Data Security &amp; Privacy and Business Continuity</a></td>
        <td align="left" ><a href="Project.htm">Leap Frog</a></td>
		<td align="center"  ><span class="upgraded" title="Upgraded">Upgraded</span></td>
        <td align="left"  >Execution</td>
		<td align="left"  >Q4 08</td>
        <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"  >N/A</td>
        <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="left"  >See Risk noted above. The team is working to mitigate and is meeting on mitigation strategies this week.</td>
		<td align="left"   nowrap>3/24/09</td>
	</tr>
    <tr>      
		<td align="left"><a href="Program.htm">Data Security &amp; Privacy and Business Continuity</a></td>
        <td align="left" ><a href="Project.htm">PII Encryption in Transit</a></td>
		<td align="center"  ><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left"  >In Analysis</td>
		<td align="left"  >June 09</td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="left"  >This is a Pearson security driven project that needs to be resourced for completion no later than June 2009</td>
		<td align="left"   nowrap>3/24/09</td>
	</tr>
    <tr class="odd">
        <td align="left" class="odd"><a href="Program.htm">Virtualization</a></td>
        <td align="left" ><a href="Project.htm">ECSDB Multi-Instance</a></td>
		<td align="center"  ><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left"  >Visioning</td>
		<td align="left"  >Q3</td>
        <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"  >N/A</td>
        <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="left"  >This project is needed to migrate into the new data center, and requires resourcing and prioritization in the Teaching Solutions roadmap</td>
		<td align="left"   nowrap>3/24/09</td>
	</tr>
    <tr>
        <td align="left"><a href="Program.htm">Scalability</a></td>
        <td align="left" ><a href="Project.htm">Switcheroo</a></td>
		<td align="center"  ><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left"  >In Analysis</td>
		<td align="left"  >Q1</td>
        <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="center"  >N/A</td>
        <td align="center"  ><span class="yellow" title="Yellow">Yellow</span></td>
        <td align="left"  >This is an unbudgeted project that evolved out of spring scalability needs. A project team has been established out of the SD team, however the nature of the work and subsystem are touchy and risky by nature. See other details above, and wiki at: <a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Switcheroo">http://ecollegewiki.eclg.org/wiki/index.php?title=Switcheroo</a></td>
		<td align="left"   nowrap>3/24/09</td>
	</tr>
	
	<tr class="section_head">
		<th align="left" colspan="10" id="sustaining_dev">Sustaining Development</th>
	</tr>
	<tr class="odd">
        <td align="left" class="odd"><a href="Program.htm">Sustaining Dev</a></td>
        <td align="left" ><a href="Project.htm">Feb Maint</a></td>
		<td align="center"  ><span class="unchanged" title="Unchanged">Unchanged</span></td>
        <td align="left"  >In Dev</td>
		<td align="left"  ></td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="center"  >N/A</td>
        <td align="center"  ><span class="green" title="Green">Green</span></td>
        <td align="left"  ><a href="http://ecollegewiki.eclg.org/wiki/index.php?title=Sustaining_Development">Sustaining Development Wiki</a></td>
		<td align="left"   nowrap>3/24/09</td>
	</tr>
	-->
</tbody>
 <tfoot>
 	<tr>
    	<th colspan="10" align="center" id="table_date">&nbsp;</th>
    </tr>
 </tfoot>
</table>
<BR><BR>


</body>
</html>

