<?php
class Order_model extends CI_Model{
    
     public function __construct(){
        
        parent::__construct();
    }
    
    
    public function getCubic(){
        $query = $this->db->where('cubic_status',1)->get('transport_cubiccode');;
        
        return $query->result_array();  
        
        
              
    }
    
    public function get_order_modal($id){
        $this->db->select('order_id,order_number,orders.created_datetime,dp_number,factory_name,factory_code,customers_name,contact_person,mobile_number,phone_number,transport_customers.address1,real_distance,distance_code,cubic_code,car_number,driver_name,delivery_datetime,username');
        $this->db->from('orders');
        $this->db->join('transport_customers','orders.customer_id=transport_customers.customers_id','left');
        $this->db->join('transport_factory','orders.factory_id=transport_factory.factory_id','left');
        $this->db->join('distancecode','orders.distance_id=distancecode.distance_id','left');
        $this->db->join('transport_cubiccode','orders.cubic_id=transport_cubiccode.cubic_id','left');
        $this->db->join('transport_cars','orders.car_id=transport_cars.car_id','left');
        $this->db->join('transport_driver','orders.driver_id=transport_driver.driver_id','left');
        $this->db->join('users','orders.user_id=users.id','left');

        $this->db->where('order_id',$id);
        $query = $this->db->get();
        
        return $query->result();
        
        
    }  public function select_edit_order($id){
        $this->db->select('order_id,order_number,orders.created_datetime,dp_number,factory_name,factory_code,customers_name,contact_person,mobile_number,phone_number,transport_customers.address1,real_distance,distance_code,cubic_code,cubic_value,car_number,driver_name,delivery_datetime,username');
        $this->db->from('orders');
        $this->db->join('transport_customers','orders.customer_id=transport_customers.customers_id','left');
        $this->db->join('transport_factory','orders.factory_id=transport_factory.factory_id','left');
        $this->db->join('distancecode','orders.distance_id=distancecode.distance_id','left');
        $this->db->join('transport_cubiccode','orders.cubic_id=transport_cubiccode.cubic_id','left');
        $this->db->join('transport_cars','orders.car_id=transport_cars.car_id','left');
        $this->db->join('transport_driver','orders.driver_id=transport_driver.driver_id','left');
        $this->db->join('users','orders.user_id=users.id','left');

        $this->db->where('order_id',$id);
        $query = $this->db->get();
        
        return $query->result();
        
        
    }
    
    public function order_report_summary(){       
        
         $this->db->select('*,dp_number,customers_name,car_number,');
         $this->db->from('orders');
        $this->db->join('transport_customers','orders.customer_id=transport_customers.customer_id','left');
       // $this->db->join('transport_factory','orders.factory_id=transport_factory.factory_id','left');
       // $this->db->join('distancecode','orders.distance_id=distancecode.distance_id','left');
       // $this->db->join('transport_cubiccode','orders.cubic_id=transport_cubiccode.cubic_id','left');
       $this->db->join('transport_cars','orders.car_id=transport_cars.car_id','left');
       // $this->db->join('transport_driver','orders.driver_id=transport_driver.driver_id','left');
       // $this->db->join('users','orders.user_id=users.id','left');

        //$this->db->where('order_id',$id);
       $query = $this->db->get();
        
        //$query = $this->db->get('orders');
        
        //$query = $this->db->get('orders');
        return $query->result_array();
        
        //return $query->result();
        
        
    }
    
    public function order_report_select_summary($start_date,$end_date){
        
        
        $str_sql = "SELECT dp_number,customers_name,distance_code,cubic_value,car_number,orders.order_date,driver_name,orders.use_oil,orders.remark FROM orders
LEFT JOIN transport_factory AS factory ON orders.factory_id=factory.factory_id
LEFT JOIN transport_cars AS car ON orders.car_id=car.car_id
LEFT JOIN driver ON orders.driver_id=driver.driver_id
LEFT JOIN transport_cubiccode AS cubic ON (orders.cubic_id=cubic.cubic_id)
LEFT JOIN distancecode AS distance ON (orders.distance_id=distance.distance_id)
LEFT JOIN transport_customers AS customer ON(orders.customer_id=customer.customer_id)
WHERE orders.order_date BETWEEN '".$start_date."' AND '".$end_date."'";
        
        $query = $this->db->query($str_sql);

        //return $query->result();
        
        return $query->result_array();    
        
    }
    
    public function order_report_select_summary2($start_date,$end_date,$factory){
        
        
        $str_sql = "SELECT dp_number,customers_name,distance_code,cubic_value,car_number,orders.order_date,driver_name,orders.use_oil,orders.remark FROM orders
LEFT JOIN transport_factory AS factory ON orders.factory_id=factory.factory_id
LEFT JOIN transport_cars AS car ON orders.car_id=car.car_id
LEFT JOIN driver ON orders.driver_id=driver.driver_id
LEFT JOIN transport_cubiccode AS cubic ON (orders.cubic_id=cubic.cubic_id)
LEFT JOIN distancecode AS distance ON (orders.distance_id=distance.distance_id)
LEFT JOIN transport_customers AS customer ON(orders.customer_id=customer.customer_id)
WHERE orders.order_date BETWEEN '".$start_date."' AND '".$end_date."' AND orders.factory_id='".$factory."'";
        
        $query = $this->db->query($str_sql);

        return $query->result_array();    
        
    }
    
