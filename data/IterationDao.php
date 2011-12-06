<?php
/**
 *  Data Access Object for Iteration Table
 */
class Iteration extends Dao {
    //! A constructor
    /**
    * Constructs the Iteration
    * @param $da instance of the DataAccess class
    */
    function Iteration ( & $da ) {
        Dao::Dao($da);
    }
 
    //! An accessor
    /**
    * Gets all iterations
    * @return object a result object
    */
    function & searchAll ($start=false,$rows=false) {
        $sql="SELECT * FROM iteration ORDER BY iteration_id DESC"; // could be interesting to keep the order correct.
        if ( $start ) {
            $sql.=" LIMIT ".$start;
            if ( $rows )
                $sql.=", ".$rows;
        }
        return $this->retrieve($sql);
    }
 
    //! An accessor
    /**
    * Searches iterations by project_id
    * @return object a result object
    */
    function & searchByProject ($project_id) {
        $sql="SELECT * FROM iteration WHERE project_id='".$project_id."'".
            " ORDER BY iteration_id DESC";  // could be interesting to keep the order correct.
        return $this->retrieve($sql);
    }
 
     
    //! An accessor
    /**
    * Searches iterations by id
    * @return object a result object
    */
    function & searchByID ($id) {
        $sql="SELECT * FROM iteration WHERE iteration_id='".$id."'";
        return $this->retrieve($sql);
    }
 
    function & totalRows () {
        $sql="SELECT count(*) as count FROM iteration";
        return $this->retrieve($sql);
    }
}
?>