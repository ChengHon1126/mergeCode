<?php
require_once(dirname(dirname(dirname(__FILE__))) . "/include/admin_mainfile.php");
class bn_notice
{

	public function __construct() {}

	public function __destruct() {}

	/********出貨單********/
	function search_cargo2($id = 0, $table)
	{
		$sql = "SELECT * FROM $table WHERE cargo_id != $id ";
		$result = $GLOBALS['DB']->get_query_result($sql, false);
		return array($result);
	}
	function search_icb($id = 0, $table)
	{
		$sql = "SELECT * FROM $table WHERE cargo_id = $id and d_date = '0000-00-00 00:00:00'";
		$result = $GLOBALS['DB']->get_query_result($sql, false);
		return array($result);
	}
	function search_store($cargo_code)
	{
		$sql = "SELECT * FROM cargo_store WHERE cargo_code = '$cargo_code' AND store_status = 1 ";
		return $GLOBALS['DB']->get_query_result($sql, false);
	}

	function search_store_info($store_id)
	{
		$sql = "SELECT * FROM cargo_store WHERE cargo_store_id = '$store_id' AND store_status = 1 ";
		return $GLOBALS['DB']->get_query_result($sql, true);
	}

	function notice_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND to_eod = 0 ";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = $data["bn_mode"];
		$clause .= " AND bn_mode = $bn_mode ";

		if (!empty($data["cargo_code"])) {
			$cargo_code = trim($data["cargo_code"]);
			$clause .= " AND cargo_code LIKE '$cargo_code%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($GLOBALS["lc_code"])) {
			$lc_code = trim($GLOBALS["lc_code"]);
			$clause .= " AND lc_code = '$lc_code' ";
		}

		$sql = "SELECT * FROM bn_master $clause ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function notice_list22($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 ";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = $data["bn_mode"];
		$clause .= " AND bn_mode = $bn_mode ";

		$cargo_code = trim($data["cargo_code"]);
		if (!empty($cargo_code)) {
			$clause .= " AND cargo_code LIKE '$cargo_code%' ";
		}

		$bn_no = trim($data["bn_no"]);
		if (!empty($bn_no)) {
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}

		$receiver_name = trim($data["receiver_name"]);
		if (!empty($receiver_name)) {
			$clause .= " AND bn_receiver_name LIKE '%$receiver_name%' ";
		}

		$deliver_name = trim($data["deliver_name"]);
		if (!empty($deliver_name)) {
			$clause .= " AND bn_deliver_name LIKE '%$deliver_name%' ";
		}

		$lc_code = trim($GLOBALS["lc_code"]);
		if (!empty($lc_code)) {
			$clause .= " AND lc_code = '$lc_code' ";
		}

