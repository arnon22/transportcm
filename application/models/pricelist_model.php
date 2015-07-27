<?php
class Pricelist_model extends CI_Model{
    
    public function __construct(){
       parent::__construct();
    }
    
    
    public function show_feild(){
        $query = $this->db->get('pricelist');
        
        
        return $query->list_fields();
        
    }// end of show feild();
    
    
    public function pricelist_result(){
        
        $query = $this->db->get('pricelist');
        
        return $query->result();
        
    }
    
    
    public function show_pricelist2(){
        
        

        for($i=1;$i<=3;$i++){
            
            
            $strSql = "SELECT DISTINCT pr.price FROM transport_pricelist AS pr LEFT JOIN distancecode AS dis ON(pr.distance_id=dis.distance_id)
JOIN transport_cubiccode AS cubic ON (pr.cubic_id = cubic.cubic_id)
WHERE pr.start_date = '0000-00-00' or pr.start_date < NOW() AND pr.distance_id =".$i."";


            $query = $this->db->query($strSql);
            
            
            
            foreach($query->result() as $row){
                
                
                $result[]=array('c_price'=>$row->price);
                
            }
            
            $data[] =$result;
            
            //$data[]=array_merge($res[$i],$result);
            
        }
        
        
        

        
        
        //$result = $query->result_array();
        
        //return json_encode($data); 
        
        return $data;
       
      
        
        
    }
    
    /*
    public function check_item_price($factory_id,$cubic_id,$distance_id){
        
        $str_sql="SELECT DISTINCT price FROM transport_pricelist WHERE status_pricelist = 1 AND site_id = $factory_id AND cubic_id =$cubic_id AND distance_id=$distance_id AND (start_date =0000-00-00 OR start_date < NOW() ) AND (end_date=0000-00-00 OR end_date > NOW() )
GROUP BY site_id
ORDER BY start_date";
        
        
    }
    */
    
    
    
    public function getPrice($factory_id,$cubic_id,$distance_id){
        $strSql = "SELECT DISTINCT price FROM pricelist WHERE factory_id =$factory_id AND cubic_id=$cubic_id AND distance_id=$distance_id AND ((start_date='0000-00-00'OR start_date < NOW()) AND (end_date='0000-00-00' OR end_date > NOW()) )";
        
         $query = $this->db->query($strSql);
         
         return $query->result_array();
    }
    
    public function jsonPricelist($factory_id,$cubic_id,$distance_id){
        $strSql ="SELECT DISTINCT price FROM pricelist WHERE factory_id =$factory_id AND cubic_id=$cubic_id AND distance_id=$distance_id AND ((start_date='0000-00-00'OR start_date < NOW()) AND (end_date='0000-00-00' OR end_date > NOW()) )";
        
        $query = $this->db->query($strSql);
        
        if($this->db->affected_rows() > 0){
        
        foreach($query->result_array() AS $rows){
            $data_price[] = array('price'=>$rows['price']);
            
        }
        
        }else{
            $data_price[] = array('price'=>'0');
        }
        
        return $data_price;
        
        
        
    } // End of jsonPricelist($factory_id,$cubic_id,$distance_id)
    
    
    
    
    
    
    
    
    
     public function json_search_pricelist($start_date,$end_date,$factory_id){
        
        $Page = isset($_POST['page'])? intval($_POST['page']):1;
        $Rows = isset($_POST['rows'])? intval($_POST['rows']):10;
        $Sort = isset($_POST['sort'])? intval($_POST['sort']):'pricelist_id';
        $Order = isset($_POST['order'])? intval($_POST['order']):'asc';      
        
          
        $Offset = ($Page)*$Rows;
        
        $Result = array(); 
        
        $strSql = "SELECT auto_price_id ,price,tb_co.distance_id,distance_code,distance_name,tb_co.cubic_id,cubic_value,tb_co.factory_id,factory_code,start_date,end_date FROM `auto_pricelist` AS a_pr LEFT JOIN table_codeprice AS tb_co ON (a_pr.code_price=tb_co.code_price)
INNER JOIN distancecode AS dis ON (tb_co.distance_id=dis.distance_id) INNER JOIN transport_cubiccode AS cubic ON (tb_co.cubic_id=cubic.cubic_id)
INNER JOIN transport_factory AS fac ON (fac.factory_id=tb_co.factory_id)
WHERE fac.factory_id =$factory_id AND (a_pr.start_date >='$start_date' OR start_date <='$end_date') AND (end_date >='$start_date' OR end_date <= '$end_date')";
        
        $Result['total']=$this->db->query($strSql)->num_rows();
        
        $Row = array();
        
        $this->db->limit($Rows,$Offset);
        $this->db->order_by($Sort,$Order);
        
        $query = $this->db->query($strSql);
        
        foreach($query->result_array() as $data){
            $Row[]=array(
            'pricelist_id'=>$data['auto_price_id'],
            'price'=>$data['price'],
            'site_id'=>$data['factory_code'],
            'distance_name'=>$data['distance_name'],
            'cubic_id'=>$data['cubic_id'],
            'cubic_value'=>$data['cubic_value'],
            'distance_id'=>$data['distance_code'],
            'start_date'=>$data['start_date'],
            'end_date'=>$data['end_date']   
            );
            
        }
        
        $Result = array_merge($Result,array('rows'=>$Row));
        
        return json_encode($Result);
       
        
    }// end of json_search_pricelist()
    
    
    
