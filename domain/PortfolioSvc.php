<?php
require_once("DbConfig.php");
require_once("PortfolioDao.php");
require_once("DataAccess.php");

/**
 *  Business logic and some data modeling
 */
class PortfolioSvc {
    /**
    * Private
    * $dao stores data access object
    */
    var $dao; 
 
  
	function PortfolioSvc () 
	{
        $dbConfig = new DbConfig();
		$da = new DataAccess($dbConfig->host,$dbConfig->user,$dbConfig->pass,$dbConfig->db);
		$this->dao=& new PortfolioDao($da);
    }
 
 	/**
    * Create Portfolio
    * @return new portfolio id
    */
    function CreatePortfolio ($portfolio_name) 
	{
		return $this->dao->SaveItem($portfolio_name);
	}
	
	
    /**
    * Gets a portfolioCollection set
    * @return void
    */
    function GetAllActivePortfolios () 
	{
		$a = $this->dao->GetAllActiveItems();
		// convert into array of objects (vs. just multi-dim array)
		// so we provide a nice interface (eg "ObjCollection[0]->member")
		$portfolioArr = array();
		for($i = 0, $size = sizeof($a); $i < $size; ++$i)
		{			
			$portfolioArr[] = (object)$a[$i];
		}
		return $portfolioArr;
	}
 
 
    /**
    * Gets a single Portfolio row by it's id
    * @param $id of the Portfolio row
    * @return void
    */
    function GetPortfolioById ($id) 
	{
        $portfolioArray = $this->dao->GetItem($id);
		return (object)$portfolioArray[0];
    }
}
?>