		$sql = "SELECT * FROM bn_master $clause and to_eod_date >= 1659002400 ORDER BY createdate DESC LIMIT $start, $num_per_page";
		echo $sql;
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master $clause and to_eod_date >= 1659002400 ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}
	function bn_edi_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND a.to_eod = 1";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = @$data["bn_mode"];
		if ($bn_mode >= 0) {
			$clause .= " AND a.bn_mode = $bn_mode ";
		}

		if (!empty($data["cargo_code"])) {
			$cargo_code = trim($data["cargo_code"]);
			$clause .= " AND a.cargo_code LIKE '$cargo_code%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["receiver_addr"])) {
			$receiver_addr = trim($data["receiver_addr"]);
			$clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
		}


		if (!empty($data["receiver_phone"])) {
			$receiver_phone = trim($data["receiver_phone"]);
			$clause .= " AND a.bn_receiver_phone LIKE '%$receiver_phone%' ";
		}
		if (!empty($data["receiver_phone2"])) {
			$receiver_phone2 = trim($data["receiver_phone2"]);
			$clause .= " AND a.bn_receiver_phone2 LIKE '%$receiver_phone2%' ";
		}

		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($data["deliver_addr"])) {
			$deliver_addr = trim($data["deliver_addr"]);
			$clause .= " AND a.bn_deliver_addr LIKE '%$deliver_addr%' ";
		}


		if (!empty($data["deliver_phone"])) {
			$deliver_phone = trim($data["deliver_phone"]);
			$clause .= " AND a.bn_deliver_phone LIKE '%$deliver_phone%' ";
		}
		if (!empty($data["deliver_phone2"])) {
			$deliver_phone2 = trim($data["deliver_phone2"]);
			$clause .= " AND a.bn_deliver_phone2 LIKE '%$deliver_phone2%' ";
		}

		if (!empty($data["bn_type"])) {
			$bn_type = (int)$data["bn_type"];
			if ($bn_type > 0) {
				if ($bn_type == 9) {
					$clause .= " AND a.self_carr = 'Y' ";
				} else if ($bn_type == 99) {
					$clause .= " AND a.momo_backapi_status = 2 ";
				} else {
					$clause .= " AND a.bn_type = $bn_type ";
				}
			}
		}


		if (!empty($GLOBALS["lc_code"])) {
			$lc_code = trim($GLOBALS["lc_code"]);
			$clause .= " AND a.lc_code = '$lc_code' ";
		}

		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND a.to_eod_date >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND a.to_eod_date <= $date_end ";
		}

		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			$clause .= " AND a.deliver_setup = $deliver_setup ";
		}


		if (!empty($data["status_code"])) {
			$status_code = trim($data["status_code"]);
			$clause .= " AND a.bn_status_code = '$status_code' ";
		}
		if (!empty($data["print_status"])) {
			$print_status = $data["print_status"];
			if ($print_status == 1) {
				$clause .= " AND a.bn_print = 0 ";
			} elseif ($print_status == 2) {
				$clause .= " AND a.bn_print = 1 ";
			}
		}

		$sql = "SELECT a.*,b.bn_type AS now_bn_type FROM bn_master AS a LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id $clause ORDER BY a.to_eod_date DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master AS a LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function bn_eod_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1";
		$clause2 = "WHERE to_eod = 1 ";
		$start   = ($page - 1) * $num_per_page;


		if (!empty($data["cargo_code"])) {
			$cargo_code = trim($data["cargo_code"]);
			// $clause .= " AND a.cargo_code LIKE '$cargo_code%' ";
			$clause2 .= " AND cargo_code LIKE '$cargo_code%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
			$clause2 .= " AND bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
			$clause2 .= " AND bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["receiver_addr"])) {
			$receiver_addr = trim($data["receiver_addr"]);
			$clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
			$clause2 .= " AND bn_receiver_addr LIKE '%$receiver_addr%' ";
		}


		if (!empty($data["receiver_phone"])) {
			$receiver_phone = trim($data["receiver_phone"]);
			// $clause .= " AND a.bn_receiver_phone LIKE '%$receiver_phone%'";
			$clause .= " AND (a.bn_receiver_phone LIKE '%$receiver_phone%' or a.bn_receiver_phone2 LIKE '%$receiver_phone%' ) ";
			// $clause2 .= " AND bn_receiver_phone LIKE '%$receiver_phone%' ";
			// $clause2 .= " AND (a.bn_receiver_phone LIKE '%$receiver_phone%' or a.bn_receiver_phone2 LIKE '%$receiver_phone%' ) ";

		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
			$clause2 .= " AND bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($GLOBALS["lc_id"]) && empty($_GET["status"])) {
			$lc_id = trim($GLOBALS["lc_id"]);
			$clause .= " AND b.lc_id = '$lc_id' ";
			// $clause2 .= " AND lc_id = '$lc_id' ";
		}
		if (!empty($data["bn_type"])) {
			$bn_type = (int)$data["bn_type"];
			if ($bn_type > 0) {
				$clause .= " AND a.bn_type = $bn_type ";
				$clause2 .= " AND bn_type = $bn_type ";
			}
		}
		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			if ($deliver_setup > 0) {
				$deliver_setup--;
				$clause .= " AND a.deliver_setup = $deliver_setup ";
				$clause2 .= " AND deliver_setup = $deliver_setup ";
			}
		}

		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			// $clause .= " AND a.createdate BETWEEN $date_start ";
			$clause2 .= " AND createdate BETWEEN '{$date_start}' ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			// $clause .= " AND  $date_end ";
			$clause2 .= " AND  '{$date_end}' ";
		}
		if (!empty($data["status_code"])) {
			$status_code = (int)$data["status_code"];
			if ($status_code > 0) {
				$clause .= " AND a.bn_status_code = $status_code ";
				$clause2 .= " AND bn_status_code = $status_code ";
			}
		}
		if (!empty($data["sel_lc_code"])) {
			$sel_lc_code = trim($data["sel_lc_code"]);
			if (!empty($sel_lc_code)) {
				$clause .= " AND b.lc_code LIKE '%$sel_lc_code%' ";
			}
		}
		$start_time = microtime(true);
		$sql = "SELECT bn_master_id FROM bn_master $clause2 ORDER BY bn_master_id DESC";
		$result = $GLOBALS['DB']->get_query_result($sql, false);
		if ($_SESSION["emp_id"] == '144') {
			echo $sql . '<br>';
		}
		$end_time = microtime(true);
		$time_total = $end_time - $start_time;
		// echo "執行了：".$time_total."秒".'<br>';
		//exit;
		$bn_master_id = '';
		if (!empty($result)) {
			$start_time2 = microtime(true);
			for ($i = 0; $i < count($result); $i++) {
				$bn_master_id .= "'" . $result[$i]['bn_master_id'] . "',";
			}
			$bn_master_id = substr($bn_master_id, 0, -1);

			$sql = "SELECT a.* FROM bn_master AS a RIGHT JOIN bn_eod AS b ON a.bn_master_id = b.bn_master_id $clause and a.bn_master_id in ($bn_master_id) GROUP BY b.bn_master_id ORDER BY a.createdate DESC LIMIT $start, $num_per_page";
			$result = $GLOBALS['DB']->get_query_result($sql, false);
			// if ($_SESSION["emp_id"] == '144') {
			// echo $sql . '<br>';
			// }
			$end_time2 = microtime(true);
			$time_total2 = $end_time2 - $start_time2;
			// echo "執行了：".$time_total2."秒".'<br>';
			$start_time3 = microtime(true);
			$sql = "SELECT b.bn_master_id as num,bn_volume FROM bn_master AS a RIGHT JOIN bn_eod AS b ON a.bn_master_id = b.bn_master_id $clause  and a.bn_master_id in ($bn_master_id) GROUP BY b.bn_master_id ";
			$num = $GLOBALS['DB']->get_query_result($sql, false);
			if ($_SESSION["emp_id"] == '144') {
				// echo $sql.'<br>';
			}
			$end_time3 = microtime(true);
			$time_total3 = $end_time3 - $start_time3;
			// echo "執行了：".$time_total3."秒".'<br>';
			$total_v = 0;
			if (!empty($num)) {
				foreach ($num as $key => $value) {
					$total_v += $value["bn_volume"];
				}
			} else {
				$num = 0;
			}
		} else {
			$num = 0;
			$total_v = 0;
			$result = 'error';
		}

		return array($result, count($num), $total_v);
	}

	function check_no($bn_no)
	{
		$sql = "SELECT count(1) AS total FROM bn_master WHERE bn_no = '$bn_no' ";
		// echo $sql;
		$result = $GLOBALS['DB']->get_query_result($sql, false);
		// return $GLOBALS['DB']->get_query_result($sql,false);
		// return array($result);
		return $result;
	}
	// **************************************************************************
	//  函數名稱: check_bn_master_all()
	//  函數功能: 共用樣板驗證機制
	//  使用方式: $str_value 值
	//			 $str_rule 參數
	//			 $str_size 最小單位
	//			 $str_name 欄位名稱
	//	required1 驗證input數字型態
	//	required2 驗證select未選擇
	//	required3 驗證欄位不可為空
	//	required4 驗證input數字型態且不得為空
	//	required5 驗證email
	//	required6 驗證驗證身份證字號
	//	return $chk_ok,$chk_number
	//	$chk_ok >錯誤訊息提示
	//	$chk_number >1=input;2=select
	//  程式設計: 小樵
	//  設計日期: 2022.10.14
	// **************************************************************************
	function check_bn_master_all($str_value, $str_rule, $str_size, $str_name)
	{
		$chk_ok = '';
		$chk_number = '';
		switch ($str_rule) {
			case "required1": //驗證數字型態
				if (!ctype_digit($str_value) && $str_value != '') {
					$chk_ok = '「' . $str_name . '」請確實登打「數字」！';
					$chk_number = '1';
				}
				break;
			case "required2": //驗證select未選擇
				if ($str_value == "0") {
					$chk_ok = '「' . $str_name . '」下拉式選單「未選擇」！';
					$chk_number = '2';
				}
				break;
			case "required3": //驗證欄位不可為空
				if ($str_value == '') {
					$chk_ok = '請注意！！！「' . $str_name . '」不可為空！';
					$chk_number = '1';
				}
				break;
			case "required4": //驗證數字型態欄位且不得為空且低於最小單位
				if (!ctype_digit($str_value) && $str_value != '') {
					$chk_ok = '「' . $str_name . '」請確實登打「數字」！';
					$chk_number = '1';
				}
				if ($str_value == '') {
					$chk_ok = '「' . $str_name . '」不得為空！';
					$chk_number = '1';
				}
				if (ctype_digit($str_value) && $str_value != '' && strlen($str_value) < $str_size) {
					$chk_ok = '「' . $str_name . '」內容長度不足！';
					$chk_number = '1';
				}
				break;
			case "required5": //驗證email
				if ($str_value == '') {
					$chk_ok = '「' . $str_name . '」請注意e-mail不可空白！！！';
					$chk_number = '1';
				} else {
					if (empty($str_value) || strlen($str_value) < 7 || strpos($str_value, '@') === false || strpos($str_value, '.') === false) {
						$chk_ok = '「' . $str_name . '」請注意e-mail格式！！！';
						$chk_number = '1';
					}
				}
				break;
			case "required6": //驗證身份證字號
				// $vchk_ok = 'Y';
				if ($str_value == '') {
					$chk_ok = '請注意！！！「' . $str_name . '」不可為空白！';
					$chk_number = '1';
				} else {
					$vid1 = $vid2 = $vid3 = $vid4 = $vid5 = $vid6 = $vid7 = $vid8 = $vid9 = $vid10 = '';
					if (empty($str_value) || strlen($str_value) <> 10) {
						$chk_ok = '請注意！！！「' . $str_name . '」長度不符！';
						$chk_number = '1';
					} else {
						$vid1  = ucfirst(substr($str_value, 0, 1)); // 第 1碼
						$vid2  = substr($str_value, 1, 1); // 第 2碼
						$vid3  = substr($str_value, 2, 1); // 第 3碼
						$vid4  = substr($str_value, 3, 1); // 第 4碼
						$vid5  = substr($str_value, 4, 1); // 第 5碼
						$vid6  = substr($str_value, 5, 1); // 第 6碼
						$vid7  = substr($str_value, 6, 1); // 第 7碼
						$vid8  = substr($str_value, 7, 1); // 第 8碼
						$vid9  = substr($str_value, 8, 1); // 第 9碼
						$vid10 = substr($str_value, 9, 1); // 第10碼
					}
					if (!ctype_digit($vid2)) {
						// 字母對應特定數
						$ar_abc = array(
							'10' => 'A',
							'11' => 'B',
							'12' => 'C',
							'13' => 'D',
							'14' => 'E',
							'15' => 'F',
							'16' => 'G',
							'17' => 'H',
							'34' => 'I',
							'18' => 'J',
							'19' => 'K',
							'20' => 'L',
							'21' => 'M',
							'22' => 'N',
							'35' => 'O',
							'23' => 'P',
							'24' => 'Q',
							'25' => 'R',
							'26' => 'S',
							'27' => 'T',
							'28' => 'U',
							'29' => 'V',
							'32' => 'W',
							'30' => 'X',
							'31' => 'Y',
							'33' => 'Z'
						);

						// 步驟一 >> 將1~10碼分別放置於變數中
						$vid1  = array_search(ucfirst(substr($str_value, 0, 1)), $ar_abc);  //第 1碼
						$vid2  = substr(array_search(ucfirst(substr($str_value, 1, 1)), $ar_abc), 1, 1);  // 第 2碼

						// 步驟二 >> 第1~9碼分別乘以特定數 1987654321
						$vidchk[0]  = substr($vid1, 0, 1);
						$vidchk[1]  = substr($vid1, 1, 1) * 9;
						$vidchk[2]  = $vid2 * 8;
						$vidchk[3]  = $vid3 * 7;
						$vidchk[4]  = $vid4 * 6;
						$vidchk[5]  = $vid5 * 5;
						$vidchk[6]  = $vid6 * 4;
						$vidchk[7]  = $vid7 * 3;
						$vidchk[8]  = $vid8 * 2;
						$vidchk[9]  = $vid9 * 1;
						$vidchk[10] = $vid10;
						//print_r($vidchk);
						// 步驟三 >> 將1~9碼相乘後個位數相加總和
						$vt = 0;
						for ($i = 0; $i < (count($vidchk) - 1); $i++) {
							$vn = $vidchk[$i];
							if ($vidchk[$i] >= 10) { //雙位數
								$vn = substr($vidchk[$i], 1, 1);
							}
							$vt += $vn;
						}
						// 相加後取尾數
						if ($vt >= 10) {
							$vt = substr($vt, 1, 1);
						}
						// 檢查號碼＝10－相乘後個位數相加總和之尾數
						if ($vt <> 0) {
							$vt = 10 - $vt;
						}
						// 步驟四 >> 比對是否等於檢查碼
						if ($vt != $vidchk[10]) {
							$vchk_ok = 'N';
						}
					} else {  //本國人士身份證
						switch ($vid1) { // 身份証字號第一碼
							case "A": //
								$vidnum1 = '10';
								break;
							case "B": //
								$vidnum1 = '11';
								break;
							case "C": //
								$vidnum1 = '12';
								break;
							case "D": //
								$vidnum1 = '13';
								break;
							case "E": //
								$vidnum1 = '14';
								break;
							case "F": //
								$vidnum1 = '15';
								break;
							case "G": //
								$vidnum1 = '16';
								break;
							case "H": //
								$vidnum1 = '17';
								break;
							case "I": //
								$vidnum1 = '34';
								break;
							case "J": //
								$vidnum1 = '18';
								break;
							case "K": //
								$vidnum1 = '19';
								break;
							case "L": //
								$vidnum1 = '20';
								break;
							case "M": //
								$vidnum1 = '21';
								break;
							case "N": //
								$vidnum1 = '22';
								break;
							case "O": //
								$vidnum1 = '35';
								break;
							case "P": //
								$vidnum1 = '23';
								break;
							case "Q": //
								$vidnum1 = '24';
								break;
							case "R": //
								$vidnum1 = '25';
								break;
							case "S": //
								$vidnum1 = '26';
								break;
							case "T": //
								$vidnum1 = '27';
								break;
							case "U": //
								$vidnum1 = '28';
								break;
							case "V": //
								$vidnum1 = '29';
								break;
							case "W": //
								$vidnum1 = '32';
								break;
							case "X": //
								$vidnum1 = '30';
								break;
							case "Y": //
								$vidnum1 = '31';
								break;
							case "Z": //
								$vidnum1 = '33';
								break;
							default:
								break;
						}
						$vidchk0  = substr($vidnum1, 0, 1);
						$vidchk1  = substr($vidnum1, 1, 1) * 9;
						$vidchk2  = $vid2 * 8;
						$vidchk3  = $vid3 * 7;
						$vidchk4  = $vid4 * 6;
						$vidchk5  = $vid5 * 5;
						$vidchk6  = $vid6 * 4;
						$vidchk7  = $vid7 * 3;
						$vidchk8  = $vid8 * 2;
						$vidchk9  = $vid9 * 1;
						$vidchk10 = $vid10;

						$vidchknum = $vidchk0 + $vidchk1 + $vidchk2 + $vidchk3 + $vidchk4 + $vidchk5 + $vidchk6 + $vidchk7 + $vidchk8 + $vidchk9 + $vidchk10;
						if ($vidchknum % 10 <> 0) { // 有餘數，錯誤
							$chk_ok = '請注意！！！身分證字號輸入錯誤！';
							$chk_number = '1';
						}
					}
				}
		}
		return array($chk_ok, $chk_number);
	}

	function create_bn($data)
	{
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		$cargo = search_cargo($data["cargo_code"]);

		$bn_edi_type = 0;
		$bn_no = htmlspecialchars(trim(strtoupper($cargo["cargo_bn_simple"] . $data["bn_no"])));
		$bn_mode = (int)$data["bn_mode"];
		$bn_type = (int)$data["bn_type"];
		$action_type = isset($data["action_type"]) ? (int)$data["action_type"] : 1;
		$lc_id = $GLOBALS["lc_id"];
		$lc_code = $GLOBALS["lc_code"];
		$cargo_id = $cargo["cargo_id"];
		$cargo_code = $cargo["cargo_code"];
		$bn_charge = (int)$data["bn_charge"];
		if (!empty($data["receiver_store"])) {
			$receiver_store_id = (int)$data["receiver_store"];
		} else {
			$receiver_store_id = 0;
		}
		$receiver_store_code = "";
		if ($receiver_store_id > 0) {
			$cargo_store = search_cargo_store_id($receiver_store_id);
			$receiver_store_code = $cargo_store["store_code"] . " " . $cargo_store["store_name"];
		}
		if (!empty($data["receiver_name"])) {
			$bn_receiver_name = htmlspecialchars(trim($data["receiver_name"]));
		} else {
			$bn_receiver_name = '';
		}
		if (!empty($data["receiver_phone"])) {
			// $bn_receiver_phone = htmlspecialchars(trim($data["receiver_phone"]));
			$bn_receiver_phone = str_replace("-", "", htmlspecialchars(trim($data["receiver_phone"])));
			$bn_receiver_phone = str_replace("(", "", htmlspecialchars(trim($data["receiver_phone"])));
			$bn_receiver_phone = str_replace(")", "", htmlspecialchars(trim($data["receiver_phone"])));
			// $bn_receiver_phone = (int)$bn_receiver_phone;
			// $bn_receiver_phone = (int)$data["receiver_phone"];
		} else {
			$bn_receiver_phone = '';
		}
		if (!empty($data["receiver_phone_2"])) {
			// $bn_receiver_phone = htmlspecialchars(trim($data["receiver_phone"]));
			$bn_receiver_phone_2 = str_replace("-", "", htmlspecialchars(trim($data["receiver_phone_2"])));
			$bn_receiver_phone_2 = str_replace("(", "", htmlspecialchars(trim($data["receiver_phone_2"])));
			$bn_receiver_phone_2 = str_replace(")", "", htmlspecialchars(trim($data["receiver_phone_2"])));
			// $bn_receiver_phone = (int)$bn_receiver_phone;
			// $bn_receiver_phone = (int)$data["receiver_phone"];
		} else {
			$bn_receiver_phone_2 = '';
		}
		if (!empty($data["receiver_phone2"])) {
			$bn_receiver_phone2 = str_replace("-", "", htmlspecialchars(trim($data["receiver_phone2"])));
			$bn_receiver_phone2 = str_replace("(", "", htmlspecialchars(trim($data["receiver_phone2"])));
			$bn_receiver_phone2 = str_replace(")", "", htmlspecialchars(trim($data["receiver_phone2"])));
		} else {
			$bn_receiver_phone2 = '';
		}
		if (!empty($data["receiver_zip"])) {
			$bn_receiver_zip = (int)$data["receiver_zip"];
		} else {
			$bn_receiver_zip = '';
		}
		if (!empty($data["receiver_addr"])) {
			$bn_receiver_addr = htmlspecialchars(trim($data["receiver_addr"]));
		} else {
			$bn_receiver_addr = '';
		}

		$deliver_store_code = "";

		if (!empty($data["deliver_store"])) {
			$deliver_store_id = (int) $data["deliver_store"];
			if ($deliver_store_id > 0) {
				$cargo_store = search_cargo_store_id($deliver_store_id);
				$deliver_store_code = $cargo_store["store_code"] . " " . $cargo_store["store_name"];
			}
		} else {
			$deliver_store_id = '0';
		}
		if (!empty($data["deliver_name"])) {
			$bn_deliver_name = htmlspecialchars(trim($data["deliver_name"]));
		} else {
			$bn_deliver_name = '';
		}
		if (!empty($data["deliver_phone"])) {
			// $bn_deliver_phone = htmlspecialchars(trim($data["deliver_phone"]));
			$bn_deliver_phone = str_replace("-", "", htmlspecialchars(trim($data["deliver_phone"])));
			$bn_deliver_phone = str_replace("(", "", htmlspecialchars(trim($data["deliver_phone"])));
			$bn_deliver_phone = str_replace(")", "", htmlspecialchars(trim($data["deliver_phone"])));
		} else {
			$bn_deliver_phone = '';
		}
		if (!empty($data["deliver_phone_2"])) {
			$bn_deliver_phone_2 = str_replace("-", "", htmlspecialchars(trim($data["deliver_phone_2"])));
			$bn_deliver_phone_2 = str_replace("(", "", htmlspecialchars(trim($data["deliver_phone_2"])));
			$bn_deliver_phone_2 = str_replace(")", "", htmlspecialchars(trim($data["deliver_phone_2"])));
			// $bn_deliver_phone = htmlspecialchars(trim($data["deliver_phone"]));
		} else {
			$bn_deliver_phone_2 = '';
		}
		if (!empty($data["deliver_phone2"])) {
			// $bn_deliver_phone = htmlspecialchars(trim($data["deliver_phone"]));
			$bn_deliver_phone2 = str_replace("-", "", htmlspecialchars(trim($data["deliver_phone2"])));
			$bn_deliver_phone2 = str_replace("(", "", htmlspecialchars(trim($data["deliver_phone2"])));
			$bn_deliver_phone2 = str_replace(")", "", htmlspecialchars(trim($data["deliver_phone2"])));
		} else {
			$bn_deliver_phone2 = '';
		}
		if (!empty($data["deliver_zip"])) {
			$bn_deliver_zip = (int)$data["deliver_zip"];
		} else {
			$bn_deliver_zip = '';
		}
		if (!empty($data["deliver_addr"])) {
			$bn_deliver_addr = htmlspecialchars(trim($data["deliver_addr"]));
		} else {
			$bn_deliver_addr = '';
		}
		if (!empty($data["get_time"])) {
			$bn_get_time_plan = $data["get_time"];
		} else {
			$bn_get_time_plan = '';
		}
		if (!empty($data["arrival_time"])) {
			$bn_arrival_time_plan = $data["arrival_time"];
		} else {
			$bn_arrival_time_plan = '';
		}
		$self_carr = htmlspecialchars(trim($data["self_carr"]));
		$cargoo_pay_dept = htmlspecialchars(trim($data["pay_dept"]));
		$cargo_dept = htmlspecialchars(trim($data["cargo_dept"]));
		$cargo_deptname = htmlspecialchars(trim($data["cargo_deptname"]));
		$deliver_setup = (int)$data["deliver_setup"];
		$bn_note = htmlspecialchars(addslashes(trim($data["bn_note"]))); //update by chiao 20220407 反斜線處理

		$bn_distance = "";
		if ($cargo_code == "ACTION") {
			$bn_distance = htmlspecialchars(trim($data["bn_distance"]));
		}

		$create_time = time();
		$create_user = $_SESSION["emp_name"];
		$create_ip = $_SERVER['REMOTE_ADDR'];

		if ($self_carr == 'Y') {
			$bn_type = 9;
		}

		$sql = "INSERT INTO bn_master (bn_edi_type,
									bn_no,
									bn_mode,
									bn_type,
									action_type,

									lc_id,
									lc_code,
									cargo_id,
									cargo_code,
									bn_charge,
									receiver_store_id,
									receiver_store_code,
									bn_receiver_name,
									bn_receiver_phone,
									bn_receiver_phone_2,
									bn_receiver_phone2,
									bn_receiver_zip,
									bn_receiver_addr,
									deliver_store_id,
									deliver_store_code,
									bn_deliver_name,
									bn_deliver_phone,
									bn_deliver_phone_2,
									bn_deliver_phone2,
									bn_deliver_zip,
									bn_deliver_addr,
									bn_get_time_plan,
									bn_arrival_time_plan,
									self_carr,
									cargoo_pay_dept,
									cargo_dept,
									cargo_deptname,
									deliver_setup,

									bn_note,

									bn_distance,
									ipfrom,
									createdate,
									createuser,

									bn_eod_id,
									bn_customer_no,
									bn_cn,
									bn_freight_mode,
									bn_delivery_charge,
									bn_pay_cash,
									sdabw,
									bn_get_time,
									bn_arrival_time,
									bn_getback_no,
									dispatch_no,
									vehdrv_name,
									vehdrv_phone,
									pickup_no,
									bn_leave_time,
									bn_no_cardno,
									bn_box,
									bn_volume,
									bn_size,
									bn_kg,
									bn_inv_no,
									bn_rinv_no,
									bn_boxno,
									to_eod,
									to_eod_date,
									deliver_setup_type,
									deliver_layer,
									deliver_floor,
									deliver_layer2,
									deliver_floor2,
									bn_print,
									bn_logistics_type,
									bn_status_code,
									bn_status,
									bn_status_time,
									momo_do_note,
									bn_file_date,
									bn_FT,
									bn_distance_pro,
									bn_distance_rdoc,
									bn_dcim_ok,
									action_type1,
									bn_data,
									dn_no, 
									action_business_code, 
									action_business_name, 
									charge_floag, 
									install_date, 
									install_date_user, 
									install_note, 
									updatedate, 
									updateuser, 
									kpi_chk, 
									action_api_data, 
									action_api_leave_check, 
									action_api_complete_check, 
									momo_type, 
									wh_area, 
									detail_send, 
									sr_send, df_send, 
									ts_turn_send, 
									ts_contact_send, 
									ts_ship_send, 
									sell_office, 
									pay_unit, 
									unit_code
								) VALUES (
									$bn_edi_type,
									'$bn_no',
									$bn_mode,
									$bn_type,
									$action_type,
									$lc_id,
									'$lc_code',
									$cargo_id,
									'$cargo_code',
									$bn_charge,
									$receiver_store_id,
									'$receiver_store_code',
									'$bn_receiver_name',
									'$bn_receiver_phone',
									'$bn_receiver_phone_2',
									'$bn_receiver_phone2',
									'$bn_receiver_zip',
									'$bn_receiver_addr',
									$deliver_store_id,
									'$deliver_store_code',
									'$bn_deliver_name',
									'$bn_deliver_phone',
									'$bn_deliver_phone_2',
									'$bn_deliver_phone2',
									'$bn_deliver_zip',
									'$bn_deliver_addr',
									'$bn_get_time_plan',
									'$bn_arrival_time_plan',
									'$self_carr',
									'$cargoo_pay_dept',
									'$cargo_dept',
									'$cargo_deptname',
									$deliver_setup,
									'$bn_note',
									'$bn_distance',
									'$create_ip',
									'$create_time',
									'$create_user',
									0,
									'',
									'',
									'',
									'N',
									1,
									0,
									'',
									'',
									'',
									'',
									'',
									'',
									'',
									0,
									0,
									0,
									0,
									0,
									0,
									'',
									'',
									'',
									0,
									0,
									1,
									0,
									1,
									0,
									0,
									0,
									1,
									'',
									'',
									'',
									'',
									'',
									10,
									'N',
									'',
									0,
									0,
									'',
									'',
									'',
									'',
									'',
									'',
									'',
									'',
									0,
									'',
									0,
									0,
									0,
									0,
									0,
									'',
									0,
									0,
									0,
									0,
									0,
									0,
									'',
									'',
									''
							)";
		$GLOBALS['DB']->query($sql);
		// echo $sql.'<br>';exit;
		//if ($conn = $GLOBALS['DB']->query($sql) == TRUE) {
		//                echo "插入成功";
		//            } else {
		//                //if(權限==it){
		//                  echo "Error: " . $sql . "<br>" . $conn->error;
		//                //}else{
		//                //  echo "插入失敗，請確認內容是否有單ｏｒ雙引號或是請洽分機２１９周筠樵協助處理，謝謝！";
		//                //}
		//                exit;
		//            }


		$bn_id = $GLOBALS['DB']->insert_id();

		$total_V = 0;
		$total_K = 0;
		$total_S = 0;
		$total_Box = 0;

		foreach ($data["item_code"] as $key => $value) {
			$cargo_item =  search_cargo_item_code($cargo_id, $value);
			$item_id = (int)$cargo_item["cargo_item_id"];
			$item_name = trim($data["item_name"][$key]);
			$item_model = trim($data["item_model"][$key]);
			$item_V = (float)$cargo_item["item_V"];
			$item_K = (float)$cargo_item["item_K"];
			$item_S = (float)$cargo_item["item_S"];

			$item_seq = $key + 1;
			$item_qty = (int)$data["item_qty"][$key];
			$item_grade = ((int)$data["item_grade"][$key] > 0) ? (int)$data["item_grade"][$key] : '1';
			if (!empty($data["item_lot"][$key])) {
				$item_lot = htmlspecialchars(trim($data["item_lot"][$key]));
			} else {
				$item_lot = '';
			}
			$item_sno = htmlspecialchars(trim($data["item_sno"][$key]));
			$item_note = htmlspecialchars(trim($data["item_note"][$key]));

			$total_V += ($item_V * $item_qty);
			$total_K += ($item_K * $item_qty);
			$total_S += ($item_S * $item_qty);
			$total_Box += $item_qty;

			$sql = "INSERT INTO bn_detail (
										bn_master_id,
										bn_no,
										cargo_id,
										cargo_code,
										item_seq,
										cargo_item_id,
										item_code,
										item_name,
										item_model,
										item_qty_r,
										item_V,
										item_K,
										item_S,
										item_grade,
										item_lot,
										item_sno,
										item_note,
										ipfrom,
										createdate,
										createuser,
										item_qty,
										lc_id,
										lc_code,
										lsa_id,
										lsa_code,
										lss_id,
										lss_code,
										bn_dnno,
										sno_flag,
										updatedate,
										updateuser
									) VALUES (
										$bn_id,
										'$bn_no',
										$cargo_id,
										'$cargo_code',
										$item_seq,
										$item_id,
										'$value',
										'$item_name',
										'$item_model',
										$item_qty,
										$item_V,
										$item_K,
										$item_S,
										$item_grade,
										'$item_lot',
										'$item_sno',
										'$item_note',
										'$create_ip',
										'$create_time',
										'$create_user',
										0,
										0,
										'',
										0,
										'',
										0,
										'',
										'',
										0,
										0,
										'')";
			$GLOBALS['DB']->query($sql);
		}
		$GLOBALS['DB']->query("UPDATE bn_master SET bn_box = $total_Box, bn_volume = " . round($total_V, 2) . ", bn_size = $total_S, bn_kg = $total_K  WHERE bn_master_id = $bn_id");
	}

	function delete_bn($id)
	{

		$bn = $this->search_bn($id);
		$GLOBALS['DB']->query("INSERT INTO delete_inv_bn (type,no,cargoo_code,delete_time,delete_ip,delete_user) VALUE ('2', '" . $bn["bn_no"] . "', '" . $bn["cargo_code"] . "', '" . date("YmdHis") . "', '" . (string) $_SERVER['REMOTE_ADDR'] . "' ,'" . (string) $_SESSION["emp_name"] . "')");

		$GLOBALS['DB']->query("DELETE FROM bn_master WHERE bn_master_id = $id");
		$GLOBALS['DB']->query("DELETE FROM bn_detail WHERE bn_master_id = $id");
	}

	function search_bn($id = 0)
	{
		$sql = "SELECT * FROM bn_master WHERE bn_master_id = $id ";
		return $GLOBALS['DB']->get_query_result($sql, true);
	}

	function search_bn_detail($id = 0)
	{
		$sql = "SELECT * FROM bn_detail WHERE bn_master_id = $id ORDER BY bn_detail_id";
		return $GLOBALS['DB']->get_query_result($sql, false);
	}
	function search_cargo_item($item_code)
	{
		$sql = "SELECT * FROM cargo_item WHERE item_code = '$item_code' ";
		return $GLOBALS['DB']->get_query_result($sql, true);
	}

	function delete_item($data)
	{
		$bn_id = (int)$data["bn_id"];
		$item_id = (int)$data["item_id"];
		$GLOBALS['DB']->query("DELETE FROM bn_detail WHERE bn_master_id = $bn_id AND bn_detail_id = $item_id ");

		$total_V = 0;
		$total_K = 0;
		$total_S = 0;
		$total_Box = 0;

		$bn_detail = $this->search_bn_detail($bn_id);
		if (!empty($bn_detail)) {
			foreach ($bn_detail as $key => $value) {
				$total_V += ($value["item_V"] * $value["item_qty_r"]);
				$total_K += ($value["item_K"] * $value["item_qty_r"]);
				$total_S += ($value["item_S"] * $value["item_qty_r"]);
				$total_Box += $value["item_qty_r"];
			}
		}
		$GLOBALS['DB']->query("UPDATE bn_master SET bn_box = $total_Box, bn_volume = " . round($total_V, 2) . ", bn_size = $total_S, bn_kg = $total_K  WHERE bn_master_id = $bn_id");
	}

	function edit_bn($data)
	{
		$bn_master_id = (int)$data["bn_master_id"];
		$bn_mode = (int)$data["bn_mode"];
		$bn_charge = (int)$data["bn_charge"];
		$bn_type = (int)$data["bn_type"];
		$action_type = isset($data["action_type"]) ? (int)$data["action_type"] : 1;
		if (!empty($data["receiver_store"])) {
			$receiver_store_id = (int)$data["receiver_store"];
		} else {
			$receiver_store_id = '0';
		}
		if (!empty($data["receiver_name"])) {
			$bn_receiver_name = htmlspecialchars(trim($data["receiver_name"]));
		} else {
			$bn_receiver_name = '';
		}
		if (!empty($data["receiver_phone"])) {
			$bn_receiver_phone = htmlspecialchars(trim($data["receiver_phone"]));
		} else {
			$bn_receiver_phone = '';
		}
		if (!empty($data["receiver_phone_2"])) {
			$bn_receiver_phone_2 = htmlspecialchars(trim($data["receiver_phone_2"]));
		} else {
			$bn_receiver_phone_2 = '';
		}
		if (!empty($data["receiver_phone2"])) {
			$bn_receiver_phone2 = htmlspecialchars(trim($data["receiver_phone2"]));
		} else {
			$bn_receiver_phone2 = '';
		}
		if (!empty($data["receiver_zip"])) {
			$bn_receiver_zip = (int)$data["receiver_zip"];
		} else {
			$bn_receiver_zip = '';
		}
		if (!empty($data["receiver_addr"])) {
			$bn_receiver_addr = htmlspecialchars(trim($data["receiver_addr"]));
		} else {
			$bn_receiver_addr = '';
		}
		if ($receiver_store_id > 0) {
			$cargo_store = search_cargo_store_id($receiver_store_id);
			$receiver_store_code = $cargo_store["store_code"] . " " . $cargo_store["store_name"];
		} else {
			$receiver_store_code = 0;
		}
		$deliver_store_code = '';
		if (!empty($data["deliver_store"])) {
			$deliver_store_id = (int) $data["deliver_store"];
			if ($deliver_store_id > 0) {
				$cargo_store = search_cargo_store_id($deliver_store_id);
				$deliver_store_code = $cargo_store["store_code"] . " " . $cargo_store["store_name"];
			}
		} else {
			$deliver_store_id = '0';
		}
		if (!empty($data["deliver_name"])) {
			$bn_deliver_name = htmlspecialchars(trim($data["deliver_name"]));
		} else {
			$bn_deliver_name = '';
		}
		if (!empty($data["deliver_phone"])) {
			$bn_deliver_phone = htmlspecialchars(trim($data["deliver_phone"]));
		} else {
			$bn_deliver_phone = '';
		}
		if (!empty($data["deliver_phone_2"])) {
			$bn_deliver_phone_2 = htmlspecialchars(trim($data["deliver_phone_2"]));
		} else {
			$bn_deliver_phone_2 = '';
		}
		if (!empty($data["deliver_phone2"])) {
			$bn_deliver_phone2 = htmlspecialchars(trim($data["deliver_phone2"]));
		} else {
			$bn_deliver_phone2 = '';
		}
		if (!empty($data["deliver_zip"])) {
			$bn_deliver_zip = (int)$data["deliver_zip"];
		} else {
			$bn_deliver_zip = '';
		}
		if (!empty($data["deliver_addr"])) {
			$bn_deliver_addr = htmlspecialchars(trim($data["deliver_addr"]));
		} else {
			$bn_deliver_addr = '';
		}
		if (!empty($data["get_time"])) {
			$bn_get_time_plan = $data["get_time"];
		} else {
			$bn_get_time_plan = '';
		}
		if (!empty($data["arrival_time"])) {
			$bn_arrival_time_plan = $data["arrival_time"];
		} else {
			$bn_arrival_time_plan = '';
		}
		$self_carr = htmlspecialchars(trim($data["self_carr"]));
		$cargoo_pay_dept = htmlspecialchars(trim($data["pay_dept"]));
		$cargo_dept = htmlspecialchars(trim($data["cargo_dept"]));
		$cargo_deptname = htmlspecialchars(trim($data["cargo_deptname"]));
		$deliver_setup = (int)$data["deliver_setup"];
		$bn_note = htmlspecialchars(addslashes(trim($data["bn_note"]))); //update by chiao 20220407 反斜線處理

		$bn_distance = "";
		if ($data["cargo_code"] == "ACTION") {
			$bn_distance = htmlspecialchars(trim($data["bn_distance"]));
		}

		if ($self_carr == 'Y') {
			$bn_type = 9;
		}

		$update_time = time();
		$update_user = $_SESSION["emp_name"];
		$update_ip = $_SERVER['REMOTE_ADDR'];

		if ($bn_mode == 1) {
			$sql = "UPDATE bn_master SET 
								bn_type = '$bn_type',
								bn_charge = '$bn_charge',
								action_type = '$action_type',
								receiver_store_id = '$receiver_store_id',
								receiver_store_code = '$receiver_store_code',
								bn_receiver_name = '$bn_receiver_name',
								bn_receiver_phone = '$bn_receiver_phone',
								bn_receiver_phone_2 = '$bn_receiver_phone_2',
								bn_receiver_phone2 = '$bn_receiver_phone2',
								bn_receiver_zip = '$bn_receiver_zip',
							  	bn_receiver_addr = '$bn_receiver_addr',
							    bn_get_time_plan = '$bn_get_time_plan',
							    bn_arrival_time_plan = '$bn_arrival_time_plan',
							    self_carr = '$self_carr',
							    cargoo_pay_dept = '$cargoo_pay_dept', 
							    cargo_dept = '$cargo_dept',
							    cargo_deptname = '$cargo_deptname', 
							    deliver_setup = '$deliver_setup',
							    bn_note = '$bn_note',
							    bn_distance = '$bn_distance',
							    updatedate = '$update_time',
							    updateuser = '$update_user'
							WHERE bn_master_id = '$bn_master_id' ";
		} else {
			$sql = "UPDATE bn_master SET 
								bn_type = '$bn_type',
								bn_charge = '$bn_charge',
								action_type = '$action_type',
								receiver_store_id = '$receiver_store_id',
								receiver_store_code = '$receiver_store_code',
								bn_receiver_name = '$bn_receiver_name',
								bn_receiver_phone = '$bn_receiver_phone',
								bn_receiver_phone_2 = '$bn_receiver_phone_2',
								bn_receiver_phone2 = '$bn_receiver_phone2',
								bn_receiver_zip = '$bn_receiver_zip',
							  	bn_receiver_addr = '$bn_receiver_addr',
							    deliver_store_id = '$deliver_store_id',
							    deliver_store_code = '$deliver_store_code',
							    bn_deliver_name = '$bn_deliver_name',
							    bn_deliver_phone = '$bn_deliver_phone',
							    bn_deliver_phone_2 = '$bn_deliver_phone_2',
							    bn_deliver_phone2 = '$bn_deliver_phone2',
							    bn_deliver_zip = '$bn_deliver_zip',
							    bn_deliver_addr = '$bn_deliver_addr',
							    bn_get_time_plan = '$bn_get_time_plan',
							    bn_arrival_time_plan = '$bn_arrival_time_plan',
							    self_carr = '$self_carr',
							    cargoo_pay_dept = '$cargoo_pay_dept', 
							    cargo_dept = '$cargo_dept',
							    cargo_deptname = '$cargo_deptname', 
							    deliver_setup = '$deliver_setup',
							    bn_note = '$bn_note',
							    bn_distance = '$bn_distance',
							    updatedate = '$update_time',
							    updateuser = '$update_user'
							WHERE bn_master_id = '$bn_master_id' ";
		}
		$GLOBALS['DB']->query($sql);
		// echo $sql;exit;

		$bn_no = htmlspecialchars(trim($data["bn_no"]));
		$cargo = search_cargo($data["cargo_code"]);

		$cargo_id = $cargo["cargo_id"];
		$cargo_code = $cargo["cargo_code"];

		$total_V = 0;
		$total_K = 0;
		$total_S = 0;
		$total_Box = 0;
		if (!empty($data["item_id"])) {
			foreach ($data["item_id"] as $key => $value) {
				$bn_detail_id = $value;
				$cargo_item = search_cargo_item_code($cargo_id, $data["item_code"][$key]);
				$item_id = (int)$cargo_item["cargo_item_id"];
				$item_code = $cargo_item["item_code"];
				$item_seq = $key + 1;
				$item_qty = (int)$data["item_qty"][$key];
				$item_grade = (int)$data["item_grade"][$key];
				if (!empty($data["item_lot"][$key])) {
					$item_lot = htmlspecialchars(trim($data["item_lot"][$key]));
				} else {
					$item_lot = '';
				}
				$item_sno = htmlspecialchars(trim($data["item_sno"][$key]));
				$item_note = htmlspecialchars(trim($data["item_note"][$key]));

				if ($bn_mode == 0) {
					$item_name = htmlspecialchars(trim($data["item_name"][$key]));
					$item_model = htmlspecialchars(trim($data["item_model"][$key]));
				} else {
					$item_name = trim($cargo_item["item_name"]);
					$item_model = htmlspecialchars(trim($cargo_item["item_model"]));
				}


				$item_V = (float)$data["item_V"][$key];
				$item_K = (float)$data["item_K"][$key];
				$item_S = (float)$data["item_S"][$key];

				$total_V += ($item_V * $item_qty);
				$total_K += ($item_K * $item_qty);
				$total_S += ($item_S * $item_qty);
				$total_Box += $item_qty;

				if ($bn_detail_id > 0) {
					$sql = "UPDATE bn_detail SET item_name = '$item_name', item_model = '$item_model', item_V = $item_V, item_K = $item_K, item_S = $item_S,item_seq = $item_seq, item_qty_r = $item_qty, item_grade = '$item_grade', item_lot = '$item_lot', item_sno = '$item_sno', item_note = '$item_note', updatedate = '$update_time', updateuser = '$update_user' WHERE bn_detail_id = $bn_detail_id";
				} else {
					$sql = "INSERT INTO bn_detail (
											bn_master_id,
											bn_no,
											cargo_id,
											cargo_code,
											item_seq,
											cargo_item_id,
											item_code,
											item_name,
											item_model,
											item_qty_r,
											item_V,
											item_K,
											item_S,
											item_grade,
											item_lot,
											item_sno,
											item_note,
											createdate,
											createuser,

											item_qty,
											lc_id,
											lc_code,
											lsa_id,
											lsa_code,
											lss_id,
											lss_code,
											bn_dnno,
											sno_flag,
											ipfrom,
											updatedate,
											updateuser
										) VALUES (
											$bn_master_id,
											'$bn_no',
											$cargo_id,
											'$cargo_code',
											$item_seq,
											$item_id,
											'$item_code',
											'$item_name',
											'$item_model',
											$item_qty,
											$item_V,
											$item_K,
											$item_S,
											$item_grade,
											'$item_lot',
											'$item_sno',
											'$item_note',
											'$update_time',
											'$update_user',
											0,
											0,
											'',
											0,
											'',
											0,
											'',
											'',
											0,
											0,
											0,
											'')";
				}
				$GLOBALS['DB']->query($sql);
			}
		}
		$GLOBALS['DB']->query("UPDATE bn_master SET bn_box = $total_Box, bn_volume = " . round($total_V, 2) . ", bn_size = $total_S, bn_kg = $total_K  WHERE bn_master_id = $bn_master_id");
	}

	function search_bn_detail_sort($id = 0)
	{
		$sql = "SELECT * FROM bn_detail WHERE bn_master_id = $id   ORDER BY item_lot , item_sno";
		//echo $sql.'<br>';
		return $GLOBALS['DB']->get_query_result($sql, false);
	}
	function transfer_order($data)
	{
		$lc_id = $GLOBALS["lc_id"];
		$lc_code = $GLOBALS["lc_code"];
		$error_msg = "";
		$error_msgRE = "";
		sort($data["bn_master_id"]);
		foreach ($data["bn_master_id"] as $id_key => $id) {
			if ((int)$id > 0) {
				$bn_master = $this->search_bn($id);
				if ($bn_master["to_eod"] == 0 && $bn_master["to_eod_date"] == 0) {
					$error_status = false;
					$inv_detail = $this->bn_inv_detail($id, $lc_id);
					$bn_detail = $this->search_bn_detail_sort($id);
					$sql_bn_list = "";
					$sql_inv_list = "";
					$sql_transfer_list = "";
					$error_status = "";
					// echo "<pre>";
					// print_r($inv_detail);
					// echo "</pre>";
					// exit();
					if (!empty($bn_detail)) {
						foreach ($bn_detail as $bn_key => $bn_value) {
							$bn_detail_id = $bn_value["bn_detail_id"];
							$bn_no = $bn_value["bn_no"];
							$cargo_id = $bn_value["cargo_id"];
							$cargo_code = $bn_value["cargo_code"];
							$cargo_item_id = $bn_value["cargo_item_id"];
							$item_code = $bn_value["item_code"];
							$item_name = $bn_value["item_name"];
							$item_grade = $bn_value["item_grade"];
							$item_lot = $bn_value["item_lot"];
							$item_sno = $bn_value["item_sno"];
							$item_note = $bn_value["item_note"];
							$item_qty_r = $bn_value["item_qty_r"];
							$bn_mode = $bn_master["bn_mode"];
							$bn_note = $bn_master["bn_note"];
							$update_time = time();
							$update_user = $_SESSION["emp_name"];
							$update_usercode = $_SESSION["emp_code"];
							$update_ip = $_SERVER['REMOTE_ADDR'];
							if ($item_qty_r <= 0) {
								$error_msg .= "單號:" . $bn_no . " 貨品:" . $item_code . " 數量有誤請確認<br>";
								$error_status = true;
							}
							if (!empty($inv_detail)) {
								foreach ($inv_detail as $inv_key => $inv_value) {
									if ($item_qty_r > 0 && $inv_value["stock_qty"] > 0) {
										$status = true;
										$num = 0;

										if (!empty($item_sno)) {
											if ($cargo_id == $inv_value["cargo_id"] and $cargo_item_id == $inv_value["cargo_item_id"] and $item_grade == $inv_value["item_grade"] and $item_sno == $inv_value["item_sno"]) {
												list($item_qty_r, $inv_detail[$inv_key]["stock_qty"], $num) = $this->count_inv_num($item_qty_r, $inv_value["stock_qty"]);
											} else {
												$status = false;
											}
										} else {
											if ($cargo_id == $inv_value["cargo_id"] and $cargo_item_id == $inv_value["cargo_item_id"] and $item_grade == $inv_value["item_grade"] and $item_lot == $inv_value["item_lot"] and $inv_value["item_sno"] == "") {
												list($item_qty_r, $inv_detail[$inv_key]["stock_qty"], $num) = $this->count_inv_num($item_qty_r, $inv_value["stock_qty"]);
											} elseif ($cargo_id == $inv_value["cargo_id"] and $cargo_item_id == $inv_value["cargo_item_id"] and $item_grade == $inv_value["item_grade"] and $item_lot == "" and $inv_value["item_sno"] == "") {
												list($item_qty_r, $inv_detail[$inv_key]["stock_qty"], $num) = $this->count_inv_num($item_qty_r, $inv_value["stock_qty"]);
											} else {
												$status = false;
											}
										}

										// echo 'item_sno=> ' . $item_sno . '$inv_value["item_sno"]=> ' . $inv_value["item_sno"] . '<br>';
										// exit;

										if ($item_sno == $inv_value["item_sno"]) {
											$chk_list01 = $this->chk_inv_stock($inv_value["cargo_item_id"], $inv_value["item_grade"], $inv_value["cargo_id"], $inv_value["item_sno"], $inv_value["lc_id"]);
											$chk_list02 = $this->chk_item_stock($inv_value["cargo_item_id"], $inv_value["item_grade"], $inv_value["cargo_id"], $inv_value["item_sno"], $inv_value["lc_id"]);
											// echo "<pre>";
											// print_r($inv_value["cargo_item_id"]);
											// print_r($chk_list01);
											// print_r($chk_list02);
											// echo '------' . '<br>';
											// echo "</pre>";
											// if ($chk_list01[0]["stock_qty"] <> $chk_list02[0]["item_Astock_num"]) {
											// 	$error_msg .= "客戶單號：" . $bn_no . "，轉單異常請協助通知IT處理！！！" . "<br>"; //貨品批號不等於帳面庫存
											// 	$status = false;
											// 	$error_status = true;
											// }
										} else {
											$status = false;
										}

										if ($status) {
											$inv_stock_id = $inv_value["inv_stock_id"];
											$lc_id = $inv_value["lc_id"];
											$lc_code = $inv_value["lc_code"];
											$lsa_id = $inv_value["lsa_id"];
											$lsa_code = $inv_value["lsa_code"];
											$lss_id = $inv_value["lss_id"];
											$lss_code = $inv_value["lss_code"];
											$inv_lot = $inv_value["item_lot"];
											$inv_sno = $inv_value["item_sno"];
											$sql_bn_list .= "INSERT INTO bn_detail_lss (bn_master_id,bn_detail_id,inv_stock_id ,bn_no,cargo_id,cargo_code,cargo_item_id,item_code,item_name,item_grade,item_lot,item_sno,item_note,lc_id,lc_code,lsa_id,lsa_code,lss_id,lss_code,item_stock,empname,empno,leave_ware,upd_ok) 
												VALUES ($id,$bn_detail_id,$inv_stock_id,'$bn_no',$cargo_id,'$cargo_code',$cargo_item_id,'$item_code' ,'{$item_name}',$item_grade,'$inv_lot','$inv_sno','$item_note',$lc_id,'$lc_code','$lsa_id','$lsa_code','$lss_id','$lss_code',$num,'{$update_user}','{$update_usercode}','','') ON DUPLICATE KEY UPDATE upd_ok = 'Y';";
											$sql_inv_list .= "UPDATE inv_stock SET stock_qty = stock_qty - $num WHERE inv_stock_id = $inv_stock_id;";
										}
									}
								}
							}

							if ($item_qty_r > 0) {
								$error_msg .= "單號:" . $bn_no . " 貨品:" . $item_code . " 儲位數量不足 ，請聯繫資訊人員<br>";
								$error_status = true;
							}
						}
					} else {
						$error_msg .= "單號:" . $bn_master["bn_no"] . " 沒有貨品資料請確認!<br>";
						$error_status = true;
					}
					if (!$error_status) {
						// echo $sql_bn_list;
						sql_multi_query($sql_bn_list);
						// exit;
						$stock_list = $this->check_bn_stock($id, $bn_detail_id);
						foreach ($stock_list as $key => $value) {
							if ($value["NowQty"] < 0) {
								$error_msg .= "單號:" . $value["bn_no"] . " 貨品:" . $value["item_code"] . " 序號:" . $value["item_sno"] . " 帳面庫存數不足 " . $value["NowQty"] . " <br>";
								$error_status = true;
							}
						}
						if (!$error_status) {
							$upd_ok_list = $this->check_bn_detail_lss_upd_ok($bn_detail_id, $update_usercode, $update_user);
							if (!empty($upd_ok_list)) {
								foreach ($upd_ok_list as $key => $value) {
									if ($value["upd_ok"] == 'Y' && ($value["empno"] != $update_usercode)) {
										$error_msg .= "客戶單號：" . $bn_no . "，與他人重複處理該筆資料,訂單不成立!!!<br>";
										$error_status = true;
									}
								}
							}
							if (!$error_status) {
								$this->update_item_stock($id);
								$this->update_bn_master($id);
								sql_multi_query($sql_inv_list);
								$this->update_itemV($id);
							}
						} else {
							$sql = "DELETE FROM bn_detail_lss WHERE bn_master_id = $id";
							$GLOBALS['DB']->query($sql);
							break;
						}
					} else {
						//break;
					}
				} else {
					$error_msg .= "單號:" . $bn_master["bn_no"] . " 已轉單請確認!<br>";
					$error_status = true;
				}
			}
			$error_msgRE = $error_msg;
			$sql_transfer_list .= "INSERT INTO transfer_orde_log (type,dispatch_no,no,cargoo_code,note,delete_time,delete_ip,delete_user,device,error_msg) VALUES ('$bn_mode','','$bn_no','$cargo_code','$bn_note','$update_time','$update_ip','$update_user','$lc_code','$error_msgRE');";
			$GLOBALS['DB']->query($sql_transfer_list);
			$error_msgRE = "";
		}
		// echo $error_msg;
		// exit();
		return $error_msg;
	}
	function transfer_ordereal22($data)
	{
		$lc_id = $GLOBALS["lc_id"];
		$lc_code = $GLOBALS["lc_code"];
		$error_msg = "";
		$error_msgRE = "";
		sort($data["bn_master_id"]);
		// echo '<pre>';
		// print_r($data["bn_master_id"]);
		// //print_r($GLOBALS);
		// echo '</pre>'; //exit;

		$sql = "SELECT bn_master_id FROM bn_master WHERE bn_mode = 1 AND lc_code = '$lc_code' and to_eod_date >= 1659542400 ORDER BY createdate DESC ";
		echo $sql;
		$result = $GLOBALS['DB']->get_query_result($sql, false);
		foreach ($result as $a_key => $a_val) {
			$data["bn_master_id"][$a_key] = $a_val["bn_master_id"];
		}
		// $sql = "SELECT count(1) as num FROM bn_master bn_mode = 1 AND lc_code = 'DC01' and to_eod_date >= 1659002400 and to_eod_date >= 1659002400 ";
		// $data["bn_master_id"] = $GLOBALS['DB']->get_query_result($sql,true);
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		// exit;
		foreach ($data["bn_master_id"] as $id_key => $id) {
			if ((int)$id > 0) {
				$bn_master = $this->search_bn($id);
				$error_status = false;
				$inv_detail = $this->bn_inv_detail($id, $lc_id);
				$bn_detail = $this->search_bn_detail_sort($id);
				$sql_bn_list = "";
				$sql_inv_list = "";
				$sql_transfer_list = "";
				$error_status = "";
				//                   echo '<pre>';
				// print_r($inv_detail);
				// echo '這是分隔線<br>';
				// print_r($bn_detail);
				// echo '</pre>';//exit;
				if (!empty($bn_detail)) {
					foreach ($bn_detail as $bn_key => $bn_value) {
						$bn_detail_id = $bn_value["bn_detail_id"];
						$bn_no = $bn_value["bn_no"];
						$cargo_id = $bn_value["cargo_id"];
						$cargo_code = $bn_value["cargo_code"];
						$cargo_item_id = $bn_value["cargo_item_id"];
						$item_code = $bn_value["item_code"];
						$item_name = $bn_value["item_name"];
						$item_grade = $bn_value["item_grade"];
						$item_lot = $bn_value["item_lot"];
						$item_sno = $bn_value["item_sno"];
						$item_note = $bn_value["item_note"];
						$item_qty_r = $bn_value["item_qty_r"];
						$bn_mode = $bn_master["bn_mode"];
						$bn_note = $bn_master["bn_note"];
						$update_time = time();
						$update_user = $_SESSION["emp_name"];
						$update_usercode = $_SESSION["emp_code"];
						$update_ip = $_SERVER['REMOTE_ADDR'];
						if ($item_qty_r <= 0) {
							$error_msg .= "單號:" . $bn_no . " 貨品:" . $item_code . " 數量有誤請確認<br>";
							$error_status = true;
						}
						if (!empty($inv_detail)) {
							foreach ($inv_detail as $inv_key => $inv_value) {
								if ($item_qty_r > 0 && $inv_value["stock_qty"] > 0) {
									$status = true;
									$num = 0;
									if (!empty($item_sno)) {
										if ($cargo_id == $inv_value["cargo_id"] and $cargo_item_id == $inv_value["cargo_item_id"] and $item_grade == $inv_value["item_grade"] and $item_sno == $inv_value["item_sno"]) {
											// echo $inv_value["cargo_item_id"].'***<br>';
											list($item_qty_r, $inv_detail[$inv_key]["stock_qty"], $num) = $this->count_inv_num($item_qty_r, $inv_value["stock_qty"]);
										} else {
											$status = false;
										}
									} else {
										if ($cargo_id == $inv_value["cargo_id"] and $cargo_item_id == $inv_value["cargo_item_id"] and $item_grade == $inv_value["item_grade"] and $item_lot == $inv_value["item_lot"] and $inv_value["item_sno"] == "") {
											// echo $inv_value["cargo_item_id"].'+++<br>';
											list($item_qty_r, $inv_detail[$inv_key]["stock_qty"], $num) = $this->count_inv_num($item_qty_r, $inv_value["stock_qty"]);
										} elseif ($cargo_id == $inv_value["cargo_id"] and $cargo_item_id == $inv_value["cargo_item_id"] and $item_grade == $inv_value["item_grade"] and $item_lot == "" and $inv_value["item_sno"] == "") {
											// echo $inv_value["inv_stock_id"].'-'.$inv_value["inv_detail_id"].'-'.$inv_value["cargo_item_id"].'-'.$inv_value["item_lot"].'---<br>';
											list($item_qty_r, $inv_detail[$inv_key]["stock_qty"], $num) = $this->count_inv_num($item_qty_r, $inv_value["stock_qty"]);
										} else {
											$status = false;
										}
									}
									if ($item_sno == $inv_value["item_sno"]) {
										$chk_list01 = $this->chk_inv_stock2($inv_value["cargo_item_id"], $inv_value["item_grade"], $inv_value["cargo_id"], $inv_value["item_sno"], $inv_value["lc_id"]);
										$chk_list02 = $this->chk_item_stock2($inv_value["cargo_item_id"], $inv_value["item_grade"], $inv_value["cargo_id"], $inv_value["item_sno"], $inv_value["lc_id"]);
										// print_r($chk_list01[0]["stock_qty"]);
										// print_r($chk_list02[0]["item_Astock_num"]);
										if ($chk_list01[0]["stock_qty"] <> $chk_list02[0]["item_Astock_num"]) {
											echo $chk_list01[0]["stock_qty"] . '-' . $chk_list02[0]["item_Astock_num"] . '-' . $num . '<br>';
											echo 'SKU:' . $item_code . '<br>';
											$error_msg .= "客戶單號：" . $bn_no . "轉單異常請協助通知IT處理！！！" . "<br>"; //貨品批號不等於帳面庫存
											$status = true;
											$error_status = false;
											$inv_stock_id = $inv_value["inv_stock_id"];
											// $test = $chk_list01[0]["stock_qty"] - $chk_list02[0]["item_Astock_num"];
											$sql_inv_list = "UPDATE inv_stock SET stock_qty = stock_qty - $num WHERE inv_stock_id = $inv_stock_id;";
										}
									} else {
										$status = false;
									}
									if ($status) {
										$inv_stock_id = $inv_value["inv_stock_id"];
										$lc_id = $inv_value["lc_id"];
										$lc_code = $inv_value["lc_code"];
										$lsa_id = $inv_value["lsa_id"];
										$lsa_code = $inv_value["lsa_code"];
										$lss_id = $inv_value["lss_id"];
										$lss_code = $inv_value["lss_code"];
										$inv_lot = $inv_value["item_lot"];
										$inv_sno = $inv_value["item_sno"];
										// 	$sql_inv_list .= "UPDATE inv_stock SET stock_qty = stock_qty - $num WHERE inv_stock_id = $inv_stock_id;";
										$sql_bn_list .= "INSERT INTO bn_detail_lss (bn_master_id,bn_detail_id,inv_stock_id ,bn_no,cargo_id,cargo_code,cargo_item_id,item_code,item_name,item_grade,item_lot,item_sno,item_note,lc_id,lc_code,lsa_id,lsa_code,lss_id,lss_code,item_stock,empname,empno) 
												VALUES ($id,$bn_detail_id,$inv_stock_id,'$bn_no',$cargo_id,'$cargo_code',$cargo_item_id,'$item_code' ,'$item_name',$item_grade,'$inv_lot','$inv_sno','$item_note',$lc_id,'$lc_code','$lsa_id','$lsa_code','$lss_id','$lss_code',$num,'{$update_user}','{$update_usercode}') ON DUPLICATE KEY UPDATE upd_ok = 'Y';";
										echo $sql_bn_list . '<br>';
									}
									// $sql = "select detail_lss_id FROM bn_detail_lss ORDER BY detail_lss_id DESC LIMIT 0 , 1";
									// $test = $GLOBALS['DB']->get_query_result($sql,false);
									// echo $sql.'<br>';
									// echo '<pre>';
									// print_r($test);
									// echo '</pre>';
								}
							}
						}
					}
				}
				if (!$error_status) {
					echo $sql_inv_list . '<br>';
					// sql_multi_query($sql_inv_list);

				}
			}
			echo $error_msg . '<br>';
			$error_msg = '';
		}
		exit;
	}
	function update_item_stock($id)
	{
		$sql = " UPDATE item_stock b INNER JOIN (SELECT *, SUM(item_stock) AS item_qty 
												       		FROM bn_detail_lss 
												       		WHERE bn_master_id = $id 
												       		GROUP BY cargo_item_id, item_grade, lc_id, lsa_id, lss_id, item_sno ) AS a
												       		ON a.cargo_id = b.cargo_id 
												      		AND a.cargo_item_id = b.item_id 
												      		AND a.item_grade = b.item_grade 
												      		AND a.item_sno = b.item_sno 
												      		AND a.lc_id = b.lc_id 
												      		AND a.lsa_id = b.lsa_id 
												      		AND a.lss_id = b.lss_id
										SET b.item_Astock_num = b.item_Astock_num  - a.item_qty,
											b.item_eod_num 	  = b.item_eod_num     + a.item_qty ";
		$GLOBALS['DB']->query($sql);
	}

	function update_bn_master($id)
	{
		$time = time();
		$time_string = date("Y/m/d H:i:s");
		$emp_name = $_SESSION["emp_name"];
		$ip = $_SERVER['REMOTE_ADDR'];

		$sql = "INSERT INTO bn_eod (bn_master_id,bn_no,bn_mode,bn_type,action_type,lc_id,lc_code,cargo_id,cargo_code,ipfrom,createdate,createuser,updatedate,updateuser) SELECT bn_master_id,bn_no,bn_mode,bn_type,action_type,lc_id,lc_code,cargo_id,cargo_code,'$ip',$time,'$emp_name',0,'' FROM bn_master WHERE bn_master_id = $id ";
		$GLOBALS['DB']->query($sql);
		$bn_eod_id = $GLOBALS['DB']->insert_id();

		$sql = "UPDATE bn_master SET bn_eod_id = $bn_eod_id, to_eod = 1, to_eod_date = $time, bn_status_code = '10000', bn_status = '訂單處理中', bn_status_time = '$time', updatedate = $time, updateuser = '$emp_name' WHERE bn_master_id = $id ";
		//echo $sql.'<br>';
		$GLOBALS['DB']->query($sql);
		$sql = "INSERT INTO bn_sod (bn_master_id,bn_status_time,bn_status_code,bn_status,ipfrom,createdate,createuser, sod_note, dispatch_no, vehdrv_name, vehdrv_phone, lc_id, lc_code, bn_sod_dcim_ok, bn_sod_file_name, bn_sod_ftp_year, bn_sod_ftp_ok, bn_pay_file_name, bn_pay_ftp_year, bn_pay_ftp_ok, feedback_cargo, item_S, thermosphere, updatedate, updateuser, status_send) VALUES ($id,'$time_string','10000','訂單處理中','$ip',$time,'$emp_name', '', '', '', '', 0, '', 0, '', '', 0, '', '', 0, 1, 0, '',  0, '', 0) ";
		$GLOBALS['DB']->query($sql);
	}

	function check_bn_stock($id, $bn_detail_id)
	{
		$sql = " SELECT a.bn_no, a.item_code, a.lsa_id, a.lsa_code, a.lss_id, a.lss_code, a.item_grade, a.item_sno ,a.item_qty, IFNULL(b.item_Astock_num,0) AS item_Astock_num, 
												       IFNULL(b.item_Astock_num,0)-a.item_qty AS NowQty FROM 
												       (SELECT *, SUM(item_stock) AS item_qty 
												       		FROM bn_detail_lss 
												       		WHERE bn_detail_id = $bn_detail_id 
												       		GROUP BY cargo_item_id, item_grade, lc_id, lsa_id, lss_id, item_sno ) AS a 
												      	LEFT OUTER JOIN item_stock AS b 
												      					ON a.cargo_id = b.cargo_id 
												      					AND a.cargo_item_id = b.item_id 
												      					AND a.item_grade = b.item_grade 
												      					AND a.item_sno = b.item_sno 
												      					AND a.lc_id = b.lc_id 
												      					AND a.lsa_id = b.lsa_id 
												      					AND a.lss_id = b.lss_id ";
		// echo $sql.'<br>';exit;
		return $GLOBALS['DB']->get_query_result($sql, false);
	}
	function chk_inv_stock($f_var1, $f_var2, $f_var3, $f_var4, $f_var5)
	{
		$sql = " SELECT sum(stock_qty) as stock_qty
						from inv_stock 
						where cargo_item_id = '{$f_var1}'
						and item_grade = '{$f_var2}'
						and cargo_id = '{$f_var3}'
						and item_sno = '{$f_var4}'
						and lc_id = '{$f_var5}'
						and stock_qty > 0 ";
		if ($_SESSION["emp_id"] == '191') {
			// echo $sql . '<br>';
			// echo '<pre>';
			// print_r($sql);
			// echo '</pre>';
			// exit;
		}

		return $GLOBALS['DB']->get_query_result($sql, false);
	}
	function chk_item_stock($f_var1, $f_var2, $f_var3, $f_var4, $f_var5)
	{
		$sql = " SELECT sum(item_Astock_num) as item_Astock_num
						from item_stock
						where item_id = '{$f_var1}'
						and item_grade = '{$f_var2}'
						and cargo_id = '{$f_var3}'
						and item_sno = '{$f_var4}'
						and lc_id = '{$f_var5}'";
		if ($_SESSION["emp_id"] == '191') {
			// echo $sql . '<br>';
			// echo '<pre>';
			// print_r($sql);
			// echo '</pre>';
			// exit;
		}
		return $GLOBALS['DB']->get_query_result($sql, false);
	}
	function chk_inv_stock2($f_var1, $f_var2, $f_var3, $f_var4, $f_var5)
	{
		$sql = " SELECT sum(stock_qty) as stock_qty
						from inv_stock 
						where cargo_item_id = '{$f_var1}'
						and item_grade = '{$f_var2}'
						and cargo_id = '{$f_var3}'
						and item_sno = '{$f_var4}'
						and lc_id = '{$f_var5}'
						and stock_qty > 0 ";

		return $GLOBALS['DB']->get_query_result($sql, false);
	}
	function chk_item_stock2($f_var1, $f_var2, $f_var3, $f_var4, $f_var5)
	{
		$sql = " SELECT sum(item_Astock_num) as item_Astock_num
						from item_stock
						where item_id = '{$f_var1}'
						and item_grade = '{$f_var2}'
						and cargo_id = '{$f_var3}'
						and item_sno = '{$f_var4}'
						and lc_id = '{$f_var5}'";

		return $GLOBALS['DB']->get_query_result($sql, false);
	}
	function chk_cargo_item_bn_detail($f_var1)
	{
		$sql = " SELECT * FROM cargo_item as a 
						left join bn_detail as b 
						on a.item_code = b.item_code 
						and a.cargo_id = b.cargo_id 
						and a.cargo_item_id = b.cargo_item_id
						where b.bn_master_id = '{$f_var1}' ";
		//echo $sql.'<br>';
		return $GLOBALS['DB']->get_query_result($sql, false);
	}

	function bn_inv_detail($id, $lc_id)
	{
		$sql = "SELECT DISTINCT b.* FROM (
			SELECT cargo_id, cargo_item_id, item_qty_r, item_grade, item_lot, item_sno 
			FROM bn_detail WHERE bn_master_id = $id 
			GROUP BY cargo_item_id, item_grade, item_lot, item_sno) AS a 
			INNER JOIN inv_stock AS b ON a.cargo_id = b.cargo_id 
			AND a.cargo_item_id = b.cargo_item_id 
			AND a.item_grade = b.item_grade 
			WHERE b.lc_id = $lc_id AND b.stock_qty > 0 ORDER BY b.item_lot, b.inv_detail_id, b.inv_stock_id";
		// echo $sql . '<br>';
		// exit();
		return $GLOBALS['DB']->get_query_result($sql, false);
	}

	function count_inv_num($bn_qty, $lss_qty)
	{
		$num = 0;
		if ($bn_qty <= $lss_qty) {
			$lss_qty = $lss_qty - $bn_qty;
			$num = $bn_qty;
			$bn_qty = 0;
		} elseif ($bn_qty > $lss_qty) {
			$bn_qty = $bn_qty - $lss_qty;
			$num = $lss_qty;
			$lss_qty = 0;
		}
		return array($bn_qty, $lss_qty, $num);
	}

	function search_bn_status($id)
	{
		$sql = "SELECT * FROM bn_sod WHERE bn_master_id = $id ORDER BY  bn_sod_id DESC, createdate";
		return $GLOBALS["DB"]->get_query_result($sql, false);
	}

	function transfer_order_nostock($data)
	{
		$error_status = '';
		$error_msg = '';
		foreach ($data["bn_master_id"] as $id_key => $id) {
			//$this -> update_item_box($id);
			$bn_master = $this->search_bn($id);
			// if ($_SESSION["emp_id"] == '191') {
			// 	// echo $sql . '<br>';
			// 	echo '<pre>';
			// 	print_r($bn_master);
			// 	echo '</pre>';
			// 	exit;
			// }
			if ($bn_master["to_eod"] == 0 && $bn_master["to_eod_date"] == 0) {
				$chk_list = $this->chk_cargo_item_bn_detail($bn_master["bn_master_id"]);
				if (empty($chk_list)) {
					$error_msg = "客戶單號：" . $id . "，貨品尚未建立，請先建立貨品資料！！！" . "<br>"; //api來源貨品代號不存在物料基本檔
					$error_status = true;
				}
				if (!$error_status) {
					if ($bn_master["bn_box"] > 0) {
						$this->update_bn_master($id);
					} else {
						$error_msg .= "單號:" . $bn_master["bn_no"] . " 沒有貨品無法轉單<br>";
					}
				}
			} else {
				$error_msg .= "單號:" . $bn_master["bn_no"] . " 已轉單請確認!<br>";
				$error_status = true;
			}
		}
		return $error_msg;
	}

	function bn_cancel_list($data,  $page = 1, $num_per_page = 10)
	{
		$clause = "WHERE 1=1  ";
		$start   = ($page - 1) * $num_per_page;


		if (!empty($data["cargo_code"])) {
			$cargo_code = trim($data["cargo_code"]);
			$clause .= " AND cargo_code LIKE '$cargo_code%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}
		$date_start = '';
		$date_start = strtotime(trim(date("Ymd", strtotime("-1 day"))) . " 00:00:00");
		if (!empty($data["date_start"])) {
			$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
			$clause .= " AND createdate >= $date_start ";
		}
		$date_end = '';
		$date_end = strtotime(trim(date("Ymd", time())) . " 00:00:00");
		if (!empty($data["date_end"])) {
			$date_end = strtotime(trim($data["date_end"]) . " 00:00:00");
			$clause .= " AND createdate <= $date_end ";
		}

		// $lc_code = trim($GLOBALS["lc_code"]);
		// if (!empty($lc_code)) {
		// 	$clause .= " AND lc_code = '$lc_code' ";
		// }

		$sql = "SELECT * FROM bn_master $clause ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function cancel_bn($data)
	{
		$time = time();
		$time_string = date("Y/m/d H:i:s");
		$emp_name = $_SESSION["emp_name"];
		$ip = $_SERVER['REMOTE_ADDR'];
		$bn_master = $this->search_bn((int)$data["id"]);
		if (!empty($bn_master)) {

			$edi_id = $bn_master["bn_master_id"];
			$bn_eod_id = $bn_master["bn_eod_id"];

			$sql = "UPDATE bn_master SET bn_type = 8, bn_status_code = '10025', bn_status = '訂單取消', dispatch_no = '', vehdrv_name = '', vehdrv_phone = '', pickup_no = '', bn_status_time = $time, updatedate = $time, updateuser = '$emp_name' WHERE bn_master_id = $edi_id ";
			$GLOBALS['DB']->query($sql);

			if ($bn_master["bn_no_cardno"] == 0) {
				$sql = "UPDATE bn_master SET  bn_leave_time = $time WHERE bn_master_id = $edi_id ";
				$GLOBALS['DB']->query($sql);
			}

			$sql = "UPDATE bn_eod SET bn_type = 8, updatedate = $time, updateuser = '$emp_name' WHERE bn_eod_id = $bn_eod_id";
			$GLOBALS['DB']->query($sql);
			$sql = "INSERT INTO bn_sod (bn_master_id,bn_status_time,bn_status_code,bn_status,ipfrom,createdate,createuser,sod_note, dispatch_no, vehdrv_name, vehdrv_phone, lc_id, lc_code, bn_sod_dcim_ok, bn_sod_file_name, bn_sod_ftp_year, bn_sod_ftp_ok, bn_pay_file_name, bn_pay_ftp_year, bn_pay_ftp_ok, feedback_cargo, item_S, thermosphere, updatedate, updateuser, status_send) VALUES ($edi_id,'$time_string','10025','訂單取消','$ip',$time,'$emp_name','','','','',0,'',0,'','',0,'','',0,1,0,'',0,'',0)";
			$GLOBALS['DB']->query($sql);
		}
	}

	function complete_check($id)
	{
		if ($id > 0) {

			$sql = "SELECT bn_mode,bn_leave_time FROM bn_master WHERE bn_master_id = $id AND bn_mode = 1";
			$bn_master_leave = $GLOBALS['DB']->get_query_result($sql, true);

			// if( empty($_SESSION["emp_name"]) ){
			// 	echo "<script>alert('系統錯誤，請聯繫系統管理員'); location.href = 'bn_edi_list.php';</script>";
			// 	break;
			// }

			if (!empty($bn_master_leave["bn_leave_time"]) || $bn_master_leave["bn_leave_time"] > 0) {
				// update_stock($id);
				update_stock_delivery($id);
			}

			$time = time();
			$time_string = date("Y/m/d H:i:s");
			$emp_name = $_SESSION["emp_name"];
			$ip = $_SERVER['REMOTE_ADDR'];
			$sql = "UPDATE bn_master SET bn_type = 3, bn_status_code = '10004', bn_status = '配完', bn_status_time = $time, updatedate = $time, updateuser = '$emp_name', bn_arrival_time =  '$time' WHERE bn_master_id = $id ";
			$GLOBALS['DB']->query($sql);
			$sql = "INSERT INTO bn_sod (bn_master_id,bn_status_time,bn_status_code,bn_status,ipfrom,createdate,createuser,sod_note, dispatch_no, vehdrv_name, vehdrv_phone, lc_id, lc_code, bn_sod_dcim_ok, bn_sod_file_name, bn_sod_ftp_year, bn_sod_ftp_ok, bn_pay_file_name, bn_pay_ftp_year, bn_pay_ftp_ok, feedback_cargo, item_S, thermosphere, updatedate, updateuser, status_send) VALUES ($id,'$time_string','10004','配完','$ip',$time,'$emp_name','','','','',0,'',0,'','',0,'','',0,1,0,'',0,'',0)";
			$GLOBALS['DB']->query($sql);

			$this->update_dispatch_status($id);
		}
	}

	function complete_check_nostock($id)
	{
		if ($id > 0) {
			$time = time();
			$time_string = date("Y/m/d H:i:s");
			$emp_name = $_SESSION["emp_name"];
			$ip = $_SERVER['REMOTE_ADDR'];
			$sql = "UPDATE bn_master SET bn_type = 3, bn_status_code = '10004', bn_status = '配完', bn_status_time = $time, updatedate = $time, updateuser = '$emp_name', bn_leave_time = '$time', bn_arrival_time =  '$time' WHERE bn_master_id = $id ";
			$GLOBALS['DB']->query($sql);
			$sql = "INSERT INTO bn_sod (bn_master_id,bn_status_time,bn_status_code,bn_status,ipfrom,createdate,createuser) VALUES ($id,'$time_string','10004','配完','$ip',$time,'$emp_name')";
			$GLOBALS['DB']->query($sql);

			$this->update_dispatch_status($id);
		}
	}

	function update_item_box($bn_id)
	{
		$bn_detail = $this->search_bn_detail($bn_id);
		if (!empty($bn_detail)) {
			$bn_id = "";
			$bn_id = $bn_detail["bn_master_id"];
			$item_qty = 0;
			$total_V = 0;
			$total_K = 0;
			$total_S = 0;
			$total_Box = 0;
			foreach ($bn_detail as $key => $value) {
				$item = search_cargo_item_code($value["cargo_id"], $value["item_code"]);
				$item_V = $item["item_V"];
				$item_K = $item["item_K"];
				$item_S = $item["item_S"];

				$detail_id = $value["bn_detail_id"];

				$bn_id = $value["bn_master_id"];
				$item_qty = $value["item_qty_r"];
				$total_V += ($item_V * $item_qty);
				$total_K += ($item_K * $item_qty);
				$total_S += ($item_S * $item_qty);
				$total_Box += $item_qty;

				$sql = "UPDATE bn_detail SET item_V = $item_V, item_K = $item_K, item_S = $item_S WHERE bn_detail_id = $detail_id ";
				$GLOBALS['DB']->query($sql);
			}
			$sql = "UPDATE bn_master SET bn_box = $total_Box, bn_volume = " . round($total_V, 2) . ", bn_size = $total_S, bn_kg = $total_K   WHERE bn_master_id = $bn_id";
			$GLOBALS['DB']->query($sql);
		}
	}

	function update_dispatch_status($id)
	{
		$bn_no = $this->search_bn($id);
		$pickup_no = $bn_no['pickup_no'];
		$sql = "SELECT COUNT(1) as total_bn FROM bn_master WHERE pickup_no = '$pickup_no' AND bn_status_code != '10004'";
		$num = $GLOBALS['DB']->get_query_result($sql, true);
		if ($num["total_bn"] == 0) {
			$sql = "UPDATE dispatch_master SET dispatch_status = 5 WHERE dispatch_no = '$pickup_no'";
			$GLOBALS['DB']->query($sql);
		}
	}

	function print_log($data)
	{
		if (!empty($data["bn_no"])) {
			$bn_no = $data["bn_no"];
		}
		$type = $data["type"];



		$update_time = date("YmdHis");
		$update_user = $_SESSION["emp_name"];
		$update_ip = $_SERVER['REMOTE_ADDR'];

		switch ($type) {
			case 1: //送貨單
				$bo_list = explode(",", $bn_no);
				foreach ($bo_list as $key => $value) {
					if (!empty($value)) {
						$bn_master = $this->search_bn($value);
						$no = $bn_master["bn_no"];
						$cargo_code = $bn_master["cargo_code"];
						$bn_master_id = $bn_master["bn_master_id"];

						$sql = "INSERT INTO bn_print_log (type,no,cargo_code,count,print_user,print_time,print_ip) VALUES (1,'$no','$cargo_code',1,'$update_user','$update_time','$update_ip')";
						$GLOBALS['DB']->query($sql);

						$sql = "UPDATE bn_master SET bn_print = 1 WHERE bn_master_id = '$bn_master_id'";
						$GLOBALS['DB']->query($sql);
					}
				}
				break;
			case 2: //派車單
				$sql = "INSERT INTO bn_print_log (type,no,cargo_code,count,print_user,print_time,print_ip) VALUES (2,'$bn_no','',1,'$update_user','$update_time','$update_ip')";
				$GLOBALS['DB']->query($sql);

				$sql = "UPDATE dispatch_master SET dispatch_status = 2 WHERE dispatch_no = '$bn_no' AND dispatch_status <= 1 ";
				$GLOBALS['DB']->query($sql);
				break;
			case 3: //派車單
				$sql = "INSERT INTO bn_print_log (type,no,cargo_code,count,print_user,print_time,print_ip) VALUES (3,'$bn_no','',1,'$update_user','$update_time','$update_ip')";
				$GLOBALS['DB']->query($sql);

				$sql = "UPDATE dispatch_master SET dispatch_status = 2 WHERE dispatch_no = '$bn_no' AND dispatch_status <= 1 ";
				$GLOBALS['DB']->query($sql);
				break;
			case 4: //MOMO標籤列印
				$recycle4No = $data["recycle4No"];
				$machine_list = explode(",", $recycle4No);
				foreach ($machine_list as $key => $value) {
					if (!empty($value)) {
						$search_momo = $this->search_momo_machine($value);
						$recycle4No = $search_momo["recycle4No"];

						$sql = "INSERT INTO bn_print_log (type,no,cargo_code,count,print_user,print_time,print_ip) VALUES (4,'$recycle4No','MOMO',1,'$update_user','$update_time','$update_ip')";
						$GLOBALS['DB']->query($sql);


						$sql = "UPDATE api_momo_machine_data SET print = 1 WHERE recycle4No = '$recycle4No' AND print = 0";
						$GLOBALS['DB']->query($sql);
					}
				}

				break;
		}
	}

	function fine_edit($data)
	{
		$id = (int)$data["id"];
		$bn_type = (int)$data["bn_type"];

		$bn_charge = (int)$data["bn_charge"];
		$deliver_name = htmlspecialchars(trim($data["deliver_name"]));
		$deliver_phone = htmlspecialchars(trim($data["deliver_phone"])); //市話
		$deliver_phone_2 = htmlspecialchars(trim($data["deliver_phone_2"])); //分機
		$deliver_phone2 = htmlspecialchars(trim($data["deliver_phone2"])); //手機
		$deliver_zip = htmlspecialchars(trim($data["deliver_zip"]));
		$deliver_addr = htmlspecialchars(trim($data["deliver_addr"]));
		$receiver_name = htmlspecialchars(trim($data["receiver_name"]));
		$receiver_phone = htmlspecialchars(trim($data["receiver_phone"])); //市話
		$receiver_phone_2 = htmlspecialchars(trim($data["receiver_phone_2"])); //分機
		$receiver_phone2 = htmlspecialchars(trim($data["receiver_phone2"])); //手機
		$receiver_zip = htmlspecialchars(trim($data["receiver_zip"]));
		$receiver_addr = htmlspecialchars(trim($data["receiver_addr"]));
		$self_carr = htmlspecialchars(trim($data["self_carr"]));

		$action_type = (int)$data["action_type"];

		$bn_status_code = $data["bn_status_code"];

		$eod_id = (int)$data["bn_eod_id"];

		if ($self_carr == "Y" && $bn_type == 2) {
			$bn_type = 9;
			if ($eod_id > 0) {
				$sql = "UPDATE bn_eod SET bn_type = $bn_type WHERE bn_eod_id = $eod_id ";
				$GLOBALS['DB']->query($sql);
			}

			if ($bn_status_code == '10011') {
				$sql = "UPDATE arrival_bn SET bn_type = $bn_type WHERE bn_master_id = $id AND bn_check = 1 ";
				$GLOBALS['DB']->query($sql);
			}
		} elseif ($bn_type == 9 && $self_carr == "N") {
			$bn_type = 2;
			if ($eod_id > 0) {
				$sql = "UPDATE bn_eod SET bn_type = $bn_type WHERE bn_eod_id = $eod_id ";
				$GLOBALS['DB']->query($sql);
			}
		}

		$bn_delivery_charge = "N";
		if ($bn_charge > 0) {
			$bn_delivery_charge = "Y";
		}

		$deliver_setup = (int)$data["deliver_setup"];
		$bn_note = htmlspecialchars(trim($data["bn_note"]));

		$time = time();
		$emp_name = $_SESSION["emp_name"];

		$sql = "UPDATE bn_master SET 
								bn_type = $bn_type,
								action_type = $action_type,
								bn_delivery_charge = '$bn_delivery_charge',
								bn_charge = $bn_charge,
								bn_deliver_name = '$deliver_name',
								bn_deliver_phone = '$deliver_phone',
								bn_deliver_phone_2 = '$deliver_phone_2',
								bn_deliver_phone2 = '$deliver_phone2',
								bn_deliver_zip = '$deliver_zip',
								bn_deliver_addr = '$deliver_addr',
								bn_receiver_name = '$receiver_name',
								bn_receiver_phone = '$receiver_phone',
								bn_receiver_phone_2 = '$receiver_phone_2',
								bn_receiver_phone2 = '$receiver_phone2',
								bn_receiver_zip = '$receiver_zip',
								bn_receiver_addr = '$receiver_addr',
								self_carr = '$self_carr',
								deliver_setup = $deliver_setup,
								bn_note = '$bn_note',
								updatedate = '$time',
								updateuser = '$emp_name'
						 WHERE bn_master_id = $id";
		$GLOBALS['DB']->query($sql);
	}

	function update_itemV($id)
	{
		if ($id > 0) {
			$bn_detail = $this->search_bn_detail($id);
			if (!empty($bn_detail)) {
				$total_item_qty = 0;
				$total_item_V = 0;
				$total_item_K = 0;
				$total_item_S = 0;

				foreach ($bn_detail as $key => $value) {
					$item = search_cargo_item_code2($value["cargo_code"], $value["item_code"]);
					$item_V = $item["item_V"];
					$item_K = $item["item_K"];
					$item_S = $item["item_S"];

					$total_item_qty += $value["item_qty_r"];
					$total_item_V += ($item_V * $value["item_qty_r"]);
					$total_item_K += ($item_K * $value["item_qty_r"]);
					$total_item_S += ($item_S * $value["item_qty_r"]);

					$item_name = $item["item_name"];
					$item_model = $item["item_model"];

					$detail_id = $value["bn_detail_id"];

					$sno_flag = (int)$item["sno_flag"];

					$sql = "UPDATE bn_detail SET item_V = $item_V, item_K = $item_K, item_S = $item_S, sno_flag = $sno_flag WHERE bn_detail_id = $detail_id "; //, item_name = '$item_name', item_model = '$item_model'
					$GLOBALS['DB']->query($sql);
				}
				$sql = "UPDATE bn_master SET bn_box = $total_item_qty, bn_volume = '$total_item_V', bn_size = $total_item_S, bn_kg = $total_item_K WHERE bn_master_id = $id ";
				$GLOBALS['DB']->query($sql);
			}
		}
	}

	function update_itemV_delivery_fee($id)
	{
		if ($id > 0) {
			$bn_detail = $this->search_bn_detail($id);
			if (!empty($bn_detail)) {
				$total_item_qty = 0;
				$total_item_V = 0;
				$total_item_K = 0;
				$total_item_S = 0;

				foreach ($bn_detail as $key => $value) {
					$item = search_cargo_item_code($value["cargo_id"], $value["item_code"]);
					$item_V = $item["item_V"];
					$item_K = $item["item_K"];
					$item_S = $item["item_S"];

					$total_item_qty += $value["item_qty_r"];
					$total_item_V += ($item_V * $value["item_qty_r"]);
					$total_item_K += ($item_K * $value["item_qty_r"]);
					$total_item_S += ($item_S * $value["item_qty_r"]);
					$detail_id = $value["bn_detail_id"];
					$sql = "UPDATE bn_detail SET item_V = $item_V, item_K = $item_K, item_S = $item_S WHERE bn_detail_id = $detail_id ";
					$GLOBALS['DB']->query($sql);
				}
				$sql = "UPDATE bn_master SET bn_box = $total_item_qty, bn_volume = '$total_item_V', bn_size = $total_item_S, bn_kg = $total_item_K WHERE bn_master_id = $id ";
				$GLOBALS['DB']->query($sql);

				$sql = "UPDATE delivery_fee SET bn_box = $total_item_qty, bn_volume = '$total_item_V' WHERE bn_master_id = $id ";
				$GLOBALS['DB']->query($sql);
			}
		}
	}

	function Action_overprint_list($data,  $page = 1, $num_per_page = 10)
	{
		$lc_code = $GLOBALS["lc_code"];
		$start   = ($page - 1) * $num_per_page;

		$sql = "SELECT bn_distance, COUNT(1) AS num FROM bn_master WHERE cargo_code = 'ACTION' AND to_eod = 0 AND lc_code = '$lc_code' AND bn_mode != 2 AND bn_distance != 'A6' GROUP BY bn_distance ";

		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT * FROM bn_master WHERE cargo_code = 'ACTION' AND to_eod = 0 AND lc_code = '$lc_code' LIMIT $start, $num_per_page";
		$result1 = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master WHERE cargo_code = 'ACTION' AND to_eod = 0 AND lc_code = '$lc_code' AND bn_distance != 'A6'";
		$result2 = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $result1, $result2["num"]);
	}
	// **************************************************************************
	//  函數名稱: Action_overprint_transfer_order('單別','程式名稱')
	//  函數功能: 
	//  使用方式:$type 2碼+url
	//type參數A1.出貨單/A2.調撥單/A4.交換品出貨單/A5.交換品入倉單/R1.出貨單/R2.調撥單/R4.交換品出貨單/R5.交換品入倉單
	//  備    註: 憶聲送貨單套印
	//  程式設計: 周小樵
	//  設計日期: 2022.04.15
	// **************************************************************************
	function Action_overprint_transfer_order($type, $type2)
	{
		$lc_code = $GLOBALS["lc_code"];
		$lc_id = $GLOBALS["lc_id"];
		$error_msg = "";
		$id_list = array();
		$id_str = "";
		$id_str_print = "";
		$b_date = date("Y-m-d H:i:s");
		$mfromip  = $_SERVER["REMOTE_ADDR"]; // 建檔 IP
		//echo '<pre>';
		//print_r($type2);
		//print_r($_SESSION);
		//print_r($type);
		//echo '</pre>';
		// exit;
		if (!empty($type) && !empty($lc_code)) {
			if ($type == "A1" || $type == "A2" || $type == "A4" || $type == "R1" || $type == "R2" || $type == "R4") {
				$sql = "SELECT bn_master_id FROM bn_master WHERE cargo_code = 'ACTION' AND bn_type != 8 AND to_eod = 0 AND lc_code = '$lc_code' AND bn_distance = '$type' AND bn_mode = 1 ";
			} elseif ($type == "A5" || $type == "R5") {
				$sql = "SELECT bn_master_id FROM bn_master WHERE cargo_code = 'ACTION' AND bn_type != 8 AND to_eod = 0 AND lc_code = '$lc_code' AND bn_distance = '$type' AND bn_mode != 1 ";
			}
			// echo $sql.'<br>';
			$result = $GLOBALS['DB']->get_query_result($sql, false);

			// echo '213';
			// exit;


			if (!empty($result)) {
				foreach ($result as $key => $value) {
					$id_list["bn_master_id"][$key] = $value["bn_master_id"];
					$id_str .= $value["bn_master_id"];
					if (!empty($result[$key + 1])) {
						$id_str .= ",";
					}
				}
			}

			// echo '<pre>';
			// print_r($id_str);
			// echo '</pre>';
			// exit;

			// echo '<pre>';
			// print_r($id_str);
			// echo '</pre>';
			// exit;

			if (!empty($id_str)) {
				if ($type == "A1" || $type == "A2" || $type == "A4" || $type == "R1" || $type == "R2" || $type == "R4") {
					$error_msg = $this->transfer_order($id_list);
				} elseif ($type == "A5" || $type == "R5") {
					$error_msg = $this->transfer_order_nostock($id_list);
				}
			}
			// echo '<pre>';
			// print_r($error_msg);
			// echo '</pre>';
			// exit;
			if ($type == "A1" || $type == "A2" || $type == "A4" || $type == "R1" || $type == "R2" || $type == "R4") {
				$sql = "SELECT bn_master_id FROM bn_master WHERE cargo_code = 'ACTION' AND bn_type != 8 AND to_eod = 1 AND lc_code = '$lc_code' AND bn_distance = '$type' AND bn_master_id IN ($id_str) AND bn_mode = 1 ";
			} elseif ($type == "A5" || $type == "R5") {
				$sql = "SELECT bn_master_id FROM bn_master WHERE cargo_code = 'ACTION' AND bn_type != 8 AND to_eod = 1 AND lc_code = '$lc_code' AND bn_distance = '$type' AND bn_master_id IN ($id_str) AND bn_mode != 1 ";
			}
			//echo '<pre>';
			//print_r($sql);
			//echo '</pre>';
			$result = $GLOBALS['DB']->get_query_result($sql, false);
			if (!empty($result)) {
				foreach ($result as $key => $value) {
					$id_str_print .= $value["bn_master_id"];
					if (!empty($result[$key + 1])) {
						$id_str_print .= ",";
					}
				}
			}
			//echo '<pre>';
			//print_r($id_str_print);
			//echo '</pre>';		exit;	
			$sql = 'INSERT INTO action_log(code,t_table,sql_str,str,b_empno,b_name,createdate,ip) VALUES ("' . $type2 . '","bn_master","' . $sql . '","' . $id_str_print . '","' . $_SESSION['emp_code'] . '","' . $_SESSION['emp_name'] . '","' . $b_date . '","' . $mfromip . '")';
			$GLOBALS['DB']->query($sql);
			$id_test = str_replace(",", "','", $id_str_print);
			$sql1 = "select empno FROM bn_detail_lss where bn_master_id in ('{$id_test}') group by empno order by detail_lss_id";
			$result1 = $GLOBALS['DB']->get_query_result($sql1, false);
			//    $num1 = $result1->num_rows;
			if (count($result1) > 1) {
				$sql_upd = "UPDATE bn_detail_lss SET empno = '{$_SESSION['emp_code']}',empname = '{$_SESSION['emp_name']}'  WHERE bn_master_id in ('{$id_str_print}') and empno <> '{$_SESSION['emp_code']}'";
				$GLOBALS['DB']->query($sql_upd);
				$error_msg = 'NG';
				$id_str_print = '';
			}
		}
		return array($id_str_print, $error_msg);
	}

	function bn_overprint_list($data,  $page = 1, $num_per_page = 10)
	{
		$lc_code = $GLOBALS["lc_code"];
		$cargo_code = $data["cargo_code"];
		$start   = ($page - 1) * $num_per_page;

		if (!empty($cargo_code)) {

			$sql = "SELECT bn_distance, COUNT(1) AS num FROM bn_master WHERE cargo_code = '$cargo_code' AND to_eod = 0 AND lc_code = '$lc_code' GROUP BY bn_distance ";
			$result = $GLOBALS['DB']->get_query_result($sql, false);

			$sql = "SELECT * FROM bn_master WHERE cargo_code = '$cargo_code' AND to_eod = 0 AND lc_code = '$lc_code' LIMIT $start, $num_per_page";
			$result1 = $GLOBALS['DB']->get_query_result($sql, false);

			$sql = "SELECT count(1) as num FROM bn_master WHERE cargo_code = '$cargo_code' AND to_eod = 0 AND lc_code = '$lc_code' ";
			$result2 = $GLOBALS['DB']->get_query_result($sql, true);

			return array($result, $result1, $result2["num"]);
		}
	}


	function bn_not_leave_list($data,  $page = 1, $num_per_page = 10)
	{
		$clause = "WHERE 1=1 AND bn_mode = 1 AND bn_leave_time <= 0 AND to_eod = 1 AND bn_type != '3' ";
		$start   = ($page - 1) * $num_per_page;


		if (!empty($data["cargo_code"])) {
			$cargo_code = trim($data["cargo_code"]);
			$clause .= " AND a.cargo_code LIKE '$cargo_code%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["item_code"])) {
			$item_code = trim($data["item_code"]);
			$clause .= " AND b.item_code LIKE '%$item_code%' ";
		}


		if (!empty($GLOBALS["lc_code"])) {
			$lc_code = trim($GLOBALS["lc_code"]);
			$clause .= " AND a.lc_code = '$lc_code' ";
		}

		$sql = "SELECT a.*,b.* FROM bn_master AS a RIGHT JOIN bn_detail AS b ON a.bn_master_id = b.bn_master_id $clause ORDER BY a.createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master AS a RIGHT JOIN bn_detail AS b ON a.bn_master_id = b.bn_master_id $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function search_eod($bn_master_id)
	{
		$sql = "SELECT * FROM bn_eod WHERE bn_master_id = $bn_master_id ORDER BY bn_eod_id DESC";
		return $GLOBALS['DB']->get_query_result($sql, false);
	}

	function bn_sno_list($data,  $page = 1, $num_per_page = 10)
	{
		$clause = "WHERE 1=1 ";
		$start   = ($page - 1) * $num_per_page;


		if (!empty($data["cargo_code"])) {
			$cargo_code = trim($data["cargo_code"]);
			$clause .= " AND cargoo_code LIKE '$cargo_code%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["sno"])) {
			$sno = trim($data["sno"]);
			$clause .= " AND sno LIKE '%$sno%' ";
		}


		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND createdate >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND createdate <= $date_end ";
		}

		$sql = "SELECT * FROM cargo_bn_edi_sno $clause ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM cargo_bn_edi_sno $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}


	function create_sno($data)
	{
		$cargo_code	= strtoupper($data['cargo_code']);
		$bn_no		= strtoupper($data['bn_no']);
		$item_code  = strtoupper($data['item_code']);
		$sno 		= strtoupper($data['sno']);
		$lc_code 		= $GLOBALS['lc_code'];
		$edi_item_note 		= strtoupper($data['edi_item_note']);
		$ipfrom = urlencode($_SERVER["REMOTE_ADDR"]);

		$item = search_cargo_item_code2($cargo_code, $item_code);
		$item_name = $item["item_name"];
		$createuser = $_SESSION["emp_name"];

		$sql = "SELECT COUNT(1) AS total_num FROM cargo_bn_edi_sno WHERE bn_no = '$bn_no' AND item_code = '$item_code' AND sno = '$sno'";
		$sno_result = $GLOBALS['DB']->get_query_result($sql, true);

		if ($sno_result["total_num"] > 0) //訂單重複
		{
			echo "<script>alert('警告：機號重複');</script>";
		} else {

			if (!empty($cargo_code) && !empty($bn_no) && !empty($item_code) && !empty($sno) && !empty($item_name)) {
				$sql = "INSERT INTO cargo_bn_edi_sno (
									        cargoo_code,
									        lc_code,
									        bn_no,
									        item_code,
									        item_name,
									        ipfrom,
									        sno,
									        edi_item_note,
									        createdate,
									        createuser,
									        updatedate,
									        updateuser
					        			) VALUES (
					        				'" . $cargo_code . "' ,
					        				'" . $lc_code . "' ,
					        				'" . $bn_no . "' ,
					        				'" . $item_code . "' ,
					        				'" . $item_name . "' ,
					        				'" . $ipfrom . "' ,
					        				'" . $sno . "',
					        				'" . $edi_item_note . "',
					        				'" . time() . "' ,
					        				'" . $createuser . "',
					        				0,
					        				'')";
				$GLOBALS['DB']->query($sql);

				if ($cargo_code == 'MINJAN_BENQ') {
					$sql = "UPDATE bn_master SET action_api_data = 0 WHERE bn_no = '$bn_no' AND cargo_code ='MINJAN_BENQ' ";
					$GLOBALS['DB']->query($sql);
				}
			}
		}
	}

	function delete_sno($id)
	{
		$GLOBALS['DB']->query("DELETE FROM cargo_bn_edi_sno WHERE id = $id ");
	}

	function delete_inv_sno($id)
	{
		$GLOBALS['DB']->query("DELETE FROM inv_sno WHERE po_id = $id ");
	}


	function edit_sno($data)
	{
		$id =  (int)$data['edit_id'];
		$bn_no		= strtoupper($data['saerch_no']);
		$cargo_code	= $data['cargo_code'];
		$item_code  = strtoupper($data['item_code']);
		$sno 		= strtoupper($data['sno']);
		$edi_item_note 		= strtoupper($data['edi_item_note']);
		$item = search_cargo_item_code2($cargo_code, $item_code);
		$item_name = $item["item_name"];
		$updateuser = $_SESSION["emp_name"];
		$update_time = time();

		// echo $sql = "SELECT COUNT(1) AS total_num FROM cargo_bn_edi_sno WHERE bn_no = '$bn_no' AND item_code = '$item_code' AND sno = '$sno'";
		// $sno_result = $GLOBALS['DB']->get_query_result($sql,true);
		// exit();

		// if($sno_result["total_num"] > 0)//訂單重複
		// {				
		// 	echo "<script>alert('警告：機號重複');</script>";
		// }else{

		if (!empty($item_code) && !empty($sno) && !empty($item_name) && $id > 0) {
			$sql = "UPDATE cargo_bn_edi_sno SET item_code = '$item_code', item_name = '$item_name', sno = '$sno', edi_item_note = '$edi_item_note' ,updatedate = '$update_time', updateuser = '$updateuser' WHERE id = $id ";
			$GLOBALS['DB']->query($sql);

			if ($cargo_code == 'MINJAN_BENQ') {
				$sql = "UPDATE bn_master SET action_api_data = 0 WHERE bn_no = '$bn_no' AND cargo_code ='MINJAN_BENQ' ";
				$GLOBALS['DB']->query($sql);
			}
		}
		// }
	}

	function bn_machine_list($data,  $page = 1, $num_per_page = 10)
	{
		$clause = "WHERE 1=1 ";
		$start   = ($page - 1) * $num_per_page;


		if (!empty($data["cargo_code"])) {
			$cargo_code = trim($data["cargo_code"]);
			$clause .= " AND cargoo_code LIKE '$cargo_code%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["machine_recycle"])) {
			$machine_recycle = trim($data["machine_recycle"]);
			$clause .= " AND machine_recycle LIKE '%$machine_recycle%' ";
		}


		if (!empty($data["machine_check"])) {
			$machine_check = trim($data["machine_check"]);
			$clause .= " AND machine_check LIKE '%$machine_check%' ";
		}

		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}

		if (!empty($data["date_start"])) {
			$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
			$clause .= " AND createdate >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}

		if (!empty($data["date_end"])) {
			$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
			$clause .= " AND createdate <= $date_end ";
		}

		$sql = "SELECT * FROM cargo_bn_machine $clause ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM cargo_bn_machine $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function search_bnno($data)
	{
		$bn_no		= trim($data['create_bn_no']);
		$sql = "SELECT bn_no,cargo_code FROM bn_master WHERE bn_no = '$bn_no'";
		return $GLOBALS['DB']->get_query_result($sql, false);
	}

	function create_machine($data)
	{

		if (!empty($data['cargo_code'])) {
			$cargo_code = strtoupper($data['cargo_code']);
		} else {
			$cargo_code = '';
		}
		$bn_no		= strtoupper($data['bn_no']);
		$machine_recycle  = strtoupper(trim($data['machine_recycle']));
		$machine_check 		= strtoupper($data['machine_check']);
		$ipfrom = urlencode($_SERVER["REMOTE_ADDR"]);
		$createuser = $_SESSION["emp_name"];
		if (!empty($_SESSION["lc_id"])) {
			$lc_code	= $_SESSION["lc_id"];
		} else {
			$lc_code = '';
		}

		$sql = "SELECT bn_no,cargo_code FROM bn_master WHERE bn_no = '$bn_no'";
		$bn_cargo = $GLOBALS['DB']->get_query_result($sql, true);
		$cargo_code = $bn_cargo['cargo_code'];

		$sql = "SELECT COUNT(1) AS total_num FROM cargo_bn_machine WHERE machine_recycle = '$machine_recycle'";
		$machine_result = $GLOBALS['DB']->get_query_result($sql, true);

		// 231006解開重複註解，by 梓誠
		if ($machine_result["total_num"] > 0) //訂單重複
		{
			echo "<script>alert('警告：廢四機號重複');</script>";

			// 以上註解，230717 by hao
		} elseif (empty($bn_cargo)) {
			echo "<script>alert('警告：WMS中無此單號請重新輸入!');</script>";
			// return $msg = 'WMS中無此單號請重新輸入!';
		} else {
			if (!empty($bn_no) && !empty($machine_recycle)) {
				$sql = "INSERT INTO cargo_bn_machine (
											cargoo_code,
									        lc_code,
			 						        bn_no,
			 						        machine_recycle,
			 						        machine_check,
			 						        ipfrom,
			 						        createdate,
			 						        createuser,
			 						        sno,
			 						        edi_item_note,
			 						        updatedate,
			 						        updateuser
					        			) VALUES (
					        				'" . $cargo_code . "' ,
					        				'" . $lc_code . "' ,
					        				'" . $bn_no . "' ,
					        				'" . $machine_recycle . "' ,
					        				'" . $machine_check . "' ,
					        				'" . $ipfrom . "' ,
					        				'" . time() . "' ,
					        				'" . $createuser . "',
					        				'',
					        				'',
					        				0,
					        				'')";
				//   				if($_SESSION['emp_id'] == '7'){
				// 	echo $sql.'<br>';
				// 	exit;
				// }
				$GLOBALS['DB']->query($sql);
			}
		}
	}

	function delete_machine($id)
	{
		$GLOBALS['DB']->query("DELETE FROM cargo_bn_machine WHERE id = $id ");
	}


	function edit_machine($data)
	{

		$id =  (int)$data['edit_id'];
		$machine_recycle  = strtoupper($data['machine_recycle']);
		$machine_check 		= strtoupper($data['machine_check']);
		$updateuser = $_SESSION["emp_name"];
		$update_time = time();

		if (!empty($machine_recycle) && $id > 0) {
			$sql = "UPDATE cargo_bn_machine SET machine_recycle = '$machine_recycle', machine_check = '$machine_check',updatedate = '$update_time', updateuser = '$updateuser' WHERE id = $id ";
			$GLOBALS['DB']->query($sql);
		}
	}

	function search_bn_detail_id($id = 0)
	{
		$sql = "SELECT * FROM bn_detail WHERE bn_detail_id = $id ";
		return $GLOBALS['DB']->get_query_result($sql, true);
	}


	function create_arrival_return($data)
	{
		$bn_no = $data["bn_no"];

		$lc_id = $GLOBALS["lc_id"];
		$lc_code = $GLOBALS["lc_code"];
		$time = time();
		$emp_name = $_SESSION["emp_name"];
		$ip = $_SERVER['REMOTE_ADDR'];
		$bn_master = search_bn_for_no($bn_no);
		if (!empty($bn_master) && !empty($data["detail_id"])) {

			$cargo_id = $bn_master["cargo_id"];
			$cargo_code = $bn_master["cargo_code"];

			foreach ($data["detail_id"] as $key => $id) {
				$item_qty = (int)$data["item_qty"][$key];
				$bn_detail = $this->search_bn_detail_id($id);

				$item_id = $bn_detail["cargo_item_id"];

				$item_code = $bn_detail["item_code"];
				$item_name = $bn_detail["item_name"];
				$item_model = $bn_detail["item_model"];
				$item_grade = $bn_detail["item_grade"];

				$sql = "INSERT INTO arrival_bn_return (
										cargo_id,
										cargo_code,
										lc_id,
										lc_code,
										bn_no,
										cargo_item_id,
										item_code,
										item_name,
										item_model,
										item_qty_r,
										item_grade,
										ipfrom,
										createdate,
										createuser
									) VALUES (
										$cargo_id,
										'$cargo_code',
										$lc_id,
										'$lc_code',
										'$bn_no',
										$item_id,
										'$item_code',
										'$item_name',
										'$item_model',
										$item_qty,
										$item_grade,
										'$ip',
										'$time',
										'$emp_name'
									)";

				$GLOBALS['DB']->query($sql);
			}
		}
	}

	function PCH_reject_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND a.to_eod = 1 AND a.cargo_code LIKE 'PCH' AND a.bn_type = 6";
		$start   = ($page - 1) * $num_per_page;

		$bn_no = trim($data["bn_no"]);
		if (!empty($bn_no)) {
			$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
		}

		$receiver_name = trim($data["receiver_name"]);
		if (!empty($receiver_name)) {
			$clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
		}

		$receiver_addr = trim($data["receiver_addr"]);
		if (!empty($receiver_addr)) {
			$clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
		}

		$receiver_phone = trim($data["receiver_phone"]);
		if (!empty($receiver_phone)) {
			$clause .= " AND a.bn_receiver_phone LIKE '%$receiver_phone%' ";
		}

		$deliver_name = trim($data["deliver_name"]);
		if (!empty($deliver_name)) {
			$clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
		}

		$deliver_addr = trim($data["deliver_addr"]);
		if (!empty($deliver_addr)) {
			$clause .= " AND a.bn_deliver_addr LIKE '%$deliver_addr%' ";
		}

		$deliver_phone = trim($data["deliver_phone"]);
		if (!empty($deliver_phone)) {
			$clause .= " AND a.bn_deliver_phone LIKE '%$deliver_phone%' ";
		}


		$bn_type = (int)$data["bn_type"];
		if ($bn_type > 0) {
			if ($bn_type == 9) {
				$clause .= " AND a.self_carr = 'Y' ";
			} else {
				$clause .= " AND a.bn_type = $bn_type ";
			}
		}

		$lc_code = trim($GLOBALS["lc_code"]);
		if (!empty($lc_code)) {
			$clause .= " AND a.lc_code = '$lc_code' ";
		}

		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND a.to_eod_date >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND a.to_eod_date <= $date_end ";
		}

		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			$clause .= " AND a.deliver_setup = $deliver_setup ";
		}

		$status_code = trim($data["bn_status_code"]);
		if (!empty($status_code)) {
			$clause .= " AND a.bn_status_code = '$status_code' ";
		}

		$print_status = $data["print_status"];
		if ($print_status == 1) {
			$clause .= " AND a.bn_print = 0 ";
		} elseif ($print_status == 2) {
			$clause .= " AND a.bn_print = 1 ";
		}

		$sql = "SELECT a.*,b.bn_type AS now_bn_type FROM bn_master AS a LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id $clause ORDER BY a.to_eod_date DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master AS a LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	// MOMO未出即退開始

	function momo_cancel_list($data,  $page = 1, $num_per_page = 10)
	{
		$clause = "WHERE 1=1  ";
		$start   = ($page - 1) * $num_per_page;


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}

		if (!empty($date_start)) {
			$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
			$clause .= " AND createdate >= $date_start ";
		}

		if (!empty($date_end)) {
			$date_end = strtotime(trim($data["date_end"]) . " 00:00:00");
			$clause .= " AND createdate <= $date_end ";
		}

		$lc_code = trim($GLOBALS["lc_code"]);
		if (!empty($lc_code)) {
			//$clause .= " AND lc_code = '$lc_code' ";
		}

		$sql = "SELECT * FROM bn_master $clause AND cargo_code LIKE 'MOMO' ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master $clause AND cargo_code LIKE 'MOMO'";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function cancel_momo($data)
	{
		$time = time();
		$time_string = date("Y/m/d H:i:s");
		$emp_name = $_SESSION["emp_name"];
		$ip = $_SERVER['REMOTE_ADDR'];
		$bn_master = $this->search_bn((int)$data["id"]);
		if (!empty($bn_master)) {

			$edi_id = $bn_master["bn_master_id"];
			$bn_eod_id = $bn_master["bn_eod_id"];

			$sql = "UPDATE bn_master SET bn_type = 10, bn_status_code = '10031', bn_status = '未出即退', dispatch_no = '', vehdrv_name = '', vehdrv_phone = '', pickup_no = '', bn_status_time = $time, updatedate = $time, updateuser = '$emp_name' WHERE bn_master_id = $edi_id ";
			$GLOBALS['DB']->query($sql);

			if ($bn_master["bn_no_cardno"] == 0) {
				$sql = "UPDATE bn_master SET  bn_leave_time = $time WHERE bn_master_id = $edi_id ";
				$GLOBALS['DB']->query($sql);
			}

			$sql = "UPDATE bn_eod SET bn_type = 10, updatedate = $time, updateuser = '$emp_name' WHERE bn_eod_id = $bn_eod_id";
			$GLOBALS['DB']->query($sql);
			$sql = "INSERT INTO bn_sod (bn_master_id,bn_status_time,bn_status_code,bn_status,ipfrom,createdate,createuser,sod_note, dispatch_no, vehdrv_name, vehdrv_phone, lc_id, lc_code, bn_sod_dcim_ok, bn_sod_file_name, bn_sod_ftp_year, bn_sod_ftp_ok, bn_pay_file_name, bn_pay_ftp_year, bn_pay_ftp_ok, feedback_cargo, item_S, thermosphere, updatedate, updateuser, status_send) VALUES ($edi_id,'$time_string','10031','未出即退','$ip',$time,'$emp_name','','','','',0,'',0,'','',0,'','',0,1,0,'',0,'',0)";
			$GLOBALS['DB']->query($sql);
		}
	}

	/***** MOMO送貨單 *****/

	// function bn_momo_list($data,  $page = 1, $num_per_page = 10){

	// 	// $clause = "WHERE 1=1 AND a.to_eod = 1 AND a.cargo_code = 'MOMO' AND receiver_store_code = ''";
	// 	$clause = "WHERE 1=1 AND a.to_eod = 1 AND a.cargo_code = 'MOMO'";
	// 	$start   = ($page - 1) * $num_per_page;

	// 	$bn_mode = (int)$data["bn_mode"];
	// 	if($bn_mode >= 0){
	// 		$clause .= " AND a.bn_mode = $bn_mode ";
	// 	}


	// 	if (!empty($data["bn_no"])) {
	// 		$bn_no = trim($data["bn_no"]);
	// 		$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
	// 	}


	// 	if (!empty($data["receiver_name"])) {
	// 		$receiver_name = trim($data["receiver_name"]);
	// 		$clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
	// 	}


	// 	if (!empty($data["receiver_addr"])) {
	// 		$receiver_addr = trim($data["receiver_addr"]);
	// 		$clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
	// 	}


	// 	if (!empty($data["receiver_phone"])) {
	// 		$receiver_phone = trim($data["receiver_phone"]);
	// 		$clause .= " AND a.bn_receiver_phone LIKE '%$receiver_phone%' ";
	// 	}

	// 	if (!empty($data["receiver_phone2"])) {
	// 		$receiver_phone2 = trim($data["receiver_phone2"]);
	// 		$clause .= " AND a.bn_receiver_phone2 LIKE '%$receiver_phone2%' ";
	// 	}


	// 	if (!empty($data["deliver_name"])) {
	// 		$deliver_name = trim($data["deliver_name"]);
	// 		$clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
	// 	}


	// 	if (!empty($data["deliver_addr"])) {
	// 		$deliver_addr = trim($data["deliver_addr"]);
	// 		$clause .= " AND a.bn_deliver_addr LIKE '%$deliver_addr%' ";
	// 	}


	// 	if (!empty($data["deliver_phone"])) {
	// 		$deliver_phone = trim($data["deliver_phone"]);
	// 		$clause .= " AND a.bn_deliver_phone LIKE '%$deliver_phone%' ";
	// 	}

	// 	if (!empty($data["deliver_phone2"])) {
	// 		$deliver_phone2 = trim($data["deliver_phone2"]);
	// 		$clause .= " AND a.bn_deliver_phone2 LIKE '%$deliver_phone2%' ";
	// 	}

	// 	if (!empty($data["bn_type"])) {
	// 		$bn_type = (int)$data["bn_type"];
	// 		if($bn_type > 0){
	// 			if($bn_type == 9){
	// 				$clause .= " AND a.self_carr = 'Y' ";
	// 			}else{
	// 				$clause .= " AND a.bn_type = $bn_type ";
	// 			}
	// 		}
	// 	}


	// 	if (!empty($GLOBALS["lc_code"]) ) {
	// 		$lc_code = trim($GLOBALS["lc_code"]);
	// 		$clause .= " AND a.lc_code = '$lc_code' ";
	// 	}

	// 	if(empty($data["date_start"])){
	// 		$data["date_start"] = date("Y-m-d", time()-86400);
	// 	}
	// 	$date_start = strtotime(trim($data["date_start"])." 00:00:00" );
	// 	if (!empty($date_start)) {
	// 		$clause .= " AND a.to_eod_date >= $date_start ";
	// 	}

	// 	if(empty($data["date_end"])){
	// 		$data["date_end"] = date("Y-m-d", time());
	// 	}
	// 	$date_end = strtotime(trim($data["date_end"])." 23:59:59" );
	// 	if (!empty($date_end)) {
	// 		$clause .= " AND a.to_eod_date <= $date_end ";
	// 	}

	// 	if (!empty($data["deliver_setup"])) {
	// 		$deliver_setup = (int)$data["deliver_setup"];
	// 		$clause .= " AND a.deliver_setup = $deliver_setup ";
	// 	}


	// 	if (!empty($data["status_code"])) {
	// 		$status_code = trim($data["status_code"]);
	// 		$clause .= " AND a.bn_status_code = '$status_code' ";
	// 	}


	// 	if (!empty($data["shipping_code"])) {
	// 		$shipping_code = trim($data["shipping_code"]);
	// 		$clause .= " AND c.shipping_code = '$shipping_code' ";
	// 	}
	// 	if(!empty($data["print_status"])){
	// 		$print_status = $data["print_status"];
	// 		if ($print_status == 1) {
	// 			$clause .= " AND a.bn_print = 0 ";
	// 		}elseif ($print_status == 2) {
	// 			$clause .= " AND a.bn_print = 1 ";
	// 		}
	// 	}

	// 	$sql = "SELECT a.*,b.bn_type AS now_bn_type,c.shipping_code 
	// 			FROM bn_master AS a 
	// 			LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
	// 			LEFT JOIN momo_do AS c ON a.bn_no = c.order_no 
	// 			$clause ORDER BY a.to_eod_date DESC LIMIT $start, $num_per_page";
	// 	$result = $GLOBALS['DB']->get_query_result($sql,false);
	// 	$sql = "SELECT count(1) as num 
	// 	FROM bn_master AS a LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
	// 	LEFT JOIN momo_do AS c ON a.bn_no = c.order_no
	// 	$clause ";
	// 	$num = $GLOBALS['DB']->get_query_result($sql,true);

	// 	return array($result,$num["num"]);
	// }

	function bn_momo_list_HAO($data,  $page = 1, $num_per_page = 10)
	{

		// $clause = "WHERE 1=1 AND a.to_eod = 1 AND a.cargo_code = 'MOMO' AND receiver_store_code = ''";
		$clause = "WHERE 1=1 AND a.to_eod = 1 AND a.cargo_code = 'MOMO'";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = (int)$data["bn_mode"];
		if ($bn_mode >= 0) {
			$clause .= " AND a.bn_mode = $bn_mode ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["receiver_addr"])) {
			$receiver_addr = trim($data["receiver_addr"]);
			$clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
		}


		if (!empty($data["receiver_phone"])) {
			$receiver_phone = trim($data["receiver_phone"]);
			$clause .= " AND a.bn_receiver_phone LIKE '%$receiver_phone%' ";
		}

		if (!empty($data["receiver_phone2"])) {
			$receiver_phone2 = trim($data["receiver_phone2"]);
			$clause .= " AND a.bn_receiver_phone2 LIKE '%$receiver_phone2%' ";
		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($data["deliver_addr"])) {
			$deliver_addr = trim($data["deliver_addr"]);
			$clause .= " AND a.bn_deliver_addr LIKE '%$deliver_addr%' ";
		}


		if (!empty($data["deliver_phone"])) {
			$deliver_phone = trim($data["deliver_phone"]);
			$clause .= " AND a.bn_deliver_phone LIKE '%$deliver_phone%' ";
		}

		if (!empty($data["deliver_phone2"])) {
			$deliver_phone2 = trim($data["deliver_phone2"]);
			$clause .= " AND a.bn_deliver_phone2 LIKE '%$deliver_phone2%' ";
		}

		if (!empty($data["bn_type"])) {
			$bn_type = (int)$data["bn_type"];
			if ($bn_type > 0) {
				if ($bn_type == 9) {
					$clause .= " AND a.self_carr = 'Y' ";
				} else if ($bn_type == 99) {
					$clause .= " AND a.momo_backapi_status = 2 ";
				} else {
					$clause .= " AND a.bn_type = $bn_type ";
				}
			}
		}


		if (!empty($GLOBALS["lc_code"])) {
			$lc_code = trim($GLOBALS["lc_code"]);
			$clause .= " AND a.lc_code = '$lc_code' ";
		}

		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND a.to_eod_date >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND a.to_eod_date <= $date_end ";
		}

		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			$clause .= " AND a.deliver_setup = $deliver_setup ";
		}


		if (!empty($data["status_code"])) {
			$status_code = trim($data["status_code"]);
			$clause .= " AND a.bn_status_code = '$status_code' ";
		}


		if (!empty($data["shipping_code"])) {
			$shipping_code = trim($data["shipping_code"]);
			$clause .= " AND c.shipping_code = '$shipping_code' ";
		}
		if (!empty($data["print_status"])) {
			$print_status = $data["print_status"];
			if ($print_status == 1) {
				$clause .= " AND a.bn_print = 0 ";
			} elseif ($print_status == 2) {
				$clause .= " AND a.bn_print = 1 ";
			}
		}

		if (!empty($data["print_werks"])) {
			$print_werks = trim($data["print_werks"]);
			if ($print_werks > 1) {
				$clause .= " and tp.lc_id = '{$print_werks}' ";
			}
		}

		$sql = "SELECT a.*,b.bn_type AS now_bn_type,c.shipping_code 
					FROM bn_master AS a 
					LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
					LEFT JOIN momo_do AS c ON a.bn_no = c.order_no 
					LEFT JOIN tw_postal as tp on a.bn_receiver_zip = tp.area_code
					$clause AND length(a.bn_no) > 12 ORDER BY a.to_eod_date DESC LIMIT $start, $num_per_page";
		if ($_SESSION["emp_id"] == '7' || $_SESSION["emp_id"] == '191') {
			// echo $sql . '<br>';
			echo '<pre>';
			print_r($sql);
			echo '</pre>';
			// exit;
		}
		$result1 = $GLOBALS['DB']->get_query_result($sql, false);
		momo_back_api($result1);

		$result = $GLOBALS['DB']->get_query_result($sql, false);
		$sql = "SELECT count(1) as num 
			FROM bn_master AS a LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
			LEFT JOIN momo_do AS c ON a.bn_no = c.order_no
			LEFT JOIN tw_postal as tp on a.bn_receiver_zip = tp.area_code
			$clause AND length(a.bn_no) > 12 ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}


	// **************************************************************************
	//  函數名稱: bn_momo_list()
	//  函數功能:
	//  使用方式:
	//  備    註:
	//  程式設計: Sam
	//  設計日期: 2024.09.30
	// **************************************************************************

	function bn_momo_list($data,  $page = 1, $num_per_page = 10)
	{

		// $clause = "WHERE 1=1 AND a.to_eod = 1 AND a.cargo_code = 'MOMO' AND receiver_store_code = ''";
		$clause = "WHERE 1=1 AND a.to_eod = 1 AND a.cargo_code = 'MOMO'";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = (int)$data["bn_mode"];
		if ($bn_mode >= 0) {
			$clause .= " AND a.bn_mode = $bn_mode ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["receiver_addr"])) {
			$receiver_addr = trim($data["receiver_addr"]);
			$clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
		}


		if (!empty($data["receiver_phone"])) {
			$receiver_phone = trim($data["receiver_phone"]);
			$clause .= " AND a.bn_receiver_phone LIKE '%$receiver_phone%' ";
		}

		if (!empty($data["receiver_phone2"])) {
			$receiver_phone2 = trim($data["receiver_phone2"]);
			$clause .= " AND a.bn_receiver_phone2 LIKE '%$receiver_phone2%' ";
		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($data["deliver_addr"])) {
			$deliver_addr = trim($data["deliver_addr"]);
			$clause .= " AND a.bn_deliver_addr LIKE '%$deliver_addr%' ";
		}


		if (!empty($data["deliver_phone"])) {
			$deliver_phone = trim($data["deliver_phone"]);
			$clause .= " AND a.bn_deliver_phone LIKE '%$deliver_phone%' ";
		}

		if (!empty($data["deliver_phone2"])) {
			$deliver_phone2 = trim($data["deliver_phone2"]);
			$clause .= " AND a.bn_deliver_phone2 LIKE '%$deliver_phone2%' ";
		}

		if (!empty($data["bn_type"])) {
			$bn_type = (int)$data["bn_type"];
			if ($bn_type > 0) {
				if ($bn_type == 9) {
					$clause .= " AND a.self_carr = 'Y' ";
				} else {
					$clause .= " AND a.bn_type = $bn_type ";
				}
			}
		}


		if (!empty($GLOBALS["lc_code"])) {
			$lc_code = trim($GLOBALS["lc_code"]);
			$clause .= " AND a.lc_code = '$lc_code' ";
		}

		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND a.to_eod_date >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND a.to_eod_date <= $date_end ";
		}

		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			$clause .= " AND a.deliver_setup = $deliver_setup ";
		}


		if (!empty($data["status_code"])) {
			$status_code = trim($data["status_code"]);
			$clause .= " AND a.bn_status_code = '$status_code' ";
		}


		if (!empty($data["shipping_code"])) {
			$shipping_code = trim($data["shipping_code"]);
			$clause .= " AND c.shipping_code = '$shipping_code' ";
		}
		if (!empty($data["print_status"])) {
			$print_status = $data["print_status"];
			if ($print_status == 1) {
				$clause .= " AND a.bn_print = 0 ";
			} elseif ($print_status == 2) {
				$clause .= " AND a.bn_print = 1 ";
			}
		}

		if (!empty($data["print_werks"])) {
			$print_werks = trim($data["print_werks"]);
			if ($print_werks > 1) {
				$clause .= " and tp.lc_id = '{$print_werks}' ";
			}
		}

		if ($data["fast_deliver"])
			$sql = "SELECT a.*,b.bn_type AS now_bn_type,c.shipping_code
					FROM bn_master AS a
					LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id
					LEFT JOIN momo_do AS c ON a.bn_no = c.order_no
					LEFT JOIN bn_detail AS d ON a.bn_master_id=d.bn_master_id
					LEFT JOIN tw_postal as tp on a.bn_receiver_zip = tp.area_code
					$clause AND length(a.bn_no) > 12 
					AND EXISTS (SELECT 1 FROM item_fast_deliver AS e WHERE d.item_code = e.item_code)
					ORDER BY a.to_eod_date DESC LIMIT $start, $num_per_page";
		
		else
			$sql = "SELECT a.*,b.bn_type AS now_bn_type,c.shipping_code
                                        FROM bn_master AS a
                                        LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id
                                        LEFT JOIN momo_do AS c ON a.bn_no = c.order_no
                                        LEFT JOIN tw_postal as tp on a.bn_receiver_zip = tp.area_code
                                        $clause AND length(a.bn_no) > 12 ORDER BY a.to_eod_date DESC LIMIT $start, $num_per_page";

			
		if ($_SESSION["emp_id"] == '187' || $_SESSION["emp_id"] == '191') {
			// echo $sql . '<br>';
			echo '<pre>';
			print_r($sql);
			echo '</pre>';
			// exit;
		}
		$result1 = $GLOBALS['DB']->get_query_result($sql, false);
		momo_back_api($result1);

		$result = $GLOBALS['DB']->get_query_result($sql, false);
	
		if ($data["fast_deliver"])
			$sql = "SELECT count(1) as num
				FROM bn_master AS a LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id
				LEFT JOIN momo_do AS c ON a.bn_no = c.order_no
				LEFT JOIN bn_detail AS d ON a.bn_master_id=d.bn_master_id
				LEFT JOIN tw_postal as tp on a.bn_receiver_zip = tp.area_code
				$clause AND length(a.bn_no) > 12 AND EXISTS (SELECT 1 FROM item_fast_deliver AS e WHERE d.item_code = e.item_code)";
		else
			$sql = "SELECT count(1) as num
                                FROM bn_master AS a LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id
                                LEFT JOIN momo_do AS c ON a.bn_no = c.order_no
                                LEFT JOIN tw_postal as tp on a.bn_receiver_zip = tp.area_code
                                $clause AND length(a.bn_no) > 12 ";
		
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function bn_momo_so_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND a.to_eod = 1 AND a.cargo_code = 'MOMO' AND receiver_store_code != ''";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = (int)$data["bn_mode"];
		if ($bn_mode >= 0) {
			$clause .= " AND a.bn_mode = $bn_mode ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["receiver_addr"])) {
			$receiver_addr = trim($data["receiver_addr"]);
			$clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
		}


		if (!empty($data["receiver_phone"])) {
			$receiver_phone = trim($data["receiver_phone"]);
			$clause .= " AND a.bn_receiver_phone LIKE '%$receiver_phone%' ";
		}

		if (!empty($data["receiver_phone2"])) {
			$receiver_phone2 = trim($data["receiver_phone2"]);
			$clause .= " AND a.bn_receiver_phone2 LIKE '%$receiver_phone2%' ";
		}

		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($data["deliver_addr"])) {
			$deliver_addr = trim($data["deliver_addr"]);
			$clause .= " AND a.bn_deliver_addr LIKE '%$deliver_addr%' ";
		}


		if (!empty($data["deliver_phone"])) {
			$deliver_phone = trim($data["deliver_phone"]);
			$clause .= " AND a.bn_deliver_phone LIKE '%$deliver_phone%' ";
		}

		if (!empty($data["deliver_phone2"])) {
			$deliver_phone2 = trim($data["deliver_phone2"]);
			$clause .= " AND a.bn_deliver_phone2 LIKE '%$deliver_phone2%' ";
		}

		if (!empty($data["bn_type"])) {
			$bn_type = (int)$data["bn_type"];
			if ($bn_type > 0) {
				if ($bn_type == 9) {
					$clause .= " AND a.self_carr = 'Y' ";
				} else {
					$clause .= " AND a.bn_type = $bn_type ";
				}
			}
		}


		if (!empty($GLOBALS["lc_code"])) {
			$lc_code = trim($GLOBALS["lc_code"]);
			$clause .= " AND a.lc_code = '$lc_code' ";
		}

		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND a.to_eod_date >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND a.to_eod_date <= $date_end ";
		}

		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			$clause .= " AND a.deliver_setup = $deliver_setup ";
		}


		if (!empty($data["status_code"])) {
			$status_code = trim($data["status_code"]);
			$clause .= " AND a.bn_status_code = '$status_code' ";
		}


		if (!empty($data["shipping_code"])) {
			$shipping_code = trim($data["shipping_code"]);
			$clause .= " AND c.shipping_code = '$shipping_code' ";
		}
		if (!empty($data["print_status"])) {
			$print_status = $data["print_status"];
			if ($print_status == 1) {
				$clause .= " AND a.bn_print = 0 ";
			} elseif ($print_status == 2) {
				$clause .= " AND a.bn_print = 1 ";
			}
		}

		$sql = "SELECT a.*,b.bn_type AS now_bn_type,c.shipping_code 
					FROM bn_master AS a 
					LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
					LEFT JOIN momo_do AS c ON a.bn_no = c.order_no 
					$clause ORDER BY a.to_eod_date DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num 
			FROM bn_master AS a LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
			LEFT JOIN momo_do AS c ON a.bn_no = c.order_no
			$clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function bn_momo_all_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND a.to_eod = 1 AND a.cargo_code = 'MOMO' ";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = (int)$data["bn_mode"];
		if ($bn_mode >= 0) {
			$clause .= " AND a.bn_mode = $bn_mode ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["receiver_addr"])) {
			$receiver_addr = trim($data["receiver_addr"]);
			$clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
		}


		if (!empty($data["receiver_phone"])) {
			$receiver_phone = trim($data["receiver_phone"]);
			$clause .= " AND a.bn_receiver_phone LIKE '%$receiver_phone%' ";
		}

		if (!empty($data["receiver_phone2"])) {
			$receiver_phone2 = trim($data["receiver_phone2"]);
			$clause .= " AND a.bn_receiver_phone2 LIKE '%$receiver_phone2%' ";
		}

		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($data["deliver_addr"])) {
			$deliver_addr = trim($data["deliver_addr"]);
			$clause .= " AND a.bn_deliver_addr LIKE '%$deliver_addr%' ";
		}


		if (!empty($data["deliver_phone"])) {
			$deliver_phone = trim($data["deliver_phone"]);
			$clause .= " AND a.bn_deliver_phone LIKE '%$deliver_phone%' ";
		}

		if (!empty($data["deliver_phone2"])) {
			$deliver_phone2 = trim($data["deliver_phone2"]);
			$clause .= " AND a.bn_deliver_phone2 LIKE '%$deliver_phone2%' ";
		}

		if (!empty($data["bn_type"])) {
			$bn_type = (int)$data["bn_type"];
			if ($bn_type > 0) {
				if ($bn_type == 9) {
					$clause .= " AND a.self_carr = 'Y' ";
				} else {
					$clause .= " AND a.bn_type = $bn_type ";
				}
			}
		}

		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND a.to_eod_date >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND a.to_eod_date <= $date_end ";
		}

		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			$clause .= " AND a.deliver_setup = $deliver_setup ";
		}


		if (!empty($data["status_code"])) {
			$status_code = trim($data["status_code"]);
			$clause .= " AND a.bn_status_code = '$status_code' ";
		}


		if (!empty($data["shipping_code"])) {
			$shipping_code = trim($data["shipping_code"]);
			$clause .= " AND c.shipping_code = '$shipping_code' ";
		}
		if (!empty($data["print_status"])) {
			$print_status = $data["print_status"];
			if ($print_status == 1) {
				$clause .= " AND a.bn_print = 0 ";
			} elseif ($print_status == 2) {
				$clause .= " AND a.bn_print = 1 ";
			}
		}

		$sql = "SELECT a.*,b.bn_type AS now_bn_type,c.shipping_code 
					FROM bn_master AS a 
					LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
					LEFT JOIN momo_do AS c ON a.bn_no = c.order_no 
					$clause ORDER BY a.to_eod_date DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num 
			FROM bn_master AS a LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
			LEFT JOIN momo_do AS c ON a.bn_no = c.order_no
			$clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}



	/*******momo出貨資料*******/

	function search_cargo_item2($id = 0, $cargo_code, $item_id)
	{
		$sql = "SELECT * FROM cargo_item WHERE cargo_code = '{$cargo_code}' AND item_code = $id AND cargo_item_id =  $item_id ";

		return $GLOBALS['DB']->get_query_result($sql, false);
	}

	function momo_notice_list($data,  $page = 1, $num_per_page = 10)
	{

		// $clause = "WHERE 1=1 AND to_eod = 0 AND receiver_store_code = ' '";
		$clause = "WHERE 1=1 AND to_eod = 0 AND receiver_store_code = ' '";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = $data["bn_mode"];
		$clause .= " AND bn_mode = $bn_mode ";

		$cargo_code = "MOMO";
		if (!empty($cargo_code)) {
			$clause .= " AND cargo_code = '$cargo_code' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($GLOBALS["lc_code"])) {
			$lc_code = trim($GLOBALS["lc_code"]);
			$clause .= " AND lc_code = '$lc_code' ";
		}

		$sql = "SELECT * FROM bn_master $clause ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function momo_sonotice_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND to_eod = 0 AND receiver_store_code != ' '";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = $data["bn_mode"];
		$clause .= " AND bn_mode = $bn_mode ";

		$cargo_code = "MOMO";
		if (!empty($cargo_code)) {
			$clause .= " AND cargo_code = '$cargo_code' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($GLOBALS["lc_code"])) {
			$lc_code = trim($GLOBALS["lc_code"]);
			$clause .= " AND lc_code = '$lc_code' ";
		}

		$sql = "SELECT * FROM bn_master $clause ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function momo_notice_all_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND to_eod = 0 ";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = $data["bn_mode"];
		$clause .= " AND bn_mode = $bn_mode ";

		$cargo_code = "MOMO";
		if (!empty($cargo_code)) {
			$clause .= " AND cargo_code LIKE '$cargo_code%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND bn_receiver_name LIKE '%$receiver_name%' ";
		}

		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND bn_deliver_name LIKE '%$deliver_name%' ";
		}

		$sql = "SELECT * FROM bn_master $clause ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function search_momo_machine($id = 0)
	{
		$sql = "SELECT * FROM api_momo_machine_data WHERE id = $id ";
		return $GLOBALS['DB']->get_query_result($sql, true);
	}

	function momo_machine_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND print = 0";
		$start   = ($page - 1) * $num_per_page;

		// $print_status = $data["print_status"];
		// if ($print_status == 1) {
		// 	$clause .= " AND print = 0 ";
		// }elseif ($print_status == 2) {
		// 	$clause .= " AND print = 1 ";
		// }


		$sql = "SELECT * FROM api_momo_machine_data $clause LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM api_momo_machine_data $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function momo_oro_list($data,  $page = 1, $num_per_page = 10)
	{
		$clause = "WHERE 1=1 ";
		$start   = ($page - 1) * $num_per_page;


		if (!empty($data["order_no"])) {
			$order_no = trim($data["order_no"]);
			$clause .= " AND order_no LIKE '$order_no%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}


		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time());
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND createdate >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time() + 86400);
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND createdate <= $date_end ";
		}

		$sql = "SELECT * FROM momo_oro $clause ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM momo_oro $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function edit_momo_oro($data)
	{
		$id =  (int)$data['edit_id'];
		$bn_no  = trim($data["bn_no"]);
		$bn_updateuser = $_SESSION["emp_name"];
		$bn_update_time = time();

		if (!empty($bn_no) && $id > 0) {
			$sql = "UPDATE momo_oro SET bn_no = '$bn_no',bn_update_time = '$bn_update_time', bn_updateuser = '$bn_updateuser' WHERE momo_oro_id = $id ";
			$GLOBALS['DB']->query($sql);
		}
	}


	/*離倉報表*/

	function leave_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND a.to_eod = 1 ";
		$start   = ($page - 1) * $num_per_page;

		$cargo_code = trim(@$data["cargo_code"]);
		if (!empty($cargo_code)) {
			$clause .= " AND a.cargo_code LIKE '$cargo_code%' ";
		}

		$bn_no = trim(@$data["bn_no"]);
		if (!empty($bn_no)) {
			$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
		}

		$receiver_name = trim(@$data["receiver_name"]);
		if (!empty($receiver_name)) {
			$clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
		}

		$receiver_addr = trim(@$data["receiver_addr"]);
		if (!empty($receiver_addr)) {
			$clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
		}

		$receiver_phone = trim(@$data["receiver_phone"]);
		if (!empty($receiver_phone)) {
			$clause .= " AND a.bn_receiver_phone LIKE '%$receiver_phone%' ";
		}

		$deliver_name = trim(@$data["deliver_name"]);
		if (!empty($deliver_name)) {
			$clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
		}

		$lc_code = trim($GLOBALS["lc_code"]);
		if (!empty($lc_code) && empty(@$_GET["status"])) {
			$clause .= " AND b.lc_code = '$lc_code' ";
		}

		$bn_type = (int)@$data["bn_type"];
		if ($bn_type > 0) {
			$clause .= " AND a.bn_type = $bn_type ";
		}

		$deliver_setup = (int)@$data["deliver_setup"];
		if ($deliver_setup > 0) {
			$deliver_setup--;
			$clause .= " AND a.deliver_setup = $deliver_setup ";
		}

		if (empty(@$data["date_start"])) {
			@$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim(@$data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND a.createdate >= $date_start ";
		}

		if (empty(@$data["date_end"])) {
			@$data["date_end"] = date("Y-m-d", time());
		}
		$date_end = strtotime(trim(@$data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND a.createdate <= $date_end ";
		}

		$status_code = (int)@$data["status_code"];
		if ($status_code > 0) {
			$clause .= " AND a.bn_status_code = $status_code ";
		}

		$sel_lc_code = trim(@$data["sel_lc_code"]);
		if (!empty($sel_lc_code)) {
			$clause .= " AND b.lc_code LIKE '%$sel_lc_code%' ";
		}

		$sql = "SELECT a.* FROM bn_master AS a RIGHT JOIN bn_eod AS b ON a.bn_master_id = b.bn_master_id $clause GROUP BY b.bn_master_id ORDER BY a.createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT b.bn_master_id as num,bn_volume FROM bn_master AS a RIGHT JOIN bn_eod AS b ON a.bn_master_id = b.bn_master_id $clause GROUP BY b.bn_master_id ";
		$num = $GLOBALS['DB']->get_query_result($sql, false);

		$total_v = 0;
		if (!empty($num)) {
			foreach ($num as $key => $value) {
				$total_v += $value["bn_volume"];
			}
		} else {
			$num = 0;
		}
		return array($result, count($num), $total_v);
	}

	/***** MOMOS送貨單 *****/

	function bn_momos_list($data,  $page = 1, $num_per_page = 10)
	{
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		// $clause = "WHERE 1=1 AND a.to_eod = 1 AND a.cargo_code = 'MOMO_S' AND receiver_store_code = ''";
		$clause = "WHERE 1=1 AND a.to_eod = 1 AND a.cargo_code = 'MOMO_S'";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = (int)$data["bn_mode"];
		if ($bn_mode >= 0) {
			$clause .= " AND a.bn_mode = $bn_mode ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["receiver_addr"])) {
			$receiver_addr = trim($data["receiver_addr"]);
			$clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
		}


		if (!empty($data["receiver_phone"])) {
			$receiver_phone = trim($data["receiver_phone"]);
			$clause .= " AND a.bn_receiver_phone LIKE '%$receiver_phone%' ";
		}

		if (!empty($data["receiver_phone2"])) {
			$receiver_phone2 = trim($data["receiver_phone2"]);
			$clause .= " AND a.bn_receiver_phone2 LIKE '%$receiver_phone2%' ";
		}



		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($data["deliver_addr"])) {
			$deliver_addr = trim($data["deliver_addr"]);
			$clause .= " AND a.bn_deliver_addr LIKE '%$deliver_addr%' ";
		}


		if (!empty($data["deliver_phone"])) {
			$deliver_phone = trim($data["deliver_phone"]);
			$clause .= " AND a.bn_deliver_phone LIKE '%$deliver_phone%' ";
		}

		if (!empty($data["deliver_phone2"])) {
			$deliver_phone2 = trim($data["deliver_phone2"]);
			$clause .= " AND a.bn_deliver_phone2 LIKE '%$deliver_phone2%' ";
		}


		if (!empty($data["bn_type"])) {
			$bn_type = (int)$data["bn_type"];
			if ($bn_type > 0) {
				if ($bn_type == 9) {
					$clause .= " AND a.self_carr = 'Y' ";
				} else if ($bn_type == 99) {
					$clause .= " AND a.momo_backapi_status = 2 ";
				} else {
					$clause .= " AND a.bn_type = $bn_type ";
				}
			}
		}


		if (!empty($GLOBALS["lc_code"])) {
			$lc_code = trim($GLOBALS["lc_code"]);
			$clause .= " AND a.lc_code = '$lc_code' ";
		}

		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND a.to_eod_date >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND a.to_eod_date <= $date_end ";
		}

		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			$clause .= " AND a.deliver_setup = $deliver_setup ";
		}


		if (!empty($data["status_code"])) {
			$status_code = trim($data["status_code"]);
			$clause .= " AND a.bn_status_code = '$status_code' ";
		}


		if (!empty($data["shipping_code"])) {
			$shipping_code = trim($data["shipping_code"]);
			$clause .= " AND c.shipping_code = '$shipping_code' ";
		}

		if (!empty($data["print_status"])) {
			$print_status = $data["print_status"];
			if ($print_status == 1) {
				$clause .= " AND a.bn_print = 0 ";
			} elseif ($print_status == 2) {
				$clause .= " AND a.bn_print = 1 ";
			}
		}
		if (!empty($data["print_werks"])) {
			$print_werks = trim($data["print_werks"]);
			if ($print_werks > 1) {
				$clause .= " and tp.lc_id = '{$print_werks}' ";
			}
		}

		$sql = "SELECT a.*,b.bn_type AS now_bn_type,c.shipping_code 
					FROM bn_master AS a 
					LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
					LEFT JOIN momo_s_do AS c ON a.bn_no = c.order_no 
					left join tw_postal as tp on a.bn_receiver_zip = tp.area_code
					$clause  ORDER BY a.to_eod_date DESC LIMIT $start, $num_per_page";
		$result1 = $GLOBALS['DB']->get_query_result($sql, false);
		momo_back_api($result1);

		$result = $GLOBALS['DB']->get_query_result($sql, false);
		// echo $sql.'<br>';
		$sql = "SELECT count(1) as num 
			FROM bn_master AS a LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
			LEFT JOIN momo_s_do AS c ON a.bn_no = c.order_no
			left join tw_postal as tp on a.bn_receiver_zip = tp.area_code
			$clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function momos_notice_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND to_eod = 0 AND receiver_store_code = ''";
		// $clause = "WHERE 1=1 AND to_eod = 0";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = $data["bn_mode"];
		$clause .= " AND bn_mode = $bn_mode ";

		$cargo_code = "MOMO_S";
		if (!empty($cargo_code)) {
			$clause .= " AND cargo_code = '$cargo_code' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($GLOBALS["lc_code"])) {
			$lc_code = trim($GLOBALS["lc_code"]);
			$clause .= " AND lc_code = '$lc_code' ";
		}

		$sql = "SELECT * FROM bn_master $clause ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function momos_sonotice_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND to_eod = 0 AND receiver_store_code != ' '";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = $data["bn_mode"];
		$clause .= " AND bn_mode = $bn_mode ";

		$cargo_code = "MOMO_S";
		if (!empty($cargo_code)) {
			$clause .= " AND cargo_code = '$cargo_code' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($GLOBALS["lc_code"])) {
			$lc_code = trim($GLOBALS["lc_code"]);
			$clause .= " AND lc_code = '$lc_code' ";
		}

		$sql = "SELECT * FROM bn_master $clause ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);
		$sql = "SELECT count(1) as num FROM bn_master $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function bn_momos_so_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND a.to_eod = 1 AND a.cargo_code = 'MOMO_S' AND receiver_store_code != ''";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = (int)$data["bn_mode"];
		if ($bn_mode >= 0) {
			$clause .= " AND a.bn_mode = $bn_mode ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["receiver_addr"])) {
			$receiver_addr = trim($data["receiver_addr"]);
			$clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
		}


		if (!empty($data["receiver_phone"])) {
			$receiver_phone = trim($data["receiver_phone"]);
			$clause .= " AND a.bn_receiver_phone LIKE '%$receiver_phone%' ";
		}

		if (!empty($data["receiver_phone2"])) {
			$receiver_phone2 = trim($data["receiver_phone2"]);
			$clause .= " AND a.bn_receiver_phone2 LIKE '%$receiver_phone2%' ";
		}

		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($data["deliver_addr"])) {
			$deliver_addr = trim($data["deliver_addr"]);
			$clause .= " AND a.bn_deliver_addr LIKE '%$deliver_addr%' ";
		}


		if (!empty($data["deliver_phone"])) {
			$deliver_phone = trim($data["deliver_phone"]);
			$clause .= " AND a.bn_deliver_phone LIKE '%$deliver_phone%' ";
		}

		if (!empty($data["deliver_phone2"])) {
			$deliver_phone2 = trim($data["deliver_phone2"]);
			$clause .= " AND a.bn_deliver_phone2 LIKE '%$deliver_phone2%' ";
		}

		if (!empty($data["bn_type"])) {
			$bn_type = (int)$data["bn_type"];
			if ($bn_type > 0) {
				if ($bn_type == 9) {
					$clause .= " AND a.self_carr = 'Y' ";
				} else {
					$clause .= " AND a.bn_type = $bn_type ";
				}
			}
		}


		if (!empty($GLOBALS["lc_code"])) {
			$lc_code = trim($GLOBALS["lc_code"]);
			$clause .= " AND a.lc_code = '$lc_code' ";
		}

		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND a.to_eod_date >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND a.to_eod_date <= $date_end ";
		}

		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			$clause .= " AND a.deliver_setup = $deliver_setup ";
		}


		if (!empty($data["status_code"])) {
			$status_code = trim($data["status_code"]);
			$clause .= " AND a.bn_status_code = '$status_code' ";
		}


		if (!empty($data["shipping_code"])) {
			$shipping_code = trim($data["shipping_code"]);
			$clause .= " AND c.shipping_code = '$shipping_code' ";
		}

		if (!empty($data["print_status"])) {
			$print_status = $data["print_status"];
			if ($print_status == 1) {
				$clause .= " AND a.bn_print = 0 ";
			} elseif ($print_status == 2) {
				$clause .= " AND a.bn_print = 1 ";
			}
		}

		$sql = "SELECT a.*,b.bn_type AS now_bn_type,c.shipping_code 
					FROM bn_master AS a 
					LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
					LEFT JOIN momo_do AS c ON a.bn_no = c.order_no 
					$clause ORDER BY a.to_eod_date DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);
		$sql = "SELECT count(1) as num 
			FROM bn_master AS a LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
			LEFT JOIN momo_do AS c ON a.bn_no = c.order_no
			$clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function momos_notice_all_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND to_eod = 0 ";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = $data["bn_mode"];
		$clause .= " AND bn_mode = $bn_mode ";

		$cargo_code = "MOMO_S";
		if (!empty($cargo_code)) {
			$clause .= " AND cargo_code LIKE '$cargo_code%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND bn_deliver_name LIKE '%$deliver_name%' ";
		}

		$sql = "SELECT * FROM bn_master $clause ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function bn_momos_all_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE 1=1 AND a.to_eod = 1 AND a.cargo_code = 'MOMO_S' ";
		$start   = ($page - 1) * $num_per_page;

		$bn_mode = (int)$data["bn_mode"];
		if ($bn_mode >= 0) {
			$clause .= " AND a.bn_mode = $bn_mode ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["receiver_addr"])) {
			$receiver_addr = trim($data["receiver_addr"]);
			$clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
		}


		if (!empty($data["receiver_phone"])) {
			$receiver_phone = trim($data["receiver_phone"]);
			$clause .= " AND a.bn_receiver_phone LIKE '%$receiver_phone%' ";
		}

		if (!empty($data["receiver_phone2"])) {
			$receiver_phone2 = trim($data["receiver_phone2"]);
			$clause .= " AND a.bn_receiver_phone2 LIKE '%$receiver_phone2%' ";
		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($data["deliver_addr"])) {
			$deliver_addr = trim($data["deliver_addr"]);
			$clause .= " AND a.bn_deliver_addr LIKE '%$deliver_addr%' ";
		}


		if (!empty($data["deliver_phone"])) {
			$deliver_phone = trim($data["deliver_phone"]);
			$clause .= " AND a.bn_deliver_phone LIKE '%$deliver_phone%' ";
		}

		if (!empty($data["deliver_phone2"])) {
			$deliver_phone2 = trim($data["deliver_phone2"]);
			$clause .= " AND a.bn_deliver_phone2 LIKE '%$deliver_phone2%' ";
		}

		if (!empty($data["bn_type"])) {
			$bn_type = (int)$data["bn_type"];
			if ($bn_type > 0) {
				if ($bn_type == 9) {
					$clause .= " AND a.self_carr = 'Y' ";
				} else {
					$clause .= " AND a.bn_type = $bn_type ";
				}
			}
		}

		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND a.to_eod_date >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND a.to_eod_date <= $date_end ";
		}

		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			$clause .= " AND a.deliver_setup = $deliver_setup ";
		}


		if (!empty($data["status_code"])) {
			$status_code = trim($data["status_code"]);
			$clause .= " AND a.bn_status_code = '$status_code' ";
		}


		if (!empty($data["shipping_code"])) {
			$shipping_code = trim($data["shipping_code"]);
			$clause .= " AND c.shipping_code = '$shipping_code' ";
		}

		if (!empty($data["print_status"])) {
			$print_status = $data["print_status"];
			if ($print_status == 1) {
				$clause .= " AND a.bn_print = 0 ";
			} elseif ($print_status == 2) {
				$clause .= " AND a.bn_print = 1 ";
			}
		}

		if (!empty($GLOBALS["lc_code"])) {
			if ($GLOBALS["lc_code"] == 'DC01') {
			} else {
				$lc_code = trim($GLOBALS["lc_code"]);
				$clause .= " AND a.lc_code = '$lc_code' ";
			}
		}

		$sql = "SELECT a.*,b.bn_type AS now_bn_type,c.shipping_code 
					FROM bn_master AS a 
					LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
					LEFT JOIN momo_s_do AS c ON a.bn_no = c.order_no 
					$clause ORDER BY a.to_eod_date DESC LIMIT $start, $num_per_page";
		if ($_SESSION["emp_id"] == '191') {
			// echo $sql . '<br>';
			echo '<pre>';
			print_r($sql);
			echo '</pre>';
		}
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num 
			FROM bn_master AS a LEFT JOIN bn_eod AS b ON a.bn_eod_id = b.bn_eod_id 
			LEFT JOIN momo_s_do AS c ON a.bn_no = c.order_no
			$clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function momos_oro_list($data,  $page = 1, $num_per_page = 10)
	{
		$clause = "WHERE 1=1 ";
		$start   = ($page - 1) * $num_per_page;


		if (!empty($data["order_no"])) {
			$order_no = trim($data["order_no"]);
			$clause .= " AND order_no LIKE '$order_no%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}


		// if(empty($data["date_start"])){
		// 	$data["date_start"] = date("Y-m-d", time()-86400);
		// }
		// $date_start = strtotime(trim($data["date_start"])." 00:00:00" );
		// if (!empty($date_start)) {
		// 	$clause .= " AND createdate >= $date_start ";
		// }

		// if(empty($data["date_end"])){
		// 	$data["date_end"] = date("Y-m-d", time());
		// }
		// $date_end = strtotime(trim($data["date_end"])." 23:59:59" );
		// if (!empty($date_end)) {
		// 	$clause .= " AND createdate <= $date_end ";
		// }


		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time());
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND createdate >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time() + 86400);
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND createdate <= $date_end ";
		}

		$sql = "SELECT * FROM momo_s_oro $clause ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM momo_s_oro $clause ";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function edit_momos_oro($data)
	{
		$id =  (int)$data['edit_id'];
		$bn_no  = trim($data["bn_no"]);
		$bn_updateuser = $_SESSION["emp_name"];
		$bn_update_time = time();

		if (!empty($bn_no) && $id > 0) {
			$sql = "UPDATE momo_s_oro SET bn_no = '$bn_no',bn_update_time = '{$bn_update_time}', bn_updateuser = '{$bn_updateuser}' WHERE momo_oro_id = $id ";
			$GLOBALS['DB']->query($sql);
		}
	}

	function momos_cancel_list($data,  $page = 1, $num_per_page = 10)
	{
		$clause = "WHERE 1=1  ";
		$start   = ($page - 1) * $num_per_page;


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND bn_no LIKE '%$bn_no%' ";
		}

		if (!empty($date_start)) {
			$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
			$clause .= " AND createdate >= $date_start ";
		}

		if (!empty($date_end)) {
			$date_end = strtotime(trim($data["date_end"]) . " 00:00:00");
			$clause .= " AND createdate <= $date_end ";
		}

		$lc_code = trim($GLOBALS["lc_code"]);
		if (!empty($lc_code)) {
			//$clause .= " AND lc_code = '$lc_code' ";
		}

		$sql = "SELECT * FROM bn_master $clause AND cargo_code LIKE 'MOMO_S' ORDER BY createdate DESC LIMIT $start, $num_per_page";
		$result = $GLOBALS['DB']->get_query_result($sql, false);

		$sql = "SELECT count(1) as num FROM bn_master $clause AND cargo_code LIKE 'MOMO_S'";
		$num = $GLOBALS['DB']->get_query_result($sql, true);

		return array($result, $num["num"]);
	}

	function cancel_momos($data)
	{
		$time = time();
		$time_string = date("Y/m/d H:i:s");
		$emp_name = $_SESSION["emp_name"];
		$ip = $_SERVER['REMOTE_ADDR'];
		$bn_master = $this->search_bn((int)$data["id"]);
		if (!empty($bn_master)) {

			$edi_id = $bn_master["bn_master_id"];
			$bn_eod_id = $bn_master["bn_eod_id"];

			$sql = "UPDATE bn_master SET bn_type = 10, bn_status_code = '10031', bn_status = '未出即退', dispatch_no = '', vehdrv_name = '', vehdrv_phone = '', pickup_no = '', bn_status_time = $time, updatedate = $time, updateuser = '$emp_name' WHERE bn_master_id = $edi_id ";
			$GLOBALS['DB']->query($sql);

			if ($bn_master["bn_no_cardno"] == 0) {
				$sql = "UPDATE bn_master SET  bn_leave_time = $time WHERE bn_master_id = $edi_id ";
				$GLOBALS['DB']->query($sql);
			}

			$sql = "UPDATE bn_eod SET bn_type = 10, updatedate = $time, updateuser = '$emp_name' WHERE bn_eod_id = $bn_eod_id";
			$GLOBALS['DB']->query($sql);
			$sql = "INSERT INTO bn_sod (bn_master_id,bn_status_time,bn_status_code,bn_status,ipfrom,createdate,createuser,sod_note, dispatch_no, vehdrv_name, vehdrv_phone, lc_id, lc_code, bn_sod_dcim_ok, bn_sod_file_name, bn_sod_ftp_year, bn_sod_ftp_ok, bn_pay_file_name, bn_pay_ftp_year, bn_pay_ftp_ok, feedback_cargo, item_S, thermosphere, updatedate, updateuser, status_send) VALUES ($edi_id,'$time_string','10031','未出即退','$ip',$time,'$emp_name','','','','',0,'',0,'','',0,'','',0,1,0,'',0,'',0)";
			$GLOBALS['DB']->query($sql);
		}
	}

	//約配時間加上備註
	function edit_note($data)
	{
		$id = (int)$data["edit_id"];
		$edit_install_note 	= htmlspecialchars(trim(strtoupper($data["edit_install_note"])));

		$sql = "UPDATE bn_master SET  
							install_note 	= '$edit_install_note'
					WHERE bn_master_id = $id";

		$GLOBALS['DB']->query($sql);
	}

	function search_install_note($id = 0)
	{
		$sql = "SELECT * FROM bn_master WHERE bn_master_id = '$id' ";
		return $GLOBALS['DB']->get_query_result($sql, true);
	}
	// **************************************************************************
	//  函數名稱: check_bn_detail_lss_upd_ok()
	//  函數功能: 
	//  使用方式: check_bn_detail_lss_upd_ok('detail_id','usercode','user','id')
	//  備    註: 檔身pkey+員編+員工姓名+檔頭pkey
	//  程式設計: 周小樵
	//  設計日期: 2022.04.15
	// **************************************************************************
	function check_bn_detail_lss_upd_ok($bn_detail_id, $update_usercode, $update_user)
	{
		$sql = "select  bn_master_id,upd_ok,empname,empno from bn_detail_lss where upd_ok = 'Y' and bn_detail_id = '{$bn_detail_id}'";
		return $GLOBALS['DB']->get_query_result($sql, false);
	}

	// **************************************************************************
	//  函數名稱: bn_install_list_HAO()
	//  函數功能: 
	//  使用方式: 
	//  備    註: 
	//  程式設計: HAO
	//  設計日期: 2022.07.19
	// **************************************************************************

	function bn_install_list_HAO($data,  $page = 1, $num_per_page = 10)
	{

		// $clause = "WHERE a.to_eod = 1 ";
		// $clause2 = "WHERE a.to_eod = 1 ";
		// $clause = "WHERE a.to_eod = 1  AND a.self_carr = 'N' ";
		// $clause2 = "WHERE a.to_eod = 1  AND a.self_carr = 'N' ";
		$clause = "WHERE a.to_eod = 1  AND a.self_carr = 'N'";
		$clause2 = "WHERE ";
		// a.to_eod = 1 AND a.self_carr = 'N' AND AND createdate between 1682265600 AND 1682438399
		$start   = ($page - 1) * $num_per_page;
		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");


		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}


		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		$clause2 .= " createdate between $date_start and $date_end and self_carr = 'N'";

		if (!empty($data["cargo_code"])) {
			$cargo_code = trim($data["cargo_code"]);
			// $clause .= " AND a.cargo_code LIKE '$cargo_code%' ";
			$clause2 .= " AND cargo_code LIKE '$cargo_code%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			// $clause .= " AND a.bn_no LIKE '%$bn_no' ";
			$clause2 .= " AND bn_no LIKE '%$bn_no' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			// $clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
			$clause2 .= " AND bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["receiver_addr"])) {
			$receiver_addr = trim($data["receiver_addr"]);
			// $clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
			$clause2 .= " AND bn_receiver_addr LIKE '%$receiver_addr%' ";
		}


		if (!empty($data["receiver_phone"])) {
			$receiver_phone = trim($data["receiver_phone"]);
			if ($data["receiver_phone"] <> '') {
				// $clause .= " AND (a.bn_receiver_phone LIKE '%$receiver_phone%' or a.bn_receiver_phone2 LIKE '%$receiver_phone%' ) ";
				$clause2 .= " AND (a.bn_receiver_phone LIKE '%$receiver_phone%' or a.bn_receiver_phone2 LIKE '%$receiver_phone%' ) ";
			}
		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			// $clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
			$clause2 .= " AND bn_deliver_name LIKE '%$deliver_name%' ";
		}


		// if (!empty($GLOBALS["lc_code"])&& empty($_GET["status"]) ) {
		// 	$lc_code = trim($GLOBALS["lc_code"]);
		// 	$clause .= " AND b.lc_code = '$lc_code' ";
		// 	// $clause2 .= " AND lc_code = '$lc_code' ";
		// }

		if (!empty($data["bn_type"])) {
			$bn_type = (int)$data["bn_type"];
			if ($bn_type > 0) {
				// $clause .= " AND a.bn_type = $bn_type ";
				$clause2 .= " AND bn_type = $bn_type ";
			}
		}


		if (!empty($data["status_code"])) {
			$status_code = (int)$data["status_code"];
			if ($status_code > 0) {
				// $clause .= " AND a.bn_status_code = $status_code ";
				$clause2 .= " AND bn_status_code = $status_code ";
			}
		}
		// if(!empty($data["sel_lc_code"])){
		// 	$sel_lc_code = trim($data["sel_lc_code"]);
		// 	if (!empty($sel_lc_code)) {
		// 		$clause .= " AND b.lc_code LIKE '%$sel_lc_code%' ";
		// 	}
		// }
		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			if ($deliver_setup > 0) {
				$deliver_setup--;
				// $clause .= " AND a.deliver_setup = $deliver_setup ";
				$clause2 .= " AND deliver_setup = $deliver_setup ";
			}
		}


		$sql = "SELECT a.bn_master_id FROM bn_master as a $clause2 ";
		// if ($_SESSION["emp_id"] == '144' || $_SESSION["emp_id"] == '7') {
		// echo $sql . '<br>';
		// }
		$result = $GLOBALS['DB']->get_query_result($sql, false);
		if (!empty($result)) {
			$bn_master_id = '';
			for ($i = 0; $i < count($result); $i++) {
				if (!empty($result[$i]['bn_master_id'])) {
					$bn_master_id .= "'" . $result[$i]['bn_master_id'] . "',";
				}
			}
			$bn_master_id = substr($bn_master_id, 0, -1);

			$sql = "SELECT a.*, MAX(c.phone_time) 
							 FROM bn_master AS a RIGHT JOIN bn_eod AS b ON a.bn_master_id = b.bn_master_id LEFT JOIN
							 bn_phone_sod AS c ON a.bn_master_id = c.bn_master_id
							 $clause and a.bn_master_id in ($bn_master_id) 
							 GROUP BY b.bn_master_id 
							 ORDER BY a.createdate 
							 DESC LIMIT $start, $num_per_page";
			// if ($_SESSION["emp_id"] == '144' || $_SESSION["emp_id"] == '7') {
			// echo $sql . '<br>';
			// }
			$result = $GLOBALS['DB']->get_query_result($sql, false);

			$sql = "SELECT b.bn_master_id as num,bn_volume FROM bn_master AS a RIGHT JOIN bn_eod AS b ON a.bn_master_id = b.bn_master_id $clause  and a.bn_master_id in ($bn_master_id) GROUP BY b.bn_master_id ";
			if ($_SESSION["emp_id"] == '144' || $_SESSION["emp_id"] == '7') {
				echo $sql . '<br>';
			}
			$num = $GLOBALS['DB']->get_query_result($sql, false);
			$total_v = 0;
			if (!empty($num)) {
				foreach ($num as $key => $value) {
					$total_v += $value["bn_volume"];
				}
			} else {
				$num = 0;
			}
		} else {
			$num = 0;
			$total_v = 0;
			$result = 'error';
		}
		$num = empty($num) ? 0 : count($num);
		return array($result, $num, $total_v);
	}

	// **************************************************************************
	//  函數名稱: bn_install_list()
	//  函數功能: 
	//  使用方式: 
	//  備    註: 
	//  程式設計: Sam
	//  設計日期: 2024.09.29
	// **************************************************************************

	function bn_install_list($data,  $page = 1, $num_per_page = 10)
	{

		// $clause = "WHERE a.to_eod = 1 ";
		// $clause2 = "WHERE a.to_eod = 1 ";
		// $clause = "WHERE a.to_eod = 1  AND a.self_carr = 'N' ";
		// $clause2 = "WHERE a.to_eod = 1  AND a.self_carr = 'N' ";
		$clause = "WHERE a.to_eod = 1  AND a.self_carr = 'N'";
		$clause2 = "WHERE ";
		// a.to_eod = 1 AND a.self_carr = 'N' AND AND createdate between 1682265600 AND 1682438399
		$start   = ($page - 1) * $num_per_page;
		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");


		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}


		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		$clause2 .= " a.createdate between $date_start and $date_end and self_carr = 'N'";

		if (!empty($data["cargo_code"])) {
			$cargo_code = trim($data["cargo_code"]);
			// $clause .= " AND a.cargo_code LIKE '$cargo_code%' ";
			$clause2 .= " AND a.cargo_code LIKE '$cargo_code%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			// $clause .= " AND a.bn_no LIKE '%$bn_no' ";
			$clause2 .= " AND a.bn_no LIKE '%$bn_no' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			// $clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
			$clause2 .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["receiver_addr"])) {
			$receiver_addr = trim($data["receiver_addr"]);
			// $clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
			$clause2 .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
		}


		if (!empty($data["receiver_phone"])) {
			$receiver_phone = trim($data["receiver_phone"]);
			if ($data["receiver_phone"] <> '') {
				// $clause .= " AND (a.bn_receiver_phone LIKE '%$receiver_phone%' or a.bn_receiver_phone2 LIKE '%$receiver_phone%' ) ";
				$clause2 .= " AND (a.bn_receiver_phone LIKE '%$receiver_phone%' or a.bn_receiver_phone2 LIKE '%$receiver_phone%' ) ";
			}
		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			// $clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
			$clause2 .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
		}


		// if (!empty($GLOBALS["lc_code"])&& empty($_GET["status"]) ) {
		// 	$lc_code = trim($GLOBALS["lc_code"]);
		// 	$clause .= " AND b.lc_code = '$lc_code' ";
		// 	// $clause2 .= " AND lc_code = '$lc_code' ";
		// }

		if (!empty($data["bn_type"])) {
			$bn_type = (int)$data["bn_type"];
			if ($bn_type > 0) {
				// $clause .= " AND a.bn_type = $bn_type ";
				$clause2 .= " AND a.bn_type = $bn_type ";
			}
		}


		if (!empty($data["status_code"])) {
			$status_code = (int)$data["status_code"];
			if ($status_code > 0) {
				// $clause .= " AND a.bn_status_code = $status_code ";
				$clause2 .= " AND a.bn_status_code = $status_code ";
			}
		}
		// if(!empty($data["sel_lc_code"])){
		// 	$sel_lc_code = trim($data["sel_lc_code"]);
		// 	if (!empty($sel_lc_code)) {
		// 		$clause .= " AND b.lc_code LIKE '%$sel_lc_code%' ";
		// 	}
		// }
		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			if ($deliver_setup > 0) {
				$deliver_setup--;
				// $clause .= " AND a.deliver_setup = $deliver_setup ";
				$clause2 .= " AND a.deliver_setup = $deliver_setup ";
			}
		}


		if ($data["fast_deliver"]) 
			$sql = "SELECT a.bn_master_id FROM bn_master AS a, bn_detail AS b $clause2 AND a.bn_master_id = b.bn_master_id AND EXISTS (SELECT 1 FROM item_fast_deliver AS c WHERE b.item_code = c.item_code)";
		else 
			$sql = "SELECT a.bn_master_id FROM bn_master as a $clause2 ";

		// if ($_SESSION["emp_id"] == '144' || $_SESSION["emp_id"] == '7') {
		// echo $sql . '<br>';
		// }
		$result = $GLOBALS['DB']->get_query_result($sql, false);
		if (!empty($result)) {
			$bn_master_id = '';
			for ($i = 0; $i < count($result); $i++) {
				if (!empty($result[$i]['bn_master_id'])) {
					$bn_master_id .= "'" . $result[$i]['bn_master_id'] . "',";
				}
			}
			$bn_master_id = substr($bn_master_id, 0, -1);

			$sql = "SELECT a.*, MAX(c.phone_time) 
							 FROM bn_master AS a RIGHT JOIN bn_eod AS b ON a.bn_master_id = b.bn_master_id LEFT JOIN
							 bn_phone_sod AS c ON a.bn_master_id = c.bn_master_id
							 $clause and a.bn_master_id in ($bn_master_id) 
							 GROUP BY b.bn_master_id 
							 ORDER BY a.createdate 
							 DESC LIMIT $start, $num_per_page";
			// if ($_SESSION["emp_id"] == '144' || $_SESSION["emp_id"] == '7') {
			// echo $sql . '<br>';
			// }
			$result = $GLOBALS['DB']->get_query_result($sql, false);

			$sql = "SELECT b.bn_master_id as num,bn_volume FROM bn_master AS a RIGHT JOIN bn_eod AS b ON a.bn_master_id = b.bn_master_id $clause  and a.bn_master_id in ($bn_master_id) GROUP BY b.bn_master_id ";
			if ($_SESSION["emp_id"] == '144' || $_SESSION["emp_id"] == '7') {
				echo $sql . '<br>';
			}
			$num = $GLOBALS['DB']->get_query_result($sql, false);
			$total_v = 0;
			if (!empty($num)) {
				foreach ($num as $key => $value) {
					$total_v += $value["bn_volume"];
				}
			} else {
				$num = 0;
			}
		} else {
			$num = 0;
			$total_v = 0;
			$result = 'error';
		}
		$num = empty($num) ? 0 : count($num);
		return array($result, $num, $total_v);
	}

	// **************************************************************************
	//  函數名稱: bn_install_list_isinstall()
	//  函數功能: 
	//  使用方式: 
	//  備    註: 
	//  程式設計: HAO
	//  設計日期: 2022.07.19
	// **************************************************************************

	function bn_install_list_isinstall($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE a.to_eod = 1  AND a.self_carr = 'N'";
		$clause2 = "WHERE ";
		$start   = ($page - 1) * $num_per_page;
        if (empty($data["date_start"])) {
            $data["date_start"] = date("Y-m-d", time() - 86400);
        }
        if (empty($data["date_end"])) {
            $data["date_end"] = date("Y-m-d", time());
        }

        $date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
        $date_end = strtotime(trim($data["date_end"]) . " 23:59:59");

        $clause2 .= " createdate between $date_start and $date_end and self_carr = 'N'";


		if (!empty($data["install_start"])) {
            $clause2 .= " AND a.install_date >= '".$data["install_start"]."'";
		}


		if (!empty($data["install_end"])) {
			$clause2 .= " AND a.install_date <= '".$data["install_end"]."'";
		}


		if (!empty($data["cargo_code"])) {
			$cargo_code = trim($data["cargo_code"]);
			// $clause .= " AND a.cargo_code LIKE '$cargo_code%' ";
			$clause2 .= " AND cargo_code LIKE '$cargo_code%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			// $clause .= " AND a.bn_no LIKE '%$bn_no' ";
			$clause2 .= " AND bn_no LIKE '%$bn_no' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			// $clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
			$clause2 .= " AND bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["receiver_addr"])) {
			$receiver_addr = trim($data["receiver_addr"]);
			// $clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
			$clause2 .= " AND bn_receiver_addr LIKE '%$receiver_addr%' ";
		}


		if (!empty($data["receiver_phone"])) {
			$receiver_phone = trim($data["receiver_phone"]);
			if ($data["receiver_phone"] <> '') {
				// $clause .= " AND (a.bn_receiver_phone LIKE '%$receiver_phone%' or a.bn_receiver_phone2 LIKE '%$receiver_phone%' ) ";
				$clause2 .= " AND (a.bn_receiver_phone LIKE '%$receiver_phone%' or a.bn_receiver_phone2 LIKE '%$receiver_phone%' ) ";
			}
		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			// $clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
			$clause2 .= " AND bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($data["bn_type"])) {
			$bn_type = (int)$data["bn_type"];
			if ($bn_type > 0) {
				// $clause .= " AND a.bn_type = $bn_type ";
				$clause2 .= " AND bn_type = $bn_type ";
			}
		}


		if (!empty($data["status_code"])) {
			$status_code = (int)$data["status_code"];
			if ($status_code > 0) {
				// $clause .= " AND a.bn_status_code = $status_code ";
				$clause2 .= " AND bn_status_code = $status_code ";
			}
		}
		// if(!empty($data["sel_lc_code"])){
		// 	$sel_lc_code = trim($data["sel_lc_code"]);
		// 	if (!empty($sel_lc_code)) {
		// 		$clause .= " AND b.lc_code LIKE '%$sel_lc_code%' ";
		// 	}
		// }
		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			if ($deliver_setup > 0) {
				$deliver_setup--;
				// $clause .= " AND a.deliver_setup = $deliver_setup ";
				$clause2 .= " AND deliver_setup = $deliver_setup ";
			}
		}


		$sql = "SELECT a.bn_master_id FROM bn_master as a $clause2  ";
		// if ($_SESSION["emp_id"] == '144' || $_SESSION["emp_id"] == '7') {
		// }
        
		$result = $GLOBALS['DB']->get_query_result($sql, false);
		if (!empty($result)) {
			$bn_master_id = '';
			for ($i = 0; $i < count($result); $i++) {
				if (!empty($result[$i]['bn_master_id'])) {
					$bn_master_id .= "'" . $result[$i]['bn_master_id'] . "',";
				}
			}
			$bn_master_id = substr($bn_master_id, 0, -1);

			$sql = "SELECT a.*, MAX(c.phone_time) 
							 FROM bn_master AS a RIGHT JOIN bn_eod AS b ON a.bn_master_id = b.bn_master_id LEFT JOIN
							 bn_phone_sod AS c ON a.bn_master_id = c.bn_master_id
							 $clause and a.bn_master_id in ($bn_master_id) 
							 GROUP BY b.bn_master_id 
							 ORDER BY a.createdate 
							 DESC LIMIT $start, $num_per_page";
			// if ($_SESSION["emp_id"] == '144' || $_SESSION["emp_id"] == '7') {
			// }
			$result = $GLOBALS['DB']->get_query_result($sql, false);

			$sql = "SELECT b.bn_master_id as num,bn_volume FROM bn_master AS a RIGHT JOIN bn_eod AS b ON a.bn_master_id = b.bn_master_id $clause  and a.bn_master_id in ($bn_master_id) GROUP BY b.bn_master_id ";
			if ($_SESSION["emp_id"] == '144' || $_SESSION["emp_id"] == '7') {
				echo $sql . '<br>';
			}
			$num = $GLOBALS['DB']->get_query_result($sql, false);
			$total_v = 0;
			if (!empty($num)) {
				foreach ($num as $key => $value) {
					$total_v += $value["bn_volume"];
				}
			} else {
				$num = 0;
			}
		} else {
			$num = 0;
			$total_v = 0;
			$result = 'error';
		}
		$num = empty($num) ? 0 : count($num);
		return array($result, $num, $total_v);
	}
	// **************************************************************************
	//  函數名稱: search_phone_sod()
	//  函數功能: 
	//  使用方式: 
	//  備    註: 
	//  程式設計: HAO
	//  設計日期: 2022.07.19
	// **************************************************************************


	function search_phone_sod($id)
	{
		$sql = "SELECT phone_time FROM bn_phone_sod WHERE bn_master_id = $id ORDER BY  bn_phone_id DESC, phone_time";
		return $GLOBALS["DB"]->get_query_result($sql, false);
	}

	function search_install_sod($id)
	{
		$sql = "SELECT install_time FROM bn_install_sod WHERE bn_master_id = $id ORDER BY bn_install_id DESC, install_time";
		return $GLOBALS['DB']->get_query_result($sql, false);
	}


	// **************************************************************************
	//  函數名稱: bn_photo_list()
	//  函數功能: 
	//  使用方式: 
	//  備    註: 
	//  程式設計: HAO
	//  設計日期: 2022.10.03
	// **************************************************************************



	function bn_photo_list($data,  $page = 1, $num_per_page = 10)
	{

		$clause = "WHERE a.to_eod = 1 ";
		$clause2 = "WHERE a.to_eod = 1 ";
		$start   = ($page - 1) * $num_per_page;


		if (!empty($data["cargo_code"])) {
			$cargo_code = trim($data["cargo_code"]);
			$clause .= " AND a.cargo_code LIKE '$cargo_code%' ";
			$clause2 .= " AND cargo_code LIKE '$cargo_code%' ";
		}


		if (!empty($data["bn_no"])) {
			$bn_no = trim($data["bn_no"]);
			$clause .= " AND a.bn_no LIKE '%$bn_no%' ";
			$clause2 .= " AND bn_no LIKE '%$bn_no%' ";
		}


		if (!empty($data["receiver_name"])) {
			$receiver_name = trim($data["receiver_name"]);
			$clause .= " AND a.bn_receiver_name LIKE '%$receiver_name%' ";
			$clause2 .= " AND bn_receiver_name LIKE '%$receiver_name%' ";
		}


		if (!empty($data["receiver_addr"])) {
			$receiver_addr = trim($data["receiver_addr"]);
			$clause .= " AND a.bn_receiver_addr LIKE '%$receiver_addr%' ";
			$clause2 .= " AND bn_receiver_addr LIKE '%$receiver_addr%' ";
		}


		if (!empty($data["receiver_phone"])) {
			$receiver_phone = trim($data["receiver_phone"]);
			$clause .= " AND a.bn_receiver_phone LIKE '%$receiver_phone%' ";
			$clause2 .= " AND bn_receiver_phone LIKE '%$receiver_phone%' ";
		}


		if (!empty($data["deliver_name"])) {
			$deliver_name = trim($data["deliver_name"]);
			$clause .= " AND a.bn_deliver_name LIKE '%$deliver_name%' ";
			$clause2 .= " AND bn_deliver_name LIKE '%$deliver_name%' ";
		}


		if (!empty($GLOBALS["lc_code"]) && empty($_GET["status"])) {
			$lc_code = trim($GLOBALS["lc_code"]);
			$clause .= " AND b.lc_code = '$lc_code' ";
		}
		if (!empty($data["bn_type"])) {
			$bn_type = (int)$data["bn_type"];
			if ($bn_type > 0) {
				$clause .= " AND a.bn_type = $bn_type ";
				$clause2 .= " AND bn_type = $bn_type ";
			}
		}
		if (!empty($data["deliver_setup"])) {
			$deliver_setup = (int)$data["deliver_setup"];
			if ($deliver_setup > 0) {
				$deliver_setup--;
				$clause .= " AND a.deliver_setup = $deliver_setup ";
				$clause2 .= " AND deliver_setup = $deliver_setup ";
			}
		}

		if (empty($data["date_start"])) {
			$data["date_start"] = date("Y-m-d", time() - 86400);
		}
		$date_start = strtotime(trim($data["date_start"]) . " 00:00:00");
		if (!empty($date_start)) {
			$clause .= " AND a.createdate >= $date_start ";
			$clause2 .= " AND createdate >= $date_start ";
		}

		if (empty($data["date_end"])) {
			$data["date_end"] = date("Y-m-d", time());
		}
		$date_end = strtotime(trim($data["date_end"]) . " 23:59:59");
		if (!empty($date_end)) {
			$clause .= " AND a.createdate <= $date_end ";
			$clause2 .= " AND createdate <= $date_end ";
		}
		if (!empty($data["status_code"])) {
			$status_code = (int)$data["status_code"];
			if ($status_code > 0) {
				$clause .= " AND a.bn_status_code = $status_code ";
				$clause2 .= " AND bn_status_code = $status_code ";
			}
		}
		if (!empty($data["sel_lc_code"])) {
			$sel_lc_code = trim($data["sel_lc_code"]);
			if (!empty($sel_lc_code)) {
				$clause .= " AND b.lc_code LIKE '%$sel_lc_code%' ";
			}
		}

		if (!empty($data["url_type"])) {
			$url_type = (int)$data["url_type"];
			if ($url_type == 2) {
				$clause .= " AND c.url_type = $url_type ";
			} elseif ($url_type == 1) {
				$clause .= " AND c.url_type IS NULL ";
			} elseif ($url_type == 0) {
				$clause .= " AND 1=1 ";
			}
		}

		$time_difference = floor(($date_end - $date_start) / 86400);

		if ($time_difference <= '90') {

			$sql = "SELECT a.bn_master_id FROM bn_master as a $clause2 ORDER BY a.createdate DESC";
			$result = $GLOBALS['DB']->get_query_result($sql, false);

			$bn_master_id = '';
			if (!empty($result)) {
				for ($i = 0; $i < count($result); $i++) {
					$bn_master_id .= "'" . $result[$i]['bn_master_id'] . "',";
				}
				$bn_master_id = substr($bn_master_id, 0, -1);

				$sql = "
							SELECT c.url_type,a.*
							FROM bn_master AS a RIGHT JOIN bn_eod AS b 
							ON a.bn_master_id = b.bn_master_id LEFT JOIN
							api_skyeyes_url as c ON a.bn_no = c.bn_no
							$clause and a.bn_master_id in ($bn_master_id) 
							GROUP BY b.bn_master_id 
							ORDER BY a.createdate DESC LIMIT $start, $num_per_page";
				$result = $GLOBALS['DB']->get_query_result($sql, false);

				$sql = "SELECT b.bn_master_id as num,bn_volume FROM bn_master AS a RIGHT JOIN bn_eod AS b ON a.bn_master_id = b.bn_master_id LEFT JOIN
							api_skyeyes_url as c ON a.bn_no = c.bn_no $clause  and a.bn_master_id in ($bn_master_id) GROUP BY b.bn_master_id ";
				$num = $GLOBALS['DB']->get_query_result($sql, false);
				$total_v = 0;
				if (!empty($num)) {
					foreach ($num as $key => $value) {
						$total_v += $value["bn_volume"];
					}
				} else {
					$num = 0;
				}
			} else {
				$num = 0;
				$total_v = 0;
				$result = 'error';
			}
		} else {
			$num = 0;
			$total_v = 0;
			echo '<script>alert("EDI日期：起始時間與結束時間不得超過三個月!!!");</script>';
			// $result = 'EDI日期：起始時間與結束時間不得超過三個月!!!';
		}


		return array($result, count($num), $total_v);
	}



	// **************************************************************************
	//  函數名稱: edit_apply()
	//  函數功能: 更新廢四機列印狀態
	//  使用方式: 
	//  備    註: 
	//  程式設計: HAO
	//  設計日期: 2023.06.13
	// **************************************************************************

	function edit_apply($data)
	{

		$machine_recycle  = strtoupper($data['machine_no']);

		if (!empty($machine_recycle)) {
			$sql = "UPDATE api_momo_machine_data SET print = '0' WHERE recycle4No = '{$machine_recycle}'";
			$GLOBALS['DB']->query($sql);
		}
	}

	// **************************************************************************
	//  函數名稱: search_momo_do()
	//  函數功能: 搜尋 momo 正物流編號
	//  使用方式: 
	//  備    註: 
	//  程式設計: 洪梓誠
	//  設計日期: 2023.10.02
	// **************************************************************************
	function search_momo_do($bn_no)
	{
		$sql = "SELECT mr.order_no,md.order_no AS do_order_no,md.customer_order_no FROM (SELECT SUBSTRING(order_no,1,14) AS ro_no ,order_no FROM momo_ro) AS mr LEFT JOIN momo_do AS md ON mr.ro_no = md.customer_order_no WHERE mr.order_no = '{$bn_no}'";
		return $GLOBALS['DB']->get_query_result($sql, true);
	}


	// **************************************************************************
	//  函數名稱: bn_status_edit()
	//  函數功能: 修改貨態
	//  使用方式: 讓使用者可以自行修改
	//  備    註: 測試
	//  程式設計: 洪梓誠
	//  設計日期: 2023.09.20
	// **************************************************************************
	function bn_status_edit($data)
	{
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		if (!empty($data["bn_no"])) {
			$bn_no = $data["bn_no"];
			$sql = "SELECT * FROM bn_master WHERE bn_no = '$bn_no' ";


			return $GLOBALS['DB']->get_query_result($sql, false);
		}
	}
	function bn_status_edit1($id)
	{
		$sql = "SELECT * FROM bn_master WHERE bn_master_id = '$id' ";
		// $result = $GLOBALS['DB']->get_query_result($sql, false);
		$result = $GLOBALS['DB']->get_query_result($sql, false);
		return $result;
	}

	function status_list($id)
	{
		$status_id = (int)$id;
		$sql = "SELECT * FROM eod_status where status_code = '$status_id' ";
		return  $GLOBALS['DB']->get_query_result($sql, false);
	}

	function edit_status($data)
	{
		// $GLOBALS['DB']->autocommit();

		$edit_id = (int)$data['edit_id'];
		$edit_no = htmlspecialchars(trim($data['edit_no']));
		$edit_status_code = htmlspecialchars(trim($data['edit_status_code']));
		$edit_status_name = htmlspecialchars(trim($data['edit_status_name']));
		$edit_type = (int)$data['edit_type'];
		$cargo_code = htmlspecialchars(trim($data['cargo_code']));

		$edit_time = time();
		$edit_user = htmlspecialchars(trim($_SESSION["emp_name"]));
		// 更改 bn_sod
		$search_bn_sod_status_sql = "SELECT a.bn_type,a.cargo_id,b.bn_status_code,b.bn_status,b.createdate FROM 
		bn_master as a 
		LEFT JOIN bn_sod as b 
		ON a.bn_master_id = b.bn_master_id 
		WHERE a.bn_master_id = $edit_id
		ORDER BY createdate DESC";

		$result = $GLOBALS['DB']->get_query_result($search_bn_sod_status_sql, false);

		$ORI_bn_type = (int)$result[0]['bn_type'];
		$cargo_id = (int)$result[0]['cargo_id'];
		$ORI_status_code = htmlspecialchars(trim($result[0]['bn_status_code']));
		$ORI_status = htmlspecialchars(trim($result[0]["bn_status"]));	// bn_sod最新一筆的貨態說明 (修改前貨態說明)
		$sod_createdate = $result[0]["createdate"];	// bn_sod最新一筆的訂單


		$search_dispatch_detail_sql = "SELECT * FROM dispatch_detail where bn_master_id = $edit_id ORDER BY create_date DESC";
		$dispatch_result = $GLOBALS['DB']->get_query_result($search_dispatch_detail_sql, false);
		$dispatch_date = htmlspecialchars(trim($dispatch_result[0]['create_date']));


		// // 更改 bn_master
		$sql = "UPDATE bn_master SET
						bn_status_code = '$edit_status_code',
						bn_status = '$edit_status_name',
						bn_type = '$edit_type',
						bn_status_time = '$edit_time',
						createuser = '$edit_user'
				WHERE bn_master_id = $edit_id
		";

		$GLOBALS['DB']->query($sql);

		// // 更改 dispatch_detail
		$sql = "UPDATE dispatch_detail SET
						bn_status_code = '$edit_status_code',
						bn_status = '$edit_status_name'
				WHERE bn_master_id = $edit_id AND create_date = $dispatch_date

		";
		$GLOBALS['DB']->query($sql);

		// // 更改 bn_sod
		if ($cargo_code != 'MOMO') {
			$sql = "UPDATE bn_sod SET
						bn_status_code = '$edit_status_code',
						bn_status = '$edit_status_name(原$ORI_status)',
						updatedate = '$edit_time',
						updateuser = '$edit_user'
				WHERE bn_master_id = $edit_id AND createdate = $sod_createdate
			";
			$GLOBALS['DB']->query($sql);
		} else {
			$sql = "UPDATE bn_sod SET
							bn_status_code = '$edit_status_code',
							bn_status = '$edit_status_name(原$ORI_status)',
							updatedate = '$edit_time',
							createuser = '$edit_user',
							status_send = '0'
					WHERE bn_master_id = $edit_id AND createdate = $sod_createdate
			";
			$GLOBALS['DB']->query($sql);
		}
		$sql = "INSERT INTO `bn_status_log`( 
		`bn_no`, 
		`bn_status_code_now`, 
		`bn_status_name_now`, 
		`bn_status_time_now`, 
		`bn_type_now`, 
		`bn_status_code_before`, 
		`bn_status_name_before`, 
		`bn_status_time_before`, 
		`bn_type_before`, 
		`cargo_id`,
		`createuser`, 
		`createdate` ) 
		VALUES ( 
		'$edit_no',
		'$edit_status_code',
		'$edit_status_name',
		'$dispatch_date',
		 $edit_type,
		'$ORI_status_code',
		'$ORI_status',
		'$dispatch_date',
		 $ORI_bn_type,
		 $cargo_id,
		'$edit_user',
		 (SELECT NOW())
		 )
		";
		$GLOBALS['DB']->query($sql);
		// return $sql;
	}

	function phone_sod($data)
	{
		$sql = "SELECT * FROM bn_master WHERE bn_no = '$data' ";
		$result = $GLOBALS['DB']->get_query_result($sql, false);
		return $result;
	}
}
