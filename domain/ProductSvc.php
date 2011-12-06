<?php
require_once("DbConfig.php");
require_once("ProductDao.php");
require_once("DataAccess.php");

/**
 *  Business logic and some data modeling
 */
class ProductSvc {
    /**
    * Private
    * $dao stores data access object
    */
    var $dao; 
 
  
	function ProductSvc () 
	{
        $dbConfig = new DbConfig();
		$da = new DataAccess($dbConfig->host,$dbConfig->user,$dbConfig->pass,$dbConfig->db);
		$this->dao=& new ProductDao($da);
    }
 
 	/**
    * Create Product
    * @return new product id
    */
    function CreateProduct ($product_name) 
	{
		return $this->dao->SaveItem($product_name);
	}
	
	
    /**
    * Gets a productCollection set
    * @return void
    */
    function GetProductsByPortfolio ($portfolio_id) 
	{
		$a = $this->dao->GetProductsByPortfolioId($portfolio_id);
		// convert into array of objects (vs. just multi-dim array)
		// so we provide a nice interface (eg "ObjCollection[0]->member")
		$productArr = array();
		for($i = 0, $size = sizeof($a); $i < $size; ++$i)
		{			
			$productArr[] = (object)$a[$i];
		}
		return $productArr;
	}
 
 
	/**
    * Gets a productCollection set
    * @return void
    */
    function GetAllActiveProducts () 
	{
		$a = $this->dao->GetAllActiveProducts();
		// convert into array of objects (vs. just multi-dim array)
		// so we provide a nice interface (eg "ObjCollection[0]->member")
		$productArr = array();
		for($i = 0, $size = sizeof($a); $i < $size; ++$i)
		{			
			$productArr[] = (object)$a[$i];
		}
		return $productArr;
	}
 
    /**
    * Gets a single Product row by it's id
    * @param $id of the Product row
    * @return void
    */
    function GetProductByPortfolioId ($id) 
	{
        $productArray = $this->dao->GetProductByPortfolioId($id);
		return (object)$productArray[0];
    }
	
	function GetProductByID ($product_id) 
	{
        $productArray = $this->dao->GetProductByID($product_id);
		return (object)$productArray[0];
    }
}
?>