<?php
require_once("DataAccess.php");
require_once("Dao.php");
/**
 *  Data Access Object for Product Table
 */
class ProductDao extends Dao 
{
    /**
    * Constructs the Product
    * @param $da instance of the DataAccess class
    */
    function ProductDao ( & $da ) 
	{
        Dao::Dao($da);
    }
 
    /**
    * Searches products by portfolio_id
    * @return object a result object
    */
    function & GetProductsByPortfolioId ($portfolio_id) 
	{
        $sql="SELECT * FROM product WHERE portfolio_id='".$portfolio_id."' AND is_active = 1".
            " ORDER BY product_name ASC";
        return $this->select($sql);
    }
	
	function & GetAllActiveProducts () 
	{
        $sql="SELECT * FROM product WHERE is_active = 1".
            " ORDER BY product_name ASC";
        return $this->select($sql);
    }
	
	/**
    * Searches products by id
    * @return object a result object
    */
    function & GetProductByID ($id) 
	{
        $sql="SELECT * FROM product WHERE product_id='".$id."'";
        return $this->select($sql);
    }
 
    function & totalRows () 
	{
        $sql="SELECT count(*) as count FROM product";
        return $this->select($sql);
    }
}
?>