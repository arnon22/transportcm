<?php

/*Cubivode Model*/

class Cubiccode_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
    
    
    public function record_count() {
        return $this->db->count_all("transport_cubiccode");
    }
    
    public function fetch_cubiccode($limit, $start) {
        $this->db->limit($limit, $start);
        $query = $this->db->get("transport_cubiccode");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
   }
    


    public function getCubiccode()
    {
        $query = $this->db->where('cubic_status', 1)->order_by('cubic_value','ASC')->get('transport_cubiccode');

        return $query->result_array();
    }


    public function get_json_cubiccode()
    {

        $strsql = "SELECT * FROM transport_cubiccode WHERE cubic_status = 1";
        $query = $this->db->select($strsql);

        foreach ($query->result_array() as $rs)
        {

            $data_cubic[] = array();

        } // end of foreach


    } // end of function get_json_cubiccode() "Show for items status =1"
    
     public function getJson_cubiccodes()
    {

        //$strsql = "SELECT * FROM transport_cubiccode";
        //$query = $this->db->select($strsql);
        
        $query =$this->db->get('transport_cubiccode');

        foreach ($query->result_array() as $rows)
        {

            $data_cubic[] = array(
                    'cubic_id'=>$rows['cubic_id'],
                    'cubic_code'=>$rows['cubic_code'],
                    'cubic_value'=>$rows['cubic_value'],
                    'cubic_status'=>$rows['cubic_status'],
                    'cubic_note'=>$rows['cubic_note']
            
            );

        } // end of foeach

        return $data_cubic;
        
        
    } // end of function getJson_cubicodes() "show all item"
    
    
    

    public function show_cubiccode()
    {

        $query = $this->db->get('transport_cubiccode');

        return $query->result_array();

    } // end of function show_cubiccode for display informatind on setting cubiccode page


    public function insert_cubiccode($data_cubic)
    {

        $this->db->insert('transport_cubiccode', $data_cubic);


        $new_cubic_id = $this->db->insert_id();

        return $new_cubic_id;
    }
    
    public function delete_cubic($cubic_id){
        
        $this->db->where('cubic_id',$cubic_id)->delete('transport_cubiccode');
        
        $num = $this->db->affected_rows();
        
        return $num;
        
        
    }
    
    
    
    

} // endd of class

?>