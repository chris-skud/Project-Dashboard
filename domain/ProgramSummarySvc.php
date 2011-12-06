<?php
require_once("PortfolioSvc.php");
require_once("ProductSvc.php");
require_once("ProjectSvc.php");
require_once("SnapshotSvc.php");
require_once("StatusCategorySvc.php");
/*
	ProgramSummarySvc - a service facade that builds up an entire 
	data strcuture to support the display of a summary of status (snapshot) for all projects by program.
*/
class ProgramSummarySvc 
{
	function ProgramSummarySvc()
	{
		
	}
	// returns a fully hydrated ProgramSummary data structure
	function GetProgramSummaryObject()
	{
		$programSummaryObject = null; // to be returned as fully hydrated 
		
		$portfolioSvc = new PortfolioSvc();
		// fill portfolios
		$programSummaryObject = $portfolioSvc->GetAllActivePortfolios();
		
		$productSvc = new ProductSvc();
		$projectSvc = new ProjectSvc();
		$snapshotSvc = new SnapshotSvc();
		$statusCatSvc = new StatusCategorySvc();
				
		// walk the hierarcy and hydrate
		foreach ($programSummaryObject  as $portfolio)
		{
			$portfolio->products = $productSvc->GetProductsByPortfolio($portfolio->portfolio_id);
			foreach ($portfolio->products as $product)
			{
				$product->projects = $projectSvc->GetActiveProjectsByProduct($product->product_id);
				foreach ($product->projects as $project)
				{
					$project->current_snapshot = $snapshotSvc->GetCurrentSnapshotForProjectId($project->project_id);
					
					// just in case a project has been created that does not have a status
					if (empty($project->current_snapshot))
					{
						$project->current_snapshot->status_change = $statusCatSvc->GetStatusChangeCategoryShortnameById($project->current_snapshot->status_change_id);
						$project->current_snapshot->release_status = $statusCatSvc->GetStatusCategoryShortnameById($project->current_snapshot->release_status_id);
						$project->current_snapshot->budget_status =  $statusCatSvc->GetStatusCategoryShortnameById($project->current_snapshot->budget_status_id);
						$project->current_snapshot->risk_status =  $statusCatSvc->GetStatusCategoryShortnameById($project->current_snapshot->risk_status_id);
					}
					else
					{
						$project->current_snapshot->status_change = "N/A";
						$project->current_snapshot->release_status = "N/A";
						$project->current_snapshot->budget_status =  "N/A";
						$project->current_snapshot->risk_status =  "N/A";
					}
				}
			}
		}
		
		return $programSummaryObject;
	}
}
?>