<?php
// Products Model @20-05-2013 By Anon.D
class Products_model extends CI_Model{
    
    public function get_json_product($products_id){
        
        $query = $this->db->where('products_id',$products_id)->get('transport_products');
        $rows = $this->db->affected_rows();
        
        if($rows>0){
            
        foreach($query->result_array() as $row){
            $data_product[] = array(
                'products_id'=>$row['products_id'],
                'products_code'=>$row['products_code'],
                'products_name'=>$row['products_name'],
                'products_note'=>$row['products_note'],
                'products_status'=>$row['products_status']
            );
            
            return $data_product;
            exit();
            
        }   //end of foreach 
            
            
        }  //end if
        

    } // end get_json_product
    
     public function getjson_products(){
        $strSql = "SELECT * FROM transport_products ";
        
        $query = $this->db->query($strSql);
        
        foreach($query->result_array() as $row){
            $data_products[] = array(
                'products_id'=>$row['products_id'],
                'products_code'=>$row['products_code'],
                'products_name'=>$row['products_name'],
                'products_note'=>$row['products_note'],
                'products_status'=>$row['products_status']
            );
        }   //end of foreach 
            
            return $data_products;
            exit();
      
        

    } // end get_json_products
    
    
   
    
    
    public function update_product($data,$products_id){
        
        $this->db->where('products_id',$products_id)->update('transport_products',$data);
        
        $num = $this->db->affected_rows();
        
        return $num;
        
    }//End of Function update_product
    
    
    
    
    
    
} // End of Class





?>