    public function json_all_pricelist(){
        
        $Page = isset($_POST['page'])? intval($_POST['page']):1;
        $Rows = isset($_POST['rows'])? intval($_POST['rows']):10;
        $Sort = isset($_POST['sort'])? intval($_POST['sort']):'pricelist_id';
        $Order = isset($_POST['order'])? intval($_POST['order']):'asc';
     


        $Offset = ($Page)*$Rows;
        
        $Result = array();
        
        $strSql ="SELECT auto_price_id ,price,distance_code,distance_name,tb_co.cubic_id,cubic_value,tb_co.factory_id,factory_code,start_date,end_date FROM `auto_pricelist` AS a_pr LEFT JOIN table_codeprice AS tb_co ON (a_pr.code_price=tb_co.code_price)
INNER JOIN distancecode AS dis ON (tb_co.distance_id=dis.distance_id) INNER JOIN transport_cubiccode AS cubic ON (tb_co.cubic_id=cubic.cubic_id)
INNER JOIN transport_factory AS fac ON (fac.factory_id=tb_co.factory_id)
WHERE (a_pr.start_date ='0000-00-00' OR start_date <= NOW() ) AND (end_date ='0000-00-00' OR end_date >= NOW() ) AND a_pr.`status`=1
ORDER BY factory_id,tb_co.distance_id";
        
        $Result['total']=$this->db->query($strSql)->num_rows();
        
        //$Result['total'] = $this->db->get('transport_pricelist')->num_rows();
        $Row = array();
        
        $this->db->limit($Rows,$Offset);
        $this->db->order_by($Sort,$Order);
        
        //$query = $this->db->get('transport_pricelist');
        
        $query = $this->db->query($strSql);
        
        foreach($query->result_array() as $data){
             $Row[]=array(
            'pricelist_id'=>$data['auto_price_id'],
            'price'=>$data['price'],
            'site_id'=>$data['factory_code'],
            'distance_name'=>$data['distance_name'],
            'cubic_id'=>$data['cubic_id'],
            'cubic_value'=>$data['cubic_value'],
            'distance_id'=>$data['distance_code'],
            'start_date'=>$data['start_date'],
            'end_date'=>$data['end_date']   
            );
        }
        
        $Result = array_merge($Result,array('rows'=>$Row));
        
        return json_encode($Result);
       
        
    }// end of json_all_pricelist()
    
    
    
    
    public function insert_pricelist($data_price){
       
       $query = $this->db->insert('pricelist',$data_price);
       
       return $query->insert_id();
        
    }
    
    
    public function Pricelist_showtable(){
        $strSql = "SELECT DISTINCT pr.pricelist_id,pr.cubic_id,cubic_value,pr.distance_id,dis.distance_name,pr.price FROM transport_pricelist AS pr LEFT JOIN distancecode AS dis ON(pr.distance_id=dis.distance_id)
JOIN transport_cubiccode AS cubic ON (pr.cubic_id = cubic.cubic_id)
WHERE pr.start_date = '0000-00-00' or pr.start_date < NOW() AND pr.distance_id = 1";

        $query = $this->db->query($strSql);
        
        $result = $query->result_array();
        
        return json_encode($result);       
        
    }
    
    
    public function Pricelist_showtable2(){
        $strSql = "SELECT DISTINCT pr.price FROM transport_pricelist AS pr LEFT JOIN distancecode AS dis ON(pr.distance_id=dis.distance_id)
JOIN transport_cubiccode AS cubic ON (pr.cubic_id = cubic.cubic_id)
WHERE pr.start_date = '0000-00-00' or pr.start_date < NOW() AND pr.distance_id = 1";

        $query = $this->db->query($strSql);
        
        $result = $query->result_array();
        
        return json_encode($result); 
        //return $result;      
        
    }
    
    
    public function showtable3(){
        $query = $this->db->get('pricelist');
        $ss= $query->num_fields();
        
        
        return $ss;
        
        
        
              
        
    }
    
    
    public function getNumDistance($distance_id){
        
        $query = $this->db->where('distance_id',$distance_id)->get('transport_pricelist');
        
        $nums = $query->num_rows();
        
        return $nums;
        
    }
    
    public function TitleDistance(){
        
        $query = $this->db->get('distancecode');
        
        return $query->result();
        
    }
    
    
    public function result_realdistance($real_distance){
        
        $str_sql = "SELECT distance_id,distance_code FROM distancecode WHERE range_min <=$real_distance and range_max >=$real_distance";
        
        $query = $this->db->query($str_sql);
        
        return $query->result_array();
        
        
    }
    
    
    
    
    
    
    
    
}//end class




?>