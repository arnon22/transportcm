<?php

class Price_model extends CI_Model
{


    public function __construct()
    {

        parent::__construct();
    }


    public function get_numscolunms()
    {

        $query = $this->db->get('transport_cubiccode');

        $num = $query->num_rows();

        return $num;
    }

    public function get_namecolunms()
    {

        $query = $this->db->get('transport_cubiccode');

        foreach ($query->result() as $row)
        {
            $data[] = array('cubic_value' => $row->cubic_value);
        }

        return $data;

    }

    public function get_numsrowsprice()
    {

        $query = $this->db->get('distancecode');
        //$query = $this->db->get_where('transport_distancecode',array('status'=>'1'));

        $num = $query->num_rows();

        return $num;
    }

    public function get_namerows()
    {

        $query = $this->db->get('distancecode');

        foreach ($query->result() as $row)
        {
            $data[] = array('distance_name' => $row->distance_name);

        }

        return $data;

    }

    public function update_price_order($order_id, $price)
    {
        $or_id = $order_id;
        $order_price = $price;
        $data = array('price' => $order_price);

        $this->db->where('id', $or_id);
        $this->db->update('orders', $data);


    }


    public function get_order_Price($factory_id, $cubic_id, $distance_id, $order_date =
        '0000-00-00')
    {
        //$strSql = "SELECT DISTINCT price FROM pricelist WHERE factory_id =$factory_id AND cubic_id=$cubic_id AND distance_id=$distance_id AND ((start_date='0000-00-00'OR start_date < NOW()) AND (end_date='0000-00-00' OR end_date > NOW()) )";
        $strSql = "SELECT DISTINCT
	price
FROM
	`pricelist`
WHERE
	factory_id = '$factory_id'
AND cubic_id = '$cubic_id'
AND distance_id = '$distance_id'
AND ( (start_date='0000-00-00' || start_date <= DATE_FORMAT('$order_date','%Y-%m-%d')) 
AND (end_date='0000-00-00' || end_date >= DATE_FORMAT('$order_date','%Y-%m-%d')))
LIMIT 1";

        $query = $this->db->query($strSql);

        $order_price = "";

        $num = $query->num_rows();
        if ($num > 0)
        {
            foreach ($query->result_array() as $row)
            {
                $order_price = $row["price"];

            } //End Of foreach
        } else
        {
            $order_price = null;
        } //end if


        return $order_price;

        //return $query->result_array();
    }

    public function check_before_update_price($price_id)
    {

        $str_sql = "SELECT DISTINCT
	DATE(start_date) AS start_date,
    DATE(end_date) AS end_date
FROM
	pricelist
WHERE
	id = '$price_id'";


        $query = $this->db->query($str_sql);

        foreach ($query->result() as $row)
        {
            $data['start_date'] = $row->start_date;
            $data['end_date'] = $row->end_date;
            //$data[] = array('start_date'=>$row->start_date);

        }


        return $data;
    } //public function check_before_update_price


    public function row_distance()
    {
        $str = "SELECT DISTINCT distance_id,distance_name FROM distancecode WHERE distance_status=1 ORDER BY distance_id ASC";

        $result = $this->db->query($str);


        return $result->result_array();

    }

    public function row_distanceName()
    {
        $str = "SELECT DISTINCT distance_id,distance_name FROM distancecode WHERE distance_status=1 ORDER BY distance_id ASC";

        $result = $this->db->query($str);

        foreach ($result->result() as $rs)
        {

            $data[$rs->distance_id] = $rs->distance_name;

        }

        return $data;

    }

    public function header_cubic()
    {

        //$query = $this->db->where('cubic_status', 1)->order_by('cubic_value','ASC')->get('transport_cubiccode');

        $str_sql = "SELECT cubic_id,cubic_value FROM transport_cubiccode WHERE cubic_status=1 ORDER BY cubic_value ASC ";
        $query = $this->db->query($str_sql);

        return $query->result();
        // return $result->result_array();


    } // end of header_cubic()

    public function titlehead_cubic()
    {

        $query = $this->db->where('cubic_status', 1)->order_by('cubic_value', 'ASC')->
            get('transport_cubiccode');

        return $query->result_array();


    } // end of header_cubic()


