<?php
require_once("DataAccess.php");
require_once("Dao.php");

/**
 *  Data Access Object for Portfolio Table
 */
class PortfolioDao extends Dao 
{
    /**
    * Constructs the Portfolio
    * Inject $da instance of the DataAccess class
    */
    function PortfolioDao ( & $da ) 
	{
        Dao::Dao($da); // $da injected from consumer
    }
	
	/**
    * Gets all active portfolios
    * @return object a result object
    */
    function & GetAllActiveItems () 
	{
        $sql="SELECT * FROM portfolio WHERE is_active = 1 ORDER BY portfolio_name ASC";
        return $this->select($sql);
    }
 
     
    /**
    * Get a portfolio by id
    * @return object a result object
    */
    function & GetItem ($id) 
	{
        $sql="SELECT * FROM portfolio WHERE portfolio_id='".$id."'";
        return $this->select($sql);
    }

	/**
    * Save a portfolio.  Handles inserts and updates
    * @return object a result object
    */
	function SaveItem ($portfolio_name, $portfolio_id=0)
	{
		if ($portfolio_id == 0)
			$sql="INSERT INTO portfolio (portfolio_name) VALUES ('".$portfolio_name."')";
		else
			$sql="UPDATE portfolio SET portfolio_name = ".$portfolio_name." WHERE portfolio_id = ".$portfolio_id;
		return $this->update($sql);
		
	}
	
	function DeleteItem ($portfolio_id)
	{
		$sql = "DELETE FROM portfolio WHERE portfolio_id = ".$portfolio_id;
		return $this->update($sql);
	}
	
    function & TotalRows () {
        $sql="SELECT count(*) as count FROM portfolio";
        return $this->select($sql);
    }
}
?>