    public function order_report_select_summary3($start_date,$end_date,$car_id){
        
        
        $str_sql = "SELECT dp_number,customers_name,distance_code,cubic_value,car_number,orders.order_date,driver_name,orders.use_oil,orders.remark FROM orders
LEFT JOIN transport_factory AS factory ON orders.factory_id=factory.factory_id
LEFT JOIN transport_cars AS car ON orders.car_id=car.car_id
LEFT JOIN driver ON orders.driver_id=driver.driver_id
LEFT JOIN transport_cubiccode AS cubic ON (orders.cubic_id=cubic.cubic_id)
LEFT JOIN distancecode AS distance ON (orders.distance_id=distance.distance_id)
LEFT JOIN transport_customers AS customer ON(orders.customer_id=customer.customer_id)
WHERE orders.order_date BETWEEN '".$start_date."' AND '".$end_date."' AND orders.car_id='".$car_id."'";
        
        $query = $this->db->query($str_sql);

        return $query->result_array();    
        
    }
    
    public function order_report_select_summary4($start_date,$end_date,$car_id,$factory_id){
        
        
        $str_sql = "SELECT dp_number,customers_name,distance_code,cubic_value,car_number,orders.order_date,driver_name,orders.use_oil,orders.remark FROM orders
LEFT JOIN transport_factory AS factory ON orders.factory_id=factory.factory_id
LEFT JOIN transport_cars AS car ON orders.car_id=car.car_id
LEFT JOIN driver ON orders.driver_id=driver.driver_id
LEFT JOIN transport_cubiccode AS cubic ON (orders.cubic_id=cubic.cubic_id)
LEFT JOIN distancecode AS distance ON (orders.distance_id=distance.distance_id)
LEFT JOIN transport_customers AS customer ON(orders.customer_id=customer.customer_id)
WHERE orders.order_date BETWEEN '".$start_date."' AND '".$end_date."' AND orders.car_id='".$car_id."' AND orders.factory_id='".$factory_id."' ";
        
        $query = $this->db->query($str_sql);

        return $query->result_array();
        
    }
    
    
    
     public function record_count() {
       
        
        $query = $this->db->get('orders');
        
        return $query->num_rows();
    
    
    }// end of record_count()
    
    
    
    public function show_order_list($limit, $start){
        
        /*$strSql = "SELECT order_id,ord.created_datetime,dp_number,fac.factory_name,real_distance,distance_code,cubic_value,driver_name,car_number FROM orders as ord 
LEFT JOIN driver AS driv ON(ord.driver_id=driv.driver_id) 
LEFT JOIN transport_factory as fac on(ord.site_id=fac.factory_id)
LEFT JOIN distancecode as distanc ON (ord.distance_id=distanc.distance_id)
LEFT JOIN transport_cubiccode AS cubic ON (ord.cubic_id=cubic.cubic_id)
LEFT JOIN transport_cars as car ON(ord.car_id=car.car_id)
ORDER BY ord.created_datetime DESC LIMIT $start,$limit";

*/

/* New 
SELECT order_id,orders.created_datetime,dp_number,factory_name,customers_name,real_distance,distance_code,cubic_code,car_number,driver_name,delivery_datetime,username FROM orders LEFT JOIN transport_factory ON orders.factory_id=transport_factory.factory_id
LEFT JOIN transport_customers ON orders.customer_id=transport_customers.customers_id
LEFT JOIN distancecode ON orders.distance_id=distancecode.distance_id
LEFT JOIN transport_cubiccode ON orders.cubic_id=transport_cubiccode.cubic_id
LEFT JOIN transport_cars ON orders.car_id=transport_cars.car_number
LEFT JOIN transport_driver ON orders.driver_id=transport_driver.driver_id
LEFT JOIN users ON orders.user_id=users.id
*/

        $this->db->select('order_id,order_number,orders.created_datetime,dp_number,factory_name,factory_code,customers_name,real_distance,distance_code,cubic_code,car_number,driver_name,delivery_datetime,username');
        $this->db->from('orders');
        $this->db->join('transport_customers','orders.customer_id=transport_customers.customer_id','left');
        $this->db->join('transport_factory','orders.factory_id=transport_factory.factory_id','left');
        $this->db->join('distancecode','orders.distance_id=distancecode.distance_id','left');
        $this->db->join('transport_cubiccode','orders.cubic_id=transport_cubiccode.cubic_id','left');
        $this->db->join('transport_cars','orders.car_id=transport_cars.car_id','left');
        $this->db->join('transport_driver','orders.driver_id=transport_driver.driver_id','left');
        $this->db->join('users','orders.user_id=users.id','left');

       $this->db->limit($limit, $start);
        $query = $this->db->get();
        
        //$query = $this->db->query($strSql);
        
        if($query->num_rows() > 0){        
            foreach($query->result() as $row){
            
            $data[]=$row;
        }
        
        return $data;
            
            
       }
        
        //return false;
        
        
        
        
    }// end of show_order_list;
    
    
    
    public function Add_new_order($data){
        
        $this->db->insert('orders',$data);
        
        if($this->db->affected_rows()!=0){
            
            $save_id = $this->db->insert_id();
            $order_code = date('y'). date('m').sprintf('%05d',$save_id);
            $data2 = array(
                'order_number'=>$order_code
            );
            
           $this->db->where('order_id',$save_id);
           $this->db->update('orders',$data2); 
           
           return $this->db->affected_rows();
           exit();
            
        }
        
        
    }// End of function Add_new_order
    
    
     public function delete_order($order_id){
        
        $this->db->where('order_id',$order_id)->delete('orders');
        
        $num = $this->db->affected_rows();
        
        return $num;
        
        
    }
    
    
    
    
    
    
} //end of class



?>