    public function dispalyPrice($factory_id = '0', $startDate = '0000-00-00', $endDate =
        '0000-00-00')
    {
      // $num = 23;
        $data_price = array();
        #  for($m=1;$m<=$num;$m++){

        $str_sql1 = "SELECT DISTINCT distance_id,distance_name FROM distancecode WHERE distance_status=1 ORDER BY distance_id ASC";

        $q1 = $this->db->query($str_sql1);

        foreach ($q1->result() as $row1)
        {
            $dis_id = $row1->distance_id;

            //$str_sql = "SELECT DISTINCT id,cubic_id,price ,factory_id,distance_id FROM `pricelist` WHERE factory_id =3 AND distance_id=$dis_id ORDER BY cubic_id,id ASC ";

            $str_sql = "SELECT DISTINCT
	*
FROM
	`pricelist`
WHERE
	DATE(start_date) <= '$startDate'
AND DATE(end_date) >= '$endDate'
AND factory_id = '$factory_id'
ORDER BY
	distance_id,
	cubic_id ASC";


            $q2 = $this->db->query($str_sql);

            $data[$dis_id]["distance"] = $row1->distance_name;

            $data2 = array();
            foreach ($q2->result() as $row2)
            {
                $data_price[$row2->distance_id][$row2->cubic_id] = $row2->price;
                $data_price[$row2->distance_id]['factory_id'] = $row2->factory_id;
                $data_price[$row2->distance_id]['start_date'] = $row2->start_date;
                $data_price[$row2->distance_id]['end_date'] = $row2->end_date;


            }

        } //end of

        $data2 = $data_price;


        return $data2;


    } //end of display price


    public function rows_distance()
    {
        $strSql = "SELECT DISTINCT distance_id,distance_name FROM distancecode
WHERE distance_status =1";

        $result = $this->db->query($strSql);

        return $result->result();

    } // end of function rows_distance

    public function cols_cubic()
    {

    } // end of function cols_cubic

    public function countRows()
    {
        $query = $this->db->get_where('transport_distancecode', array('distance_status' =>
                '1'));

        $num = $query->num_rows();

        return $num;

    } // end of function countRows
    public function countCols()
    {
        $query = $this->db->get_where('transport_cubiccode', array('cubic_status' => '1'));
        $num = $query->num_rows();
        return $num;

    } // end of function countCols

    public function displayPrice2()
    {
        $strSql = "SELECT
	*
FROM
	`pricelist`
WHERE
	DATE(start_date) <= '2014-03-15'
AND DATE(end_date) >= '2014-03-31'
AND factory_id = '3'
ORDER BY
	distance_id,
	cubic_id ASC";

        #$rows = $this->countRows();
        #$cols = $this->countCols();


        $rs = $this->db->query($strSql);

        foreach ($rs->result() as $row)
        {

            $data[$row->distance_id][$row->cubic_id] = $row->price;

        }


        $data_price[] = $data;


        $rows = $this->rows_distance();

        foreach ($rows as $rs)
        {
            $data2['distance'] = $rs->distance_name;
        }


        return $data2;


    } //end of function displayPrice


    public function getPricelist_id($factory_id, $distance_id, $cubic_id, $startDate =
        '0000-00-00', $endDate = '0000-00-00')
    {


    } //end of function getPricelist_id


    public function recursive_price($factory, $distance_id, $cubic_id, $price, $start_date =
        '0000-00-00', $end_date = '0000-00-00')
    {
        
        $factory_id = $factory;
        $dis_id = $distance_id;
        $cub_id = $cubic_id;
        $p_price = $price;
        $startDate=$start_date;
        $endDate = $end_date;
         
         $price_id = $this->check_price_id($factory_id,$dis_id,$cub_id,$startDate,$endDate);
         
         if($price_id > 0){
            // Update
            $str = "UPDATE `pricelist` SET `price`='$p_price' WHERE (`id`='$price_id')";
            
         }else{
            //Insert
            $str ="INSERT INTO `pricelist` (
	`factory_id`,
	`cubic_id`,
	`distance_id`,
	`price`,
	`start_date`,
	`end_date`
)
VALUES
	(
		'$factory_id',
		'$cub_id',
		'$dis_id',
		'$p_price',
		'$startDate',
		'$endDate'
	)";
            
         } // end if
         
         
         $result = $this->db->query($str);
         
         $check_num = $result->num_rows();
         
         
         
         if($check_num > 0){
           return true;
         }else{
            return false;
         }
         
         
         
         
         
                

    } //End of Function


    public function check_price_id($factory, $distance_id, $cubic_id, $startDate =
        '0000-00-00', $endDate = '0000-00-00')
    {
        $strSQL = "SELECT DISTINCT
	id AS price_id
FROM
	`pricelist`
WHERE
	factory_id = '$factory'
AND cubic_id = '$cubic_id'
AND distance_id = '$distance_id'
AND ( (start_date='0000-00-00' || start_date <= DATE_FORMAT('$startDate','%Y-%m-%d')) 
AND (end_date='0000-00-00' || end_date >= DATE_FORMAT('$startDate','%Y-%m-%d')))
LIMIT 1";

        $query = $this->db->query($strSQL);

        $nums = $query->num_rows();

        if ($nums > 0)
        {

            foreach ($query->result() as $rs)
            {

                $price_id = $rs->price_id;
            }

        } else
        {
            $price_id = 0;
        }


        return $price_id;


    } // check_price_id


} //End of Class


?>