<?php

class Cars_model extends CI_Model
{
    public function __construct()
    {

    } // end of construct

    public function get_Allcar()
    {

        $query = $this->db->where('status', 1)->get('transport_cars');

        return $query->result_array();


    }

    public function checkCarnumber($car_number)
    {
        $str = "";
    }

    public function getCar_number($car_id)
    {
        $str = "SELECT DISTINCT car_number  FROM transport_cars WHERE car_id =$car_id";
        $result = $this->db->query($str);

        if ($result->num_rows() > 0)
        {
            foreach ($result->result() as $row)
            {
                $data = $row->car_number;
            }
            return $data;
        }


    }

    public function SummaryOrders($cars_id = 0, $startDate = '0000-00-00', $endDate =
        '0000-00-00')
    {

        $str = "SELECT
	car.car_number,SUM(real_distance) AS total_Distance, SUM(cubic_value) AS total_Cubic,SUM(use_oil) AS total_Useoil
FROM
	orders AS o_S
LEFT JOIN transport_cubiccode AS c_B ON (o_S.cubic_id=c_B.cubic_id)
LEFT JOIN distancecode AS d_T ON (o_S.distance_id=d_T.distance_id)
LEFT JOIN transport_cars AS car ON (o_S.car_id=car.car_id)
WHERE o_S.car_id =$cars_id AND order_date BETWEEN '$startDate' AND '$endDate'";

        $query = $this->db->query($str);

        if ($query->num_rows() > 0)
        {

            foreach ($query->result() as $row)
            {
                $data = array(
                    'total_distance' => $row->total_Distance,
                    'total_cubic' => $row->total_Cubic,
                    'total_useoil' => $row->total_Useoil,
                    'car_number' => $row->car_number);

            }

            return $data;
        }


    } //End of SummaryOrders


    public function carDetail_Orders($cars_id = 0, $startDate = '0000-00-00', $endDate =
        '0000-00-00')
    {


        //$str_sql = "SELECT * FROM orders WHERE car_id =$cars_id AND order_date BETWEEN '$startDate' AND '$endDate' ";

        $str_sql = "SELECT
order_date,dp_number,factory_code,distance_code,real_distance,cubic_value,car_number,driver.driver_name
FROM
	orders AS O_R
LEFT JOIN transport_factory AS fac ON (
	O_R.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS Cus ON (
	O_R.customer_id = Cus.customer_id
)
LEFT JOIN transport_cubiccode AS Cub ON(O_R.cubic_id = Cub.cubic_id)
LEFT JOIN distancecode AS Dis ON (O_R.distance_id = Dis.distance_id)
LEFT JOIN transport_driver AS driver ON(O_r.driver_id=driver.driver_id)
LEFT JOIN transport_cars AS car ON(O_R.car_id=car.car_id)
WHERE
	O_R.car_id = $cars_id
AND order_date BETWEEN '$startDate'
AND '$endDate' ";


        $query = $this->db->query($str_sql);

        if ($query->num_rows() > 0)
        {

            foreach ($query->result() as $row)
            {

                $data_order[] = array(
                    "Order_date" => $row->order_date,
                    "Dpnumber" => $row->dp_number,
                    "FactoryCode" => $row->factory_code,
                    "DistanceCode" => $row->distance_code,
                    "RealDistance" => $row->real_distance,
                    "cubic_value" => $row->cubic_value,
                    "car_number" => $row->car_number,
                    "driver_name" => $row->driver_name);
            } // End of foreach
        } //end if

        return $data_order;
    }

    public function total_recive($cars_id = 0, $startDate = '0000-00-00', $endDate =
        '0000-00-00')
    {

        $str_sql = "SELECT SUM(price) AS receiveTotalAmount FROM orders
WHERE car_id=$cars_id AND order_date BETWEEN '$startDate' AND '$endDate' ";

        $query = $this->db->query($str_sql);

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $rows)
            {
                $totalRecive = $rows->receiveTotalAmount;

            }

        }

        if ($totalRecive == "")
        {
            $totalRecive = 0;
        }

