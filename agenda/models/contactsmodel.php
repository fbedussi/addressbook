<?php
class contacts
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    
    public function deleteContacts($idArray)
    {
        $subQuery = "";
        $executeArray = [];
        foreach ($idArray as $index => $id) {
            $subQuery .= ':id'.$index.',';
            $executeArray['id'.$index] = $id;  
        }
        
        //delete the final colon
        $subQuery = substr($subQuery,0,strlen($subQuery)-1);
        
        $query = "DELETE FROM contacts WHERE id IN ($subQuery)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($executeArray);
    }
    
    public function selectContacts($idArray)
    {
        $subQuery = "";
        $executeArray = [];
        foreach ($idArray as $index => $id) {
            $subQuery .= ':id'.$index.',';
            $executeArray['id'.$index] = $id;  
        }
        
        //delete the final colon
        $subQuery = substr($subQuery,0,strlen($subQuery)-1);
        
        $query = "SELECT * FROM contacts WHERE id IN ($subQuery)";
        $stmt = $this->db->prepare($query);
        $stmt->execute($executeArray);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function copyContact($id)
    {
        $result = $this->db->query("SELECT MAX(id) AS max FROM contacts")->fetch(PDO::FETCH_ASSOC);
        $highestId = $result['max']+1;
        
        //duplicate the record trough a temporary table to change ID
        $query = "CREATE TEMPORARY TABLE temptab SELECT * FROM contacts WHERE id=:id;
                        UPDATE temptab SET id=$highestId;
                        INSERT INTO contacts SELECT * FROM temptab;
                        DROP TABLE temptab;";
        
        $stmt = $this->db->prepare($query);
        return $stmt->execute(array('id' => $id));
    }
    
    public function insertContact($contactFields)
    {
        $fields = "";
        $values = "";
        $subQuery = "";
        $executeArray = array();
        $numberOfFields = count($contactFields);
    
        foreach ($contactFields as $index => $value)
        {
            $fields .= $value['field'];
            $values .= ":".$value['field'];
            $subQuery .= $value['field']."=:".$value['field'];
            
            $executeArray[$value['field']] = $value['term'];
            
            //if it is not the last element add colon
            if ($index+1 < $numberOfFields)
            {
                $fields .= ", ";
                $values .= ", ";
                $subQuery .= " AND ";
            }
            
        }
        
        if ($fields != "")
        {
            
            $query = "INSERT INTO contacts ($fields) VALUES ($values)";
            $stmt = $this->db->prepare($query);
            $stmt->execute($executeArray);
            
            //$query = "SELECT id FROM contacts WHERE $subQuery";
            //print $query;
            //$stmt = $this->db->prepare($query);
            //$stmt->execute($executeArray);
            //return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
    }
    
        
    public function updateContact($contactFields,$id) {
        
        $subQuery = "";
        $executeArray = array();
        $numberOfFields = count($contactFields);
    
        foreach ($contactFields as $index => $value)
        {
            $subQuery .= $value['field']."=:".$value['field'];
            
            $executeArray[$value['field']] = $value['term'];
            
            //if it is not the last element add colon
            if ($index+1 < $numberOfFields)
            {
                $subQuery .= ", ";
            }
            
        }
        
        $executeArray['id'] = $id;
        
        if ($subQuery != "")
        {
            
            $query = "UPDATE contacts SET $subQuery WHERE id=:id";
            $stmt = $this->db->prepare($query);
            $stmt->execute($executeArray);
            
        }
       
    }
    
    public function searchSingleContact($id)
    {
        $query = "SELECT * FROM contacts WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    
    //accepts an array formatted ad internalFieldName => value
    //returns an array formatted the same
    public function searchContacts($searchValues)
    {
        
        $subquery='';
        $executeArray = array();
        $numberOfFields = count($searchValues);
    
        foreach ($searchValues as $index => $value)
        {
            $field = $value['field'];
            $term = $value['term'];
                        
            //if there is a - before the keyword performs a negative search
            if ($term[0] == '-')
            {
                //delete the - sign
                $term = substr($term,1,strlen($term)-1);
                $likeOrNot = "NOT LIKE";
            } else //otherwise a normal search
            {
                $likeOrNot = "LIKE";    
            }
            
            $subquery .= $field." ".$likeOrNot." :".$field.$index;
            
            //if it is not the last element add AND
            if ($index+1 < $numberOfFields)
            {
                $subquery .= " AND ";
            }
            
            $executeArray[$field.$index] = "%$term%";
            
            
            
            
        }
        //print "subquery ".$subquery;
        //PRINT "executeArray# ";
        //print_r($executeArray);
        if ($subquery != '')
        {
            $query = "SELECT * FROM contacts WHERE ($subquery)";
            //print $query;
            $stmt = $this->db->prepare($query);
            $stmt->execute($executeArray);
            
        
            //print_r($stmt->fetch(PDO::FETCH_ASSOC));
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
             
        }
        
    }
    
    
    
    
}
?>