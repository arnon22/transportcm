<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model
{

    function report_income($factory_id = '0', $start_date = '0000-00-00', $end_date =
        '0000-00-00',$remark=null)
    {
        if ($factory_id == "All" || $factory_id == '0') {
            
            if($remark=="All" || $remark==null){
                $str_sql = "SELECT
	DATE(income_date) AS income_date,
	factory_code,
	ref_number,
	income_details,
	total_amount,
	note,
	(SELECT SUM(total_amount) FROM income WHERE income_date BETWEEN '$start_date' AND '$end_date') AS totals
FROM
	income
LEFT JOIN transport_factory AS fac ON (
	income.factory_id = fac.factory_id
)
WHERE DATE(income_date) BETWEEN '$start_date'
AND '$end_date' ORDER BY factory_code,income_date ASC ";
            }else{
                $str_sql = "SELECT
	DATE(income_date) AS income_date,
	factory_code,
	ref_number,
	income_details,
	total_amount,
	note,
	(SELECT SUM(total_amount) FROM income WHERE income_date BETWEEN '$start_date' AND '$end_date') AS totals
FROM
	income
LEFT JOIN transport_factory AS fac ON (
	income.factory_id = fac.factory_id
)
WHERE DATE(income_date) BETWEEN '$start_date'
AND '$end_date' AND note='$remark' ORDER BY factory_code,income_date ASC ";
            }
            

        } else {
            
            if($remark=="All" || $remark==null){
                $str_sql = "SELECT
	DATE(income_date) AS income_date,
	factory_code,
	ref_number,
	income_details,
	total_amount,
	note,
	(SELECT SUM(total_amount) FROM income WHERE factory_id=$factory_id AND DATE(income_date) BETWEEN '$start_date' AND '$end_date') AS totals
FROM
	income
LEFT JOIN transport_factory AS fac ON (
	income.factory_id = fac.factory_id
)
WHERE
	income.factory_id = $factory_id
AND DATE(income_date) BETWEEN '$start_date'
AND '$end_date' ORDER BY factory_code,income_date ASC";
            }else{
                $str_sql = "SELECT
	DATE(income_date) AS income_date,
	factory_code,
	ref_number,
	income_details,
	total_amount,
	note,
	(SELECT SUM(total_amount) FROM income WHERE factory_id=$factory_id AND DATE(income_date) BETWEEN '$start_date' AND '$end_date') AS totals
FROM
	income
LEFT JOIN transport_factory AS fac ON (
	income.factory_id = fac.factory_id
)
WHERE
	income.factory_id = $factory_id
AND DATE(income_date) BETWEEN '$start_date'
AND '$end_date' AND note='$remark' ORDER BY factory_code,income_date ASC";
            }
            
        }


        $query = $this->db->query($str_sql);

        if ($query->num_rows() > 0) {

            return $query->result_array();


        } // end if


    } // End of function

    public function display_note($note_type = 'income')
    {
        $check_type = $note_type;

        if ($check_type == 'income') {
            $strSql = "SELECT DISTINCT note FROM income WHERE note!=''";
        } else {
            $strSql = "SELECT DISTINCT note FROM expense WHERE note!=''";
        } // End if
        $query = $this->db->query($strSql);
        $result = $query->result_array();

        return $result;

    } //End of function display_note


    public function check_numreport($factory_id = '0', $start_date = '0000-00-00', $end_date =
        '0000-00-00', $remark = '')
    {
        $note = $remark;

        if ($note == "All" || $note == null) {
            if ($factory_id == '' || $factory_id == 0 || $factory_id == null) {
                $str_sql = "SELECT * FROM income WHERE income_date BETWEEN '$start_date' AND '$end_date'";
            } else {
                $str_sql = "SELECT * FROM income WHERE factory_id = $factory_id AND income_date BETWEEN '$start_date' AND '$end_date'";
            }
        } else {
            if ($factory_id == '' || $factory_id == 0 || $factory_id == null) {
                //$str_sql = "SELECT * FROM income WHERE income_date BETWEEN '$start_date' AND '$end_date' AND note='$note'";
                $str_sql = "SELECT * FROM income WHERE (income_date BETWEEN '$start_date' AND '$end_date') AND TRIM(note)=TRIM('$note')";
            } else {
                $str_sql = "SELECT * FROM income WHERE factory_id = $factory_id AND income_date BETWEEN '$start_date' AND '$end_date' AND TRIM(note)=TRIM('$note')";
            }

        }


        //return $str_sql;
        //end();


        $query = $this->db->query($str_sql);

        $num_report = $query->num_rows();


        if ($num_report == 0 || $num_report == "" || $num_report == null) {
            $num_report = 0;

            return $num_report;
        } else {
            return $num_report;
        }

        //return

    } // End of function check_numreport


    public function expense_normal_remark()
    {

        $str = "SELECT DISTINCT TRIM(note) AS note FROM expense WHERE car_id=0 AND note!='' ORDER BY note ASC ";

        $query = $this->db->query($str);

        $result = $query->result_array();

        //$result = $this->query->result_array();

        return $result;

    }

    public function expense_car_remark()
    {

        $str = "SELECT DISTINCT TRIM(note) AS note FROM expense WHERE car_id!=0 AND note!='' ORDER BY note ASC ";

        $query = $this->db->query($str);

        $result = $query->result_array();

        //$result = $this->query->result_array();

        return $result;

    }

    public function check_numreport_expense($factory_id = '0', $start_date =
        '0000-00-00', $end_date = '0000-00-00', $expenseType, $remark = null, $car_number = null,
        $car_remark = null)
    {
        if ($factory_id == '' || $factory_id == 0 || $factory_id == "All") {

            if ($expenseType == "normal") {

                if ($remark == null || $remark == "All") {
                    #1
                    //$str_sql ="SELECT * FROM expense WHERE car_id=0 AND expense_date BETWEEN '$start_date' and '$end_date'";
                    $str_sql = "SELECT * FROM expense WHERE car_id=0 AND expense_date BETWEEN '$start_date' AND '$end_date' ";


                } else {
                    #2
                    //$str_sql = "SELECT * FROM expense WHERE car_id=0 AND expense_date BETWEEN '$start_date' and '$end_date' AND note='$remark'";
                    $str_sql = "SELECT * FROM expense WHERE car_id=0 AND note='$remark' AND expense_date BETWEEN '$start_date' AND '$end_date' ";
                }


            } // End if

            if ($expenseType == "car") {

                if ($car_number == "All") {

                    if (isset($car_remark) && $car_remark == "All") {
                        #3
                        //$str_sql = "SELECT * FROM expense WHERE car_id!=0 AND expense_date BETWEEN '$start_date' and '$end_date'";
                        $str_sql = "SELECT * FROM expense WHERE car_id!=0 AND expense_date BETWEEN '$start_date' AND '$end_date' ";

                    } else {
                        #4
                        //$str_sql ="SELECT * FROM expense WHERE car_id!=0 AND note='$remark' AND expense_date BETWEEN '$start_date' AND '$end_date'";
                        $str_sql = "SELECT * FROM expense WHERE car_id!=0 AND note ='$car_remark' AND expense_date BETWEEN '$start_date' AND '$end_date' ";
                    }

                } else {

                    if (isset($car_remark) && $car_remark == "All") {
                        #5
                        //$str_sql = "SELECT * FROM expense WHERE car_id=$car_number AND expense_date BETWEEN '$start_date' and '$end_date' ";
                        $str_sql = "SELECT * FROM expense WHERE car_id=$car_number AND expense_date BETWEEN '$start_date' and '$end_date' ";

                    } else {
                        #6
                        $str_sql = "SELECT * FROM expense WHERE car_id=$car_number AND note='$car_remark' AND expense_date BETWEEN '$start_date' and '$end_date' ";
                    }

                }


            } //end if

            // $str_sql = "SELECT * FROM expense WHERE expense_date BETWEEN '$start_date' AND '$end_date'";
        } else {

            //Select Custom Factory generate Report

            if ($expenseType == "normal") {

                if ($remark == null || $remark == "All") {
                    #7
                    //$str_sql = "SELECT * FROM expense WHERE factory_id = $factory_id AND expense_date BETWEEN '$start_date' AND '$end_date'";
                    $str_sql = "SELECT * FROM expense WHERE factory_id = $factory_id AND car_id=0 AND expense_date BETWEEN '$start_date' AND '$end_date' ";
                } else {
                    #8
                    #$str_sql = "SELECT * FROM expense WHERE factory_id = $factory_id AND expense_date BETWEEN '$start_date' AND '$end_date' AND note='$remark'";
                    $str_sql = "SELECT * FROM expense WHERE factory_id = $factory_id AND car_id=0 AND note='$remark' AND expense_date BETWEEN '$start_date' AND '$end_date'";
                }


            } // End if

            if ($expenseType == "car") {

                if ($car_number == "All") {

                    if (isset($car_remark) && $car_remark == "All") {
                        #9
                        $str_sql = "SELECT * FROM expense WHERE factory_id=$factory_id AND car_id!=0 AND expense_date BETWEEN '$start_date' AND '$end_date' ";
                    } else {
                        #10
                        $str_sql = "SELECT * FROM expense WHERE factory_id=$factory_id AND car_id!=0 AND note='$car_remark' AND expense_date BETWEEN '$start_date' AND '$end_date' ";
                    }
                } else {

                    if (isset($car_remark) && $car_remark == "All") {
                        #11
                        //$str_sql = "SELECT * FROM expense WHERE factory_id = $factory_id AND car_id=$car_number AND expense_date BETWEEN '$start_date' and '$end_date'";
                        $str_sql = "SELECT * FROM expense WHERE factory_id =$factory_id AND car_id=$car_number AND expense_date BETWEEN '$start_date' and '$end_date'";

                    } else {
                        #12
                        $str_sql = "SELECT * FROM expense WHERE factory_id =$factory_id AND car_id=$car_number AND note='$car_remark' AND expense_date BETWEEN '$start_date' and '$end_date'";
                    }


                }


            } //end if


        } // End if

        $query = $this->db->query($str_sql);

        $num_report = $query->num_rows();

        if ($num_report == 0 || $num_report == "" || $num_report == null) {
            $num_report = 0;

            return $num_report;
        } else {
            return $num_report;
        }

        //return

    } // End of function check_numreport_expense

    function report_expense($factory_id = '0', $start_date = '0000-00-00', $end_date =
        '0000-00-00', $expenseType, $remark = null, $car_number = null, $car_remark = null)
    {
        if ($factory_id == '' || $factory_id == 0 || $factory_id == "All") {

            if ($expenseType == "normal") {

                if ($remark == null || $remark == "All") {
                    #1
                    //$str_sql = "SELECT * FROM expense WHERE car_id=0 AND expense_date BETWEEN '$start_date' AND '$end_date' ";
                    $str_sql = "SELECT
	expense_date,
	factory_code,
	ref_number,
	car.car_number,
	expense.car_id,
	expense_details,
	total_amount,
	expense.note,
	(
		SELECT
			SUM(total_amount)
		FROM
			expense
		WHERE
			car_id=0 AND expense_date BETWEEN '$start_date'
		AND '$end_date'
	) AS totals
FROM
	expense
LEFT JOIN transport_factory AS fac ON (
	expense.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (expense.car_id = car.car_id)
WHERE
	expense.car_id=0 AND expense_date BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	factory_code,
	expense_date ASC ";


                } else {
                    #2
                    //$str_sql = "SELECT * FROM expense WHERE car_id=0 AND note='$remark' AND expense_date BETWEEN '$start_date' AND '$end_date' ";
                    $str_sql = "SELECT
	expense_date,
	factory_code,
	ref_number,
	car.car_number,
	expense.car_id,
	expense_details,
	total_amount,
	expense.note,
	(
		SELECT
			SUM(total_amount)
		FROM
			expense
		WHERE
			car_id=0 AND note='$remark' AND expense_date BETWEEN '$start_date'
		AND '$end_date'
	) AS totals
FROM
	expense
LEFT JOIN transport_factory AS fac ON (
	expense.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (expense.car_id = car.car_id)
WHERE
	expense.car_id=0 AND expense.note='$remark' AND expense_date BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	factory_code,
	expense_date ASC ";


                }


            } // End if

            if ($expenseType == "car") {

                if ($car_number == "All") {

                    if (isset($car_remark) && $car_remark == "All") {
                        #3
                        //$str_sql ="SELECT * FROM expense WHERE car_id!=0 AND expense_date BETWEEN '$start_date' AND '$end_date' ";
                        $str_sql = "SELECT
	expense_date,
	factory_code,
	ref_number,
	car.car_number,
	expense.car_id,
	expense_details,
	total_amount,
	expense.note,
	(
		SELECT
			SUM(total_amount)
		FROM
			expense
		WHERE
			car_id != 0
		AND expense_date BETWEEN '$start_date'
		AND '$end_date'
	) AS totals
FROM
	expense
LEFT JOIN transport_factory AS fac ON (
	expense.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (expense.car_id = car.car_id)
WHERE
	expense.car_id != 0
AND expense_date BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	factory_code,
	expense_date ASC ";


                    } else {
                        #4
                        //$str_sql = "SELECT * FROM expense WHERE car_id!=0 AND note ='$car_remark' AND expense_date BETWEEN '$start_date' AND '$end_date' ";
                        $str_sql = "SELECT
	expense_date,
	factory_code,
	ref_number,
	car.car_number,
	expense.car_id,
	expense_details,
	total_amount,
	expense.note,
	(
		SELECT
			SUM(total_amount)
		FROM
			expense
		WHERE
			car_id != 0
		AND note = '$car_remark'
		AND expense_date BETWEEN '$start_date'
		AND '$end_date'
	) AS totals
FROM
	expense
LEFT JOIN transport_factory AS fac ON (
	expense.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (expense.car_id = car.car_id)
WHERE
	expense.car_id != 0
AND expense.note = '$car_remark'
AND expense_date BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	factory_code,
	expense_date ASC ";

                    }

                } else {

                    if (isset($car_remark) && $car_remark == "All") {
                        #5
                        //$str_sql = "SELECT * FROM expense WHERE car_id=$car_number AND expense_date BETWEEN '$start_date' and '$end_date' ";
                        $str_sql = "SELECT
	expense_date,
	factory_code,
	ref_number,
	car.car_number,
	expense.car_id,
	expense_details,
	total_amount,
	expense.note,
	(
		SELECT
			SUM(total_amount)
		FROM
			expense
		WHERE
			car_id = $car_number
		AND expense_date BETWEEN '$start_date'
		AND '$end_date'
	) AS totals
FROM
	expense
LEFT JOIN transport_factory AS fac ON (
	expense.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (expense.car_id = car.car_id)
WHERE
	expense.car_id = $car_number
AND expense_date BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	factory_code,
	expense_date ASC";


                    } else {
                        #6
                        //$str_sql = "SELECT * FROM expense WHERE car_id=$car_number AND note='$car_remark' AND expense_date BETWEEN '$start_date' and '$end_date' ";
                        $str_sql = "SELECT
	expense_date,
	factory_code,
	ref_number,
	car.car_number,
	expense.car_id,
	expense_details,
	total_amount,
	expense.note,
	(
		SELECT
			SUM(total_amount)
		FROM
			expense
		WHERE
			car_id = $car_number
		AND note = '$car_remark'
		AND expense_date BETWEEN '$start_date'
		AND '$end_date'
	) AS totals
FROM
	expense
LEFT JOIN transport_factory AS fac ON (
	expense.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (expense.car_id = car.car_id)
WHERE
	expense.car_id = $car_number
AND expense.note = '$car_remark'
AND expense_date BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	factory_code,
	expense_date ASC ";
                    }

                }


            } //end if

            // $str_sql = "SELECT * FROM expense WHERE expense_date BETWEEN '$start_date' AND '$end_date'";
        } else {

            //Select Custom Factory generate Report

            if ($expenseType == "normal") {

                if ($remark == null || $remark == "All") {
                    #7
                    //$str_sql = "SELECT * FROM expense WHERE factory_id = $factory_id AND car_id=0 AND expense_date BETWEEN '$start_date' AND '$end_date' ";
                    $str_sql = "SELECT
	expense_date,
	factory_code,
	ref_number,
	car.car_number,
	expense.car_id,
	expense_details,
	total_amount,
	expense.note,
	(
		SELECT
			SUM(total_amount)
		FROM
			expense
		WHERE
			factory_id=$factory_id AND car_id=0 AND expense_date BETWEEN '$start_date'
		AND '$end_date'
	) AS totals
FROM
	expense
LEFT JOIN transport_factory AS fac ON (
	expense.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (expense.car_id = car.car_id)
WHERE
	fac.factory_id =$factory_id AND expense.car_id=0 AND expense_date BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	factory_code,
	expense_date ASC ";


                } else {
                    #8
                    //$str_sql = "SELECT * FROM expense WHERE factory_id = $factory_id AND car_id=0 AND note='$remark' AND expense_date BETWEEN '$start_date' AND '$end_date'";
                    $str_sql = "SELECT
	expense_date,
	factory_code,
	ref_number,
	car.car_number,
	expense.car_id,
	expense_details,
	total_amount,
	expense.note,
	(
		SELECT
			SUM(total_amount)
		FROM
			expense
		WHERE
			factory_id=$factory_id AND car_id=0 AND note='$remark' AND expense_date BETWEEN '$start_date'
		AND '$end_date'
	) AS totals
FROM
	expense
LEFT JOIN transport_factory AS fac ON (
	expense.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (expense.car_id = car.car_id)
WHERE
	fac.factory_id =$factory_id AND expense.car_id=0 AND expense.note='$remark' AND expense_date BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	factory_code,
	expense_date ASC ";


                }


            } // End if

            if ($expenseType == "car") {

                if ($car_number == "All") {

                    if (isset($car_remark) && $car_remark == "All") {
                        #9
                        //$str_sql = "SELECT * FROM expense WHERE factory_id=$factory_id AND car_id!=0 AND expense_date BETWEEN '$start_date' AND '$end_date' ";
                        $str_sql = "SELECT
	expense_date,
	factory_code,
	ref_number,
	car.car_number,
	expense.car_id,
	expense_details,
	total_amount,
	expense.note,
	(
		SELECT
			SUM(total_amount)
		FROM
			expense
		WHERE
			factory_id = $factory_id
		AND car_id != 0
		AND expense_date BETWEEN '$start_date'
		AND '$end_date'
	) AS totals
FROM
	expense
LEFT JOIN transport_factory AS fac ON (
	expense.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (expense.car_id = car.car_id)
WHERE
	fac.factory_id = $factory_id
AND expense.car_id != 0
AND expense_date BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	factory_code,
	expense_date ASC ";


                    } else {
                        #10
                        //$str_sql = "SELECT * FROM expense WHERE factory_id=$factory_id AND car_id!=0 AND note='$car_remark' AND expense_date BETWEEN '$start_date' AND '$end_date' ";
                        $str_sql = "SELECT
	expense_date,
	factory_code,
	ref_number,
	car.car_number,
	expense.car_id,
	expense_details,
	total_amount,
	expense.note,
	(
		SELECT
			SUM(total_amount)
		FROM
			expense
		WHERE
			factory_id = $factory_id
		AND car_id != 0
		AND note = '$car_remark'
		AND expense_date BETWEEN '$start_date'
		AND '$end_date'
	) AS totals
FROM
	expense
LEFT JOIN transport_factory AS fac ON (
	expense.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (expense.car_id = car.car_id)
WHERE
	fac.factory_id = $factory_id
AND expense.car_id != 0
AND expense.note = '$car_remark'
AND expense_date BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	factory_code,
	expense_date ASC ";
                    }
                } else {

                    if (isset($car_remark) && $car_remark == "All") {
                        #11
                        //$str_sql = "SELECT * FROM expense WHERE factory_id =$factory_id AND car_id=$car_number AND expense_date BETWEEN '$start_date' and '$end_date'";
                        $str_sql = "SELECT
	expense_date,
	factory_code,
	ref_number,
	car.car_number,
	expense.car_id,
	expense_details,
	total_amount,
	expense.note,
	(
		SELECT
			SUM(total_amount)
		FROM
			expense
		WHERE
			factory_id = $factory_id
		AND car_id = $car_number
		AND expense_date BETWEEN '$start_date'
		AND '$end_date'
	) AS totals
FROM
	expense
LEFT JOIN transport_factory AS fac ON (
	expense.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (expense.car_id = car.car_id)
WHERE
	fac.factory_id = $factory_id
AND expense.car_id = $car_number
AND expense_date BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	factory_code,
	expense_date ASC ";


                    } else {
                        #12
                        //$str_sql = "SELECT * FROM expense WHERE factory_id =$factory_id AND car_id=$car_number AND note='$car_remark' AND expense_date BETWEEN '$start_date' and '$end_date'";
                        $str_sql = "SELECT
	expense_date,
	factory_code,
	ref_number,
	car.car_number,
	expense.car_id,
	expense_details,
	total_amount,
	expense.note,
	(
		SELECT
			SUM(total_amount)
		FROM
			expense
		WHERE
			factory_id = $factory_id
		AND car_id = $car_number
		AND note = '$car_remark'
		AND expense_date BETWEEN '$start_date'
		AND '$end_date'
	) AS totals
FROM
	expense
LEFT JOIN transport_factory AS fac ON (
	expense.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (expense.car_id = car.car_id)
WHERE
	fac.factory_id = $factory_id
AND expense.car_id = $car_number
AND expense.note = '$car_remark'
AND expense_date BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	factory_code,
	expense_date ASC ";

                    }


                }


            } //end if


        } // End if


        $query = $this->db->query($str_sql);

        if ($query->num_rows() > 0) {

            return $query->result_array();


        } // end if


    } // End of function


    public function check_oil_receive_sell_number($factory = "All", $oilType, $car_id,
        $customer_id, $start_date = '0000-00-00', $end_date = '0000-00-00', $method =
        "check")
    {

        if ($factory == "All") {
            if ($oilType == "receive") {

                if ($car_id == "All") {
                    if ($customer_id == "All") {
                        #1
                        //$str = "SELECT * FROM oilstock WHERE stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type =1";
                        /**Old **/
                        /*
                        $str = "SELECT
                        stock_id,
                        stock_date,
                        ref_number,
                        stock_details,
                        receive_oil,
                        receive_price,
                        receive_amount,
                        factory_code,
                        factory_name,
                        cus.customers_name,
                        o_s.customer_id,
                        o_s.note,
                        car_number,
                        oil_type
                        FROM
                        oilstock AS o_s
                        LEFT JOIN transport_factory AS fac ON (
                        o_s.factory_id = fac.factory_id
                        )
                        LEFT JOIN transport_customers AS cus ON (
                        o_s.customer_id = cus.customer_id
                        )
                        LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
                        WHERE
                        stock_date BETWEEN '$start_date'
                        AND '$end_date'
                        AND oil_type = 1";
                        */
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
	factory_code,
	factory_name,
	cus.customer_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_oilcustomers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_oilcars AS car ON (o_s.car_id = car.car_id)
WHERE
	stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 1";


                    } else {
                        //Select Customer_id custom
                        #2
                        //$str = "SELECT * FROM oilstock WHERE customer_id=$customer_id AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type =1";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.customer_id = $customer_id
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 1";

                    } // end if $customer_id

                } else {
                    // select car_id custom
                    if ($customer_id == "All") {
                        #3
                        //$str = "SELECT * FROM oilstock WHERE car_id =$car_id AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type=1";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.car_id = $car_id
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 1";

                    } else {
                        #4
                        //$str ="SELECT * FROM oilstock WHERE car_id =$car_id AND customer_id=$customer_id AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type=1";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.car_id = $car_id
AND o_s.customer_id = $customer_id
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 1";


                    } // end if $customer_id

                } // End if $car_id


            } else {
                //oilType pay

                if ($car_id == "All") {
                    if ($customer_id == "All") {
                        #1
                        //$str = "SELECT * FROM oilstock WHERE stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type =2";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
    sell_oil,
	sell_price,
	sell_amount,	
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 2";


                    } else {
                        //Select Customer_id custom
                        #2
                        //$str = "SELECT * FROM oilstock WHERE customer_id=$customer_id AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type =2";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
    sell_oil,
	sell_price,
	sell_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.customer_id = '$customer_id'
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 2";

                    } // end if $customer_id

                } else {
                    // select car_id custom
                    if ($customer_id == "All") {
                        #3
                        //$str = "SELECT * FROM oilstock WHERE car_id =$car_id AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type=2";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
    sell_oil,
	sell_price,
	sell_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.car_id = '$car_id'
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 2";


                    } else {
                        #4
                        //$str ="SELECT * FROM oilstock WHERE car_id =$car_id AND customer_id=$customer_id AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type=2";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
    sell_oil,
	sell_price,
	sell_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.car_id = '$car_id'
AND o_s.customer_id = '$customer_id'
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 2";
                    } // end if $customer_id

                } // End if $car_id


            } // end if oilType

        } else {
            // Select factory custom

            if ($oilType == "receive") {

                if ($car_id == "All") {
                    if ($customer_id == "All") {
                        #1
                        //$str = "SELECT * FROM oilstock WHERE factory_id=$factory AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type =1";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.factory_id = '$factory'
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 1";
                    } else {
                        //Select Customer_id custom
                        #2
                        //$str = "SELECT * FROM oilstock WHERE factory_id=$factory AND customer_id=$customer_id AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type =1";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.factory_id = '$factory'
AND o_s.customer_id = '$customer_id'
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 1";

                    } // end if $customer_id

                } else {
                    // select car_id custom
                    if ($customer_id == "All") {
                        #3
                        //$str = "SELECT * FROM oilstock WHERE factory_id=$factory AND car_id =$car_id AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type=1";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.factory_id = '$factory'
AND o_s.car_id = '$car_id'
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 1";

                    } else {
                        #4
                        //$str ="SELECT * FROM oilstock WHERE factory_id=$factory AND car_id =$car_id AND customer_id=$customer_id AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type=1";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.factory_id = '$factory'
AND o_s.car_id = '$car_id'
AND o_s.customer_id = '$customer_id'
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 1";

                    } // end if $customer_id

                } // End if $car_id


            } else {
                //oilType pay

                if ($car_id == "All") {
                    if ($customer_id == "All") {
                        #1
                        //$str = "SELECT * FROM oilstock WHERE factory_id=$factory AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type =2";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
    sell_oil,
	sell_price,
	sell_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.factory_id = '$factory'
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 2";


                    } else {
                        //Select Customer_id custom
                        #2
                        //$str = "SELECT * FROM oilstock WHERE factory_id=$factory AND customer_id=$customer_id AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type =2";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
    sell_oil,
	sell_price,
	sell_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.factory_id = '$factory'
AND o_s.customer_id = '$customer_id'
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 2";

                    } // end if $customer_id

                } else {
                    // select car_id custom
                    if ($customer_id == "All") {
                        #3
                        //$str = "SELECT * FROM oilstock WHERE factory_id=$factory AND car_id =$car_id AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type=2";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
    sell_oil,
	sell_price,
	sell_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.factory_id = '$factory'
AND o_s.car_id = '$car_id'
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 2";


                    } else {
                        #4
                        //$str ="SELECT * FROM oilstock WHERE factory_id=$factory AND car_id =$car_id AND customer_id=$customer_id AND stock_date BETWEEN '$start_date' AND '$end_date' AND oil_type=2";
                        $str = "SELECT
	stock_id,
	stock_date,
	ref_number,
	stock_details,
	receive_oil,
	receive_price,
	receive_amount,
    sell_oil,
	sell_price,
	sell_amount,
	factory_code,
	factory_name,
	cus.customers_name,
	o_s.customer_id,
	o_s.note,
	car_number,
	oil_type
FROM
	oilstock AS o_s
LEFT JOIN transport_factory AS fac ON (
	o_s.factory_id = fac.factory_id
)
LEFT JOIN transport_customers AS cus ON (
	o_s.customer_id = cus.customer_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
WHERE
	o_s.factory_id = '$factory'
AND o_s.car_id = '$car_id'
AND o_s.customer_id = '$customer_id'
AND stock_date BETWEEN '$start_date'
AND '$end_date'
AND oil_type = 2";


                    } // end if $customer_id

                } // End if $car_id


            } // end if oilType


        }


        $query = $this->db->query($str);
        $num_report = $query->num_rows();


        if ($method == "check") {
            if ($num_report == 0 || $num_report == "" || $num_report == null) {
                $num_report = 0;

                return $num_report;
            } else {
                return $num_report;
            }

        } else {
            //$method ="report"

            if ($num_report == 0 || $num_report == "" || $num_report == null) {
                $report = 0;

                return $report;
            } else {

                return $query->result_array();
            }


        }


    } // End of function check_oil_receive_sell_number


    /* Oil */
    public function check_oilreport($month, $year, $oil_type, $factory = "All")
    {

        if ($factory == "All") {

            if ($oil_type == "1") {
                // รับน้ำมัน
                $str_sql = "SELECT * FROM oilstock WHERE YEAR(stock_date) ='$year' AND MONTH(stock_date)='$month' AND oil_type=1 ";
            } elseif ($oil_type == '2') {
                //จ่ายน้ำมัน
                $str_sql = "SELECT * FROM oilstock WHERE YEAR(stock_date) ='$year' AND MONTH(stock_date)='$month' AND oil_type=2 ";
            } else {
                $str_sql = "SELECT * FROM oilstock WHERE YEAR(stock_date) ='$year' AND MONTH(stock_date)='$month'";
            }

        } else {

            if ($oil_type == "1") {
                // รับน้ำมัน
                $str_sql = "SELECT * FROM oilstock WHERE factory_id=$factory AND YEAR(stock_date) ='$year' AND MONTH(stock_date)='$month' AND oil_type=1 ";
            } elseif ($oil_type == '2') {
                //จ่ายน้ำมัน
                $str_sql = "SELECT * FROM oilstock WHERE factory_id=$factory AND YEAR(stock_date) ='$year' AND MONTH(stock_date)='$month' AND oil_type=2 ";
            } else {
                $str_sql = "SELECT * FROM oilstock WHERE factory_id=$factory AND YEAR(stock_date) ='$year' AND MONTH(stock_date)='$month'";
            }

        }


        $query = $this->db->query($str_sql);

        $num_report = $query->num_rows();

        if ($num_report == 0 || $num_report == "" || $num_report == null) {
            $num_report = 0;

            return $num_report;
        } else {
            return $num_report;
        }

        //return

    } // End of function check_oilreport

    public function oilstock_report($month, $year, $factory = "All")
    {

        if ($factory == "All") {
            $str_sql = "SELECT
	stock_date,
	ref_number,
	stock_details,
	factory_code,
	receive_oil,
	receive_price,
	receive_amount,
	sell_oil,
	sell_price,
	sell_amount,
	car_number,
	(
		SELECT
			SUM(receive_oil)
		FROM
			oilstock
	) AS all_receiveOil,
	(
		SELECT
			SUM(receive_amount)
		FROM
			oilstock
	) AS all_receiveAmount,
	(
		SELECT
			SUM(sell_oil)
		FROM
			oilstock
	) AS all_sellOil,
	(
		SELECT
			SUM(sell_amount)
		FROM
			oilstock
	) AS all_sellAmount,
	(
		SELECT
			SUM(receive_oil)
		FROM
			oilstock
		WHERE
			YEAR (stock_date) = '$year'
		AND MONTH (stock_date) = '$month'
	) AS total_reciveoil,
	(
		SELECT
			SUM(receive_amount)
		FROM
			oilstock
		WHERE
			YEAR (stock_date) = '$year'
		AND MONTH (stock_date) = '$month'
	) AS total_reciveAmount,
	(
		SELECT
			SUM(sell_oil)
		FROM
			oilstock
		WHERE
			YEAR (stock_date) = '$year'
		AND MONTH (stock_date) = '$month'
	) AS total_selloil,
	(
		SELECT
			SUM(sell_amount)
		FROM
			oilstock
		WHERE
			YEAR (stock_date) = '$year'
		AND MONTH (stock_date) = '$month'
	) AS total_sellamount,
	oil_type
FROM
	oilstock AS oil_st
LEFT JOIN transport_factory AS fac ON (
	oil_st.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (oil_st.car_id = car.car_id)
WHERE
	YEAR (stock_date) = '$year'
AND MONTH (stock_date) = '$month'
ORDER BY
	stock_date ASC";

        } else {
            //Select factory
            $str_sql = "SELECT
	stock_date,
	ref_number,
	stock_details,
	factory_code,
	receive_oil,
	receive_price,
	receive_amount,
	sell_oil,
	sell_price,
	sell_amount,
	car_number,
	(
		SELECT
			SUM(receive_oil)
		FROM
			oilstock
WHERE factory_id =$factory
	) AS all_receiveOil,
	(
		SELECT
			SUM(receive_amount)
		FROM
			oilstock
WHERE factory_id =$factory
	) AS all_receiveAmount,
	(
		SELECT
			SUM(sell_oil)
		FROM
			oilstock
WHERE factory_id =$factory
	) AS all_sellOil,
	(
		SELECT
			SUM(sell_amount)
		FROM
			oilstock
WHERE factory_id =$factory
	) AS all_sellAmount,
	(
		SELECT
			SUM(receive_oil)
		FROM
			oilstock
		WHERE
			YEAR (stock_date) = '$year'
		AND MONTH (stock_date) = '$month'
AND factory_id = $factory
	) AS total_reciveoil,
	(
		SELECT
			SUM(receive_amount)
		FROM
			oilstock
		WHERE
			YEAR (stock_date) = '$year'
		AND MONTH (stock_date) = '$month'
AND factory_id = $factory
	) AS total_reciveAmount,
	(
		SELECT
			SUM(sell_oil)
		FROM
			oilstock
		WHERE
			YEAR (stock_date) = '$year'
		AND MONTH (stock_date) = '$month'
AND factory_id = $factory
	) AS total_selloil,
	(
		SELECT
			SUM(sell_amount)
		FROM
			oilstock
		WHERE
			YEAR (stock_date) = '$year'
		AND MONTH (stock_date) = '$month'
AND factory_id = $factory
	) AS total_sellamount,
	oil_type
FROM
	oilstock AS oil_st
LEFT JOIN transport_factory AS fac ON (
	oil_st.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (oil_st.car_id = car.car_id)
WHERE
	YEAR (stock_date) = '$year'
AND MONTH (stock_date) = '$month'
AND oil_st.factory_id =$factory
ORDER BY
	stock_date ASC";

        }


        $result = $this->db->query($str_sql);

        $check_num = $result->num_rows();

        if ($check_num > 0) {

            return $result->result_array();
        }

    } // end of oilstock_report


    public function check_order_report($factory_id = 'All', $car_id = 'All', $start_date =
        '0000-00-00', $end_date = '0000-00-00', $method = "report")
    {

        if ($factory_id == "All") {
            if ($car_id == "All") {
                $str_sql = "SELECT
	o_d.id,
	order_date,
	dp_number,
	factory_name,
	factory_code,
	dis_t.distance_code,
	cubic_value,
	car.car_number,
	customers_name,
    driver_name,
	real_distance,
	o_d.use_oil,
	o_d.remark
FROM
	orders AS o_d
LEFT JOIN transport_factory AS fac ON (
	o_d.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (o_d.car_id = car.car_id)
LEFT JOIN transport_customers AS cus_t ON (
	o_d.customer_id = cus_t.customer_id
)
LEFT JOIN distancecode AS dis_t ON (
	o_d.distance_id = dis_t.distance_id
)
LEFT JOIN transport_cubiccode AS cubic ON (
	o_d.cubic_id = cubic.cubic_id
)
LEFT JOIN driver AS driver ON(o_d.driver_id=driver.driver_id)
WHERE DATE(order_date) BETWEEN '$start_date' AND '$end_date' ORDER BY order_date,dp_number ASC";
            } else {
                /*Custom car_id*/
                $str_sql = "SELECT
	o_d.id,
	order_date,
	dp_number,
	factory_name,
	factory_code,
	dis_t.distance_code,
	cubic_value,
	car.car_number,
	customers_name,
    driver_name,
	real_distance,
	o_d.use_oil,
	o_d.remark
FROM
	orders AS o_d
LEFT JOIN transport_factory AS fac ON (
	o_d.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (o_d.car_id = car.car_id)
LEFT JOIN transport_customers AS cus_t ON (
	o_d.customer_id = cus_t.customer_id
)
LEFT JOIN distancecode AS dis_t ON (
	o_d.distance_id = dis_t.distance_id
)
LEFT JOIN transport_cubiccode AS cubic ON (
	o_d.cubic_id = cubic.cubic_id
)
LEFT JOIN driver AS driver ON(o_d.driver_id=driver.driver_id)
WHERE
	o_d.car_id = $car_id
AND DATE(order_date) BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	order_date,
	dp_number ASC";
            }
        } else {
            /*Custom Factory_id*/
            if ($car_id == "All") {
                $str_sql = "SELECT
	o_d.id,
	order_date,
	dp_number,
	factory_name,
	factory_code,
	dis_t.distance_code,
	cubic_value,
	car.car_number,
	customers_name,
    driver_name,
	real_distance,
	o_d.use_oil,
	o_d.remark
FROM
	orders AS o_d
LEFT JOIN transport_factory AS fac ON (
	o_d.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (o_d.car_id = car.car_id)
LEFT JOIN transport_customers AS cus_t ON (
	o_d.customer_id = cus_t.customer_id
)
LEFT JOIN distancecode AS dis_t ON (
	o_d.distance_id = dis_t.distance_id
)
LEFT JOIN transport_cubiccode AS cubic ON (
	o_d.cubic_id = cubic.cubic_id
)
LEFT JOIN driver AS driver ON(o_d.driver_id=driver.driver_id)
WHERE
	o_d.factory_id = $factory_id
AND DATE(order_date) BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	order_date,
	dp_number ASC";
            } else {
                /*Custom car_id*/
                $str_sql = "SELECT
	o_d.id,
	order_date,
	dp_number,
	factory_name,
	factory_code,
	dis_t.distance_code,
	cubic_value,
	car.car_number,
	customers_name,
    driver_name,
	real_distance,
	o_d.use_oil,
	o_d.remark
FROM
	orders AS o_d
LEFT JOIN transport_factory AS fac ON (
	o_d.factory_id = fac.factory_id
)
LEFT JOIN transport_cars AS car ON (o_d.car_id = car.car_id)
LEFT JOIN transport_customers AS cus_t ON (
	o_d.customer_id = cus_t.customer_id
)
LEFT JOIN distancecode AS dis_t ON (
	o_d.distance_id = dis_t.distance_id
)
LEFT JOIN transport_cubiccode AS cubic ON (
	o_d.cubic_id = cubic.cubic_id
)
LEFT JOIN driver AS driver ON(o_d.driver_id=driver.driver_id)
WHERE
	o_d.factory_id = $factory_id
AND o_d.car_id =$car_id
AND DATE(order_date) BETWEEN '$start_date'
AND '$end_date'
ORDER BY
	order_date,
	dp_number ASC";

            }

        } // End if


        $query = $this->db->query($str_sql);
        $num_report = $query->num_rows();

        if ($method == "check") {
            if ($num_report == 0 || $num_report == "" || $num_report == null) {
                $num_report = 0;

                return $num_report;
            } else {
                return $num_report;
            }

        } else {
            //$method ="report"

            return $query->result_array();

        }


    } // End of function check_order_report

    public function report_taxs($month = '01', $year = '0000', $tax_type = 'taxsell',
        $method = 'report')
    {

        if ($tax_type == 'taxsell') {
            $str_sql = "SELECT
	id as tax_id,
	tax_date,
	ref_number,
	tax_details,
	total_price,
	total_vat,
	total_amount,
	note
FROM
	`taxsell`
WHERE
MONTH (tax_date) = '$month'	
AND  YEAR (tax_date) = '$year' ";
        } elseif ($tax_type == "taxbuy") {
            $str_sql = "SELECT
	tax_id as tax_id,
	tax_date,
	ref_number,
	tax_details,
	total_price,
	total_vat,
	total_amount,
	note
FROM
	`taxbuy`
WHERE
MONTH (tax_date) = '$month'	
AND  YEAR (tax_date) = '$year' ";
        }


        $query = $this->db->query($str_sql);
        $num_report = $query->num_rows();

        if ($method == "check") {
            if ($num_report == 0 || $num_report == "" || $num_report == null) {
                $num_report = 0;

                return $num_report;
            } else {
                return $num_report;
            }

        } else {
            //$method ="report"

            return $query->result_array();

        }


    } //report_taxsell


    // Summary Order By Month

    public function orders_summary_by_month_report($factory_id = "All", $month =
        "01", $year = "0000", $method = "report")
    {


        if ($factory_id == "All") {

            $str = "SELECT
	DAY (order_date) AS inday,
	DATE(order_date) AS order_date,
	COUNT(*) AS count_order,
	SUM(price) AS sum_price
FROM
	orders AS o_s
LEFT JOIN transport_cubiccode AS cubic ON (
	o_s.cubic_id = cubic.cubic_id
)
LEFT JOIN distancecode AS dis ON (
	o_s.distance_id = dis.distance_id
)
INNER JOIN transport_factory USING (factory_id)
WHERE
	MONTH (order_date) = '$month'
AND YEAR (order_date) = '$year'
GROUP BY
	DATE(order_date)
ORDER BY
	DATE(order_date) ASC";
        } else {
            //Select Custom factory

            $str = "SELECT
	DAY (order_date) AS inday,
	DATE(order_date) AS order_date,
	o_s.factory_id,
	factory_code,
	SUM(price) AS sum_price
FROM
	orders AS o_s
LEFT JOIN transport_cubiccode AS cubic ON (
	o_s.cubic_id = cubic.cubic_id
)
LEFT JOIN distancecode AS dis ON (
	o_s.distance_id = dis.distance_id
)
INNER JOIN transport_factory USING (factory_id)
WHERE
	MONTH (order_date) = '$month'
AND YEAR (order_date) = '$year'
AND o_s.factory_id = '$factory_id'
GROUP BY
	DATE(order_date)
ORDER BY
	DATE(order_date) ASC";

        } //end if


        $query = $this->db->query($str);
        $num_report = $query->num_rows();


        if ($method == "check") {
            if ($num_report == 0 || $num_report == "" || $num_report == null) {
                $num_report = 0;

                return $num_report;
            } else {
                return $num_report;
            }

        } else {
            //$method ="report"

            if ($num_report == 0 || $num_report == "" || $num_report == null) {
                $report = 0;

                return $report;
            } else {

                return $query->result_array();
            }


        }


    }


    // End
    // Orders by month Report
    public function orders_by_month_report($factory_id = "All", $car_id = null, $month =
        "01", $year = "0000", $method = "report")
    {


        if ($factory_id == "All") {


            if (isset($car_id) && $car_id == "All" || $car_id == null) {
                $str = "SELECT
	DAY (order_date) AS inday,
	DATE(order_date) AS order_date,
    factory_code,
	factory_name,
	o_s.distance_id,
	cubic.cubic_id,
	distance_code,
	cubic_value,
	COUNT(*) AS count_order,
	SUM(cubic_value) AS sum_cubic,
	price,
	SUM(price) AS sum_price
FROM
	orders AS o_s
LEFT JOIN transport_cubiccode AS cubic ON(o_s.cubic_id=cubic.cubic_id)
LEFT JOIN distancecode AS dis ON (o_s.distance_id=dis.distance_id)
INNER JOIN transport_factory USING (factory_id)
WHERE MONTH(order_date)='$month' AND YEAR(order_date)='$year'
GROUP BY o_s.cubic_id,o_s.distance_id
ORDER BY DATE(order_date),cubic_id,distance_id ASC";
            } else {

                $str = "SELECT
	DAY (order_date) AS inday,
	DATE(order_date) AS order_date,
	factory_code,
	factory_name,
	car.car_id,
	car.car_number,
	o_s.distance_id,
	cubic.cubic_id,
	distance_code,
	cubic_value,
	COUNT(*) AS count_order,
	SUM(cubic_value) AS sum_cubic,
	price,
	SUM(price) AS sum_price
FROM
	orders AS o_s
LEFT JOIN transport_cubiccode AS cubic ON (
	o_s.cubic_id = cubic.cubic_id
)
LEFT JOIN distancecode AS dis ON (
	o_s.distance_id = dis.distance_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
INNER JOIN transport_factory USING (factory_id)
WHERE
	MONTH (order_date) = '$month'
AND YEAR (order_date) = '$year'
AND o_s.car_id = '$car_id'
GROUP BY
	o_s.cubic_id,
	o_s.distance_id
ORDER BY
	DATE(order_date),
	cubic_id,
	distance_id ASC";

            } //End sub if


        } else {
            //Select Custom factory

            // Car_id all
            if (isset($car_id) && $car_id == "All" || $car_id == null) {
                $str = "SELECT
	DAY (order_date) AS inday,
	DATE(order_date) AS order_date,
	o_s.distance_id,
	o_s.factory_id,
	factory_code,
	cubic.cubic_id,
	distance_code,
	cubic_value,
	COUNT(*) AS count_order,
	SUM(cubic_value) AS sum_cubic,
	price,
	SUM(price) AS sum_price
FROM
	orders AS o_s
LEFT JOIN transport_cubiccode AS cubic ON(o_s.cubic_id=cubic.cubic_id)
LEFT JOIN distancecode AS dis ON (o_s.distance_id=dis.distance_id)
INNER JOIN transport_factory USING (factory_id)
WHERE MONTH(order_date)='$month' AND YEAR(order_date)='$year' AND o_s.factory_id = '$factory_id'
GROUP BY o_s.cubic_id,o_s.distance_id
ORDER BY DATE(order_date),cubic_id,distance_id ASC";

            } else {
                $str = "SELECT
	DAY (order_date) AS inday,
	DATE(order_date) AS order_date,
	o_s.factory_id,
	factory_code,
	o_s.car_id,
	car.car_number,
	cubic.cubic_id,
	o_s.distance_id,
	distance_code,
	cubic_value,
	COUNT(*) AS count_order,
	SUM(cubic_value) AS sum_cubic,
	price,
	SUM(price) AS sum_price
FROM
	orders AS o_s
LEFT JOIN transport_cubiccode AS cubic ON (
	o_s.cubic_id = cubic.cubic_id
)
LEFT JOIN distancecode AS dis ON (
	o_s.distance_id = dis.distance_id
)
LEFT JOIN transport_cars AS car ON (o_s.car_id = car.car_id)
INNER JOIN transport_factory USING (factory_id)
WHERE
	MONTH (order_date) = '$month'
AND YEAR (order_date) = '$year'
AND o_s.factory_id = '$factory_id'
AND o_s.car_id = '$car_id'
GROUP BY
	o_s.cubic_id,
	o_s.distance_id
ORDER BY
	DATE(order_date),
	cubic_id,
	distance_id ASC";


            }


        } //end if


        $query = $this->db->query($str);
        $num_report = $query->num_rows();


        if ($method == "check") {
            if ($num_report == 0 || $num_report == "" || $num_report == null) {
                $num_report = 0;

                return $num_report;
            } else {
                return $num_report;
            }

        } else {
            //$method ="report"

            if ($num_report == 0 || $num_report == "" || $num_report == null) {
                $report = 0;

                return $report;
            } else {

                return $query->result_array();
            }


        }


    } // End of function orders_by_month_report


} // End Class






?>