        return $totalRecive;
    } // end of function total_recive

    public function total_NumRecive($cars_id = 0, $startDate = '0000-00-00', $endDate =
        '0000-00-00')
    {

        $str_sql = "SELECT *  FROM orders
WHERE car_id=$cars_id AND order_date BETWEEN '$startDate' AND '$endDate' ";

        $query = $this->db->query($str_sql);

        if ($query->num_rows() > 0)
        {
            $total_CountRecive = $query->num_rows();
        } else
        {
            $total_CountRecive = 0;
        }


        return $total_CountRecive;
    }

    public function total_expense($cars_id = 0, $startDate = '000-00-00', $endDate =
        '0000-00-00')
    {
        $str_sql = "SELECT SUM(total_amount)AS ExpenseAmount FROM expense WHERE car_id =$cars_id AND expense_date BETWEEN '$startDate' AND '$endDate' ";

        $query = $this->db->query($str_sql);

        if ($query->num_rows > 0)
        {
            foreach ($query->result() as $rows)
            {
                $totalExpense = $rows->ExpenseAmount;
            }

        }

        if ($totalExpense == "")
        {
            $totalExpense = 0;
        }

        return $totalExpense;


    } //End of function total_expense

    public function expense_oil($cars_id = 0, $startDate = '000-00-00', $endDate =
        '0000-00-00')
    {
        /*
        $str_sql = "SELECT	
	SUM(sell_amount) AS OilsellAmount
FROM
	oilstock AS oil
WHERE
car_id =$cars_id AND oil_type = 2 AND stock_date BETWEEN '$startDate' AND '$endDate' ";
*/

    $str_sql ="SELECT	
	SUM(sell_amount) AS OilsellAmount
FROM
	oilstock AS oil
WHERE
oil_type = 2 AND stock_date BETWEEN '$startDate' AND '$endDate' AND
car_id =(SELECT
			c1.car_id
		FROM
			transport_oilcars AS c1
		LEFT JOIN transport_cars AS c2 ON (
			c1.car_number = c2.car_number
		)
		WHERE
			c2.car_id =$cars_id)";

    


        $query = $this->db->query($str_sql);

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $oil_expense = $row->OilsellAmount;

            } //end foreach
        }
        if ($oil_expense == "")
        {
            $oil_expense = 0;
        }


        return $oil_expense;


    } //End of function expense_oil


    public function Cardetail_oilsellList($cars_id = 0, $startDate = '000-00-00', $endDate =
        '0000-00-00')
    {
        /*
        $str_sql = "SELECT
        stock_date,stock_details,Oils.ref_number,factory_code,factory_name,sell_oil,sell_price,sell_amount,car_number,Oils.note As Note
        FROM
        oilstock AS Oils
        LEFT JOIN transport_factory AS fac ON(Oils.factory_id = fac.factory_id)
        LEFT JOIN transport_cars AS car ON(Oils.car_id = car.car_id)
        WHERE Oils.car_id = $cars_id AND oil_type =2 AND stock_date BETWEEN '$startDate' AND '$endDate' ";
        */
        
        $str_sql ="SELECT
	stock_date,
	stock_details,
	Oils.ref_number,
	factory_code,
	factory_name,
	sell_oil,
	sell_price,
	sell_amount,
	Oils.note AS Note
FROM
	oilstock AS Oils
LEFT JOIN transport_factory AS fac ON (
	Oils.factory_id = fac.factory_id
)
WHERE
	Oils.car_id = (
		SELECT
			c1.car_id
		FROM
			transport_oilcars AS c1
		LEFT JOIN transport_cars AS c2 ON (
			c1.car_number = c2.car_number
		)
		WHERE
			c2.car_id = '$cars_id'
	)
AND oil_type = 2
AND stock_date BETWEEN '$startDate'
AND '$endDate'";


        $query = $this->db->query($str_sql);

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {
                $Oil_sellList[] = array(
                    "Date" => $row->stock_date,
                    "Details" => $row->stock_details,
                    "ref_number" => $row->ref_number,
                    "Factory_code" => $row->factory_code,
                    "factory_name" => $row->factory_name,
                    "Carnumber" => $row->car_number,
                    "SellOil" => $row->sell_oil,
                    "Sell_price" => $row->sell_price,
                    "TotalAmount" => $row->sell_amount,
                    "Note" => $row->Note);
            }


        } // End if

        return $Oil_sellList;


    } // End of function Cardetail_oilsellList

    public function expense_car($cars_id = 0, $startDate = '000-00-00', $endDate =
        '0000-00-00')
    {

        $str_sql = "SELECT expense_date,ref_number,factory_code,expense_details,total_amount,note FROM expense AS Exs
LEFT JOIN transport_factory AS fac ON(Exs.factory_id=fac.factory_id)
WHERE Exs.car_id =$cars_id AND Exs.expense_date BETWEEN '$startDate' AND '$endDate'";

        $query = $this->db->query($str_sql);

        if ($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
            {

                $expense_list[] = array(
                    "Date" => $row->expense_date,
                    "FactoryCode" => $row->factory_code,
                    "Ref.Number" => $row->ref_number,
                    "Details" => $row->expense_details,
                    "TotalAmount" => $row->total_amount,
                    "Remark" => $row->note);

            } // end foreach
        } // end if

        return $expense_list;

    } //End of function expense_car


} //end of Class


?>