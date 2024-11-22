<?php
require_once("../include/admin_header.php");
include(dirname(__FILE__) . "/class/class_bn_notice.php");
$GLOBALS['bn_notice'] = new bn_notice;
$date_start = (!empty($_GET['date_start'])) ? $_GET['date_start'] : date("Y-m-d", time() - 86400);
$date_end = (!empty($_GET['date_end'])) ? $_GET['date_end'] : date("Y-m-d", time());

$install_start = (!empty($_GET['install_start'])) ? $_GET['install_start'] : date("Y-m-d", time() - 86400);
$install_end = (!empty($_GET['install_end'])) ? $_GET['install_end'] : date("Y-m-d", time());
// $_GET["deliver_setup"] = 2;
list($bn_install_list, $GLOBALS['page_total_num']) = $GLOBALS["bn_notice"]->bn_install_list_isinstall($_GET, $GLOBALS['page'], $GLOBALS['page_num']);

$install_check = !empty($GET['install']) ? '1' : '2';
?>
<script>
	function show_bn(id, url) {
		$(".show_bn").html("<iframe src='" + url + ".php?id=" + id + "' width='100%' height='100%' ></iframe>");
	}

	function show_bn_status(id) {
		$(".show_bn_status").html("<iframe src='bn_show_status.php?id=" + id + "' width='100%' height='100%' ></iframe>");
	}

	function show_bn_install(id) {
		$(".show_bn_install").html("<iframe src='bn_show_install.php?id=" + id + "' width='100%' height='100%' ></iframe>");
	}

	function eod_export(status) {
		if (status == '1') {
			$("#form1").attr("action", "export_excel/export_install_date.php?install=1");
			$("#form1").submit();
		} else {
			$("#form1").attr("action", "export_excel/export_install_date.php");
			$("#form1").submit();
		}
	}

	function eod_export2(status) {
		if (status == '1') {
			$("#form1").attr("action", "export_excel/export_install_date_2.php?install=1");
			$("#form1").submit();
		} else {
			$("#form1").attr("action", "export_excel/export_install_date_2.php");
			$("#form1").submit();
		}
	}

	function search_submit() {
		$("#form1").attr("action", "");
		window.location.reload();
	}

	function edit_install_date(id) {
		var date = $("#" + id + "_install_date").val();
		// var cargo_code = $("#"+id+"_install_date").val();
		if (id > 0) {
			$.ajax({
				url: 'ajax/ajax_dispatch.php',
				type: 'GET',
				dataType: 'json',
				data: {
					status: "edit_install_date",
					id: id,
					install_date: date
				},
				error: function(xhr) {
					alert('失敗，稍後在試!');
				},
				success: function(Jdata) {
					location.reload();
				}
			});
		}
	}

	function search_install_note(id) {

		$.ajax({
			url: 'ajax/ajax_bn.php',
			type: 'GET',
			dataType: 'json',
			data: {
				status: "search_install_note",
				id: id
			},
			success: function(Jdata) {
				$("#edit_id").val(Jdata.bn_master_id);
				$("#edit_install_note").val(Jdata.install_note);
			}
		});
	}

	function edit_note() {
		var edit_id = $("#edit_id").val();
		var edit_install_note = $("#edit_install_note").val();

		if (edit_id > 0) {
			$.ajax({
				url: 'ajax/ajax_bn.php',
				type: 'GET',
				dataType: 'json',
				data: {
					status: "edit_note",
					edit_id: edit_id,
					edit_install_note: edit_install_note
				},
				error: function(xhr) {
					alert('修改失敗，稍後在試!');
				},
				success: function(Jdata) {
					location.reload();
				}
			});
		} else {
			alert("請輸入完整資料!!");
		}
	}
</script>
<style>
	.modal-dialog,
	.modal-content {
		height: calc(100% - 60px);
	}

	.modal-content2 {
		height: auto;
	}

	.modal-body {
		height: 100%;
	}
</style>
<div class="body">
	<table>
		<tr>
			<td align="left" style="font-size: 10px;">
				派車管理 → 預約安裝時間 (<?= constant($GLOBALS['lc_code']) ?>)
			</td>
			<td align="right">
				<a href="#" class="cssbutton btn-primary" onclick="eod_export(<?= $install_check ?>);">約配報表(全區)</a>
				<!-- <a href="#" class="cssbutton btn-primary" onclick="eod_export2(<?= $install_check ?>);">約配報表(全區)(MOMO版本)</a> -->
			</td>

		</tr>
	</table>
	<table>
		<hr size="8px" align="center" width="100%" style="margin-top: 3px; margin-top: 10px;">
		<form class="form-inline " action="" method="GET" id="form1">
			<input type="hidden" name="bn_mode" value="1">
			<tr class="form-size">
				<td width="6%" align="right">客戶單號：</td>
				<td width="8%" align="left">
					<input type="text" name="bn_no" value="<?= @$_GET['bn_no'] ?>">
				</td>
				<td width="5%" align="right">指送人：</td>
				<td width="8%" align="left">
					<input type="text" name="receiver_name" value="<?= @$_GET['receiver_name'] ?>">
				</td>
				<td width="7%" align="right">送貨單狀態：</td>
				<td width="8%" align="left">
					<select name="bn_type">
						<option value="0" <?= (@$_GET["bn_type"] == 0) ? "SELECTED" : "" ?>>所有狀態</option>
						<option value="1" <?= (@$_GET["bn_type"] == 1) ? "SELECTED" : "" ?>>車回</option>
						<option value="2" <?= (@$_GET["bn_type"] == 2) ? "SELECTED" : "" ?>>配送</option>
						<!-- <option value="3" <?= (@$_GET["bn_type"] == 3) ? "SELECTED" : "" ?> >配完</option>
					   		<option value="4" <?= (@$_GET["bn_type"] == 4) ? "SELECTED" : "" ?> >遺失</option>
					   		<option value="5" <?= (@$_GET["bn_type"] == 5) ? "SELECTED" : "" ?> >損壞</option>
					   		<option value="6" <?= (@$_GET["bn_type"] == 6) ? "SELECTED" : "" ?> >拒收</option>
					   		<option value="8" <?= (@$_GET["bn_type"] == 8) ? "SELECTED" : "" ?> >取消</option>
					   		<option value="9" <?= (@$_GET["bn_type"] == 9) ? "SELECTED" : "" ?> >自取</option> -->
					</select>
				</td>
				<td width="7%" align="right">列印：</td>
				<td width="8%" align="left">
					<select name="print_status">
						<option value="0" <?= (@$_GET["print_status"] == 0) ? "SELECTED" : "" ?>>所有</option>
						<option value="1" <?= (@$_GET["print_status"] == 1) ? "SELECTED" : "" ?>>N</option>
						<option value="2" <?= (@$_GET["print_status"] == 2) ? "SELECTED" : "" ?>>Y</option>
					</select>
				</td>
				<td width="6%" align="right">EDI日期：</td>
				<td width="8%" align="left">
					<input type="date" name="date_start" value="<?= $date_start ?>" size="10">
				</td>
				<td width="1%" align="left">
					~
				</td>
				<td width="8%" align="left">
					<input type="date" name="date_end" value="<?= $date_end ?>" size="10">
				</td>

				<td></td>
				<td align="center" width="5%" rowspan="2" style="text-align:center;vertical-align: middle;height: 60px;">
					<input type="submit" class="cssbutton" value="查詢" onclick="search_submit();">
				</td>
			</tr>
			<tr class="form-size">
				<td width="5%" align="right">客戶代號：</td>
				<td width="8%" align="left">
					<input type="text" name="cargo_code" value="<?= @$_GET['cargo_code'] ?>">
				</td>
				<td width="5%" align="right">收件人電話：</td>
				<td width="8%" align="left">
					<input type="text" name="receiver_phone" value="<?= @$_GET['receiver_phone'] ?>">
				</td>
				<td width="5%" align="right">收件人地址：</td>
				<td width="8%" align="left">
					<input type="text" name="receiver_addr" value="<?= @$_GET['receiver_addr'] ?>">
				</td>
				<td width="5%" align="right">配送類型：</td>
				<td width="8%" align="left">
					<select name="deliver_setup">
						<option value="0" <?= (@$_GET["deliver_setup"] == 0) ? "SELECTED" : "" ?>>所有</option>
						<option value="1" <?= (@$_GET["deliver_setup"] == 1) ? "SELECTED" : "" ?>>無安裝</option>
						<option value="2" <?= (@$_GET["deliver_setup"] == 2) ? "SELECTED" : "" ?>>要送要裝</option>
						<option value="3" <?= (@$_GET["deliver_setup"] == 3) ? "SELECTED" : "" ?>>只送不裝</option>
					</select>
				</td>
				<td width="5%" align="right">預約安裝日期：</td>
				<td width="8%" align="left">
					<?php if (!empty($_GET['install_start'])) { ?>
						<input type="date" name="install_start" value="<?= $install_start ?>" size="10">
					<?php } else { ?>
						<input type="date" name="install_start" size="10">
					<?php } ?>
				</td>
				<td width="1%" align="left">
					~
				</td>
				<td width="8%" align="left">
					<?php if (!empty($_GET['install_end'])) { ?>
						<input type="date" name="install_end" value="<?= $install_end ?>" size="10">
					<?php } else { ?>
						<input type="date" name="install_end" size="10">
					<?php } ?>
				</td>
			</tr>
		</form>
	</table>
	<div class="errormsg" id="errormsg" <?= (@$errormsg == "") ? "style='display:none'" : "" ?>><?= @$errormsg ?></div>
	<div class="free-line">
		<table class="table-list">
			<tr>
				<th>客戶代號</th>
				<th>客戶單號</th>
				<th>通知單狀態</th>
				<th>指送人</th>
				<th>電話</th>
				<th>送貨地址</th>
				<th>宅配安裝</th>
				<th>貨態代碼</th>
				<th>派車單號</th>
				<th>司機</th>
				<th>電話</th>
				<th>約配時間</th>
				<th>預約安裝時間</th>
				<th>預約人</th>
				<th>電聯約配/預約安裝</th>
				<th>備註</th>
				<th>約配安裝歷程</th>
			</tr>
			<?php
			if (!empty($bn_install_list)) {
				// print_r($bn_install_list);exit;
				if ($bn_install_list == 'error') {
				} else {
					foreach ($bn_install_list as $key => $value) {

						$name = "";
						$phone = "";
						$zip = "";
						$addr = "";
						// if($value["bn_mode"] == 2){
						// 	$name = $value["bn_deliver_name"];
						// 	$phone = $value["bn_deliver_phone"];
						// 	$zip = $value["bn_deliver_zip"];
						// 	$addr = $value["bn_deliver_addr"]; 
						// }else{
						// 	$name = $value["bn_receiver_name"];
						// 	$phone = $value["bn_receiver_phone"];
						// 	$zip = $value["bn_receiver_zip"];
						// 	$addr = $value["bn_receiver_addr"]; 
						// }

						if ($value["bn_mode"] == 2) {
							$name = $value["bn_deliver_name"];
							if (!empty($value["bn_deliver_phone"])) {
								$phone = $value["bn_deliver_phone"];
							} else {
								$phone = $value["bn_deliver_phone2"];
							}

							$zip = $value["bn_deliver_zip"];
							$addr = $value["bn_deliver_addr"];
						} else {
							$name = $value["bn_receiver_name"];
							if (!empty($value["bn_receiver_phone"])) {
								$phone = $value["bn_receiver_phone"];
							} else {
								$phone = $value["bn_receiver_phone2"];
							}
							$zip = $value["bn_receiver_zip"];
							$addr = $value["bn_receiver_addr"];
						}



						if ($value["bn_mode"] == 1) {
							if ($value["bn_status_code"] == '10004' || $value["bn_status_code"] == '99999') {
								$url = "bn_show_lss_S";
							} else {
								$url = "bn_show_lss";
							}
						} else {
							if ($value["bn_status_code"] == '10004' || $value["bn_status_code"] == '99999') {
								$url = "bn_show_nolss_S";
							} else {
								$url = "bn_show_nolss";
							}
						}

						$SHOW_name = '0';
						if (!empty($value["bn_status_time"]) && (time() >= strtotime("+14day", $value["bn_status_time"]) && ($value["cargo_code"] == 'WATER3F' || $value["cargo_code"] == 'SMITH') && ($value["bn_status_code"] == '10004' || $value["bn_status_code"] == '99999')) || (time() >= strtotime("+180day", $value["bn_status_time"]) && ($value["bn_status_code"] == '10004' || $value["bn_status_code"] == '99999'))) {
							if ($value["cargo_code"] != 'HOSHIZAKI') {
								//************bn_receiver_name
								$SHOW_name = strlen($name);
								$SHOW_name = $SHOW_name - 6;
								$name = substr($name, 0, $SHOW_name) . "ＸＸ";
								//************bn_receiver_name

								//************phone
								$phone = substr($phone, 0, 5) . "XXXXX";
								//************phone
								//
								////************zip
								$zip = substr($zip, 1, 3) . "X";
								//************zip

								//************bn_receiver_addr
								$addr = substr($addr, 0, 21) . "ＸＸＸＸＸＸ";
								//************bn_receiver_addr

								//************bn_vehdrv_name
								$value["vehdrv_name"] = substr($value["vehdrv_name"], 0, 3) . "ＸＸ";
								//************bn_vehdrv_name

								//************vehdrv_phone
								$value["vehdrv_phone"] = substr($value["vehdrv_phone"], 0, 5) . "XXXXX";
								//************vehdrv_phone

							}
						}

			?>
						<tr>
							<td><?= $value["cargo_code"] ?></td>
							<td><button class="cssbutton2" onclick="show_bn('<?= $value["bn_master_id"] ?>','<?= $url ?>');" data-toggle="modal" data-target="#show_bn"><?= $value["bn_no"] ?></button></td>
							<td><?= bn_type($value["bn_type"]) ?></td>
							<td><?= $name ?></td>
							<td><?= $phone ?></td>
							<td><?= $zip . $addr ?></td>
							<td><?= deliver_setup($value["deliver_setup"]) ?></td>
							<td><button class="cssbutton2" onclick="show_bn_status('<?= $value["bn_master_id"] ?>');" data-toggle="modal" data-target="#show_bn_status"><?= $value["bn_status"] ?></button></td>
							<td><?= $value["dispatch_no"] ?></td>
							<td><?= $value["vehdrv_name"] ?></td>
							<td><?= $value["vehdrv_phone"] ?></td>

							<td><?= $value["MAX(c.phone_time)"] ?></td>
							<td><input type="datetime-local" id="<?= $value["bn_master_id"] ?>_install_date" value="<?= $value["install_date"] ?>"></td>
							<td><?= $value["install_date_user"] ?></td>
							<td>
								<button type="button" class="cssbutton2" onclick="edit_install_date('<?= $value["bn_master_id"] ?>');">電聯約配/預約安裝</button>
							</td>
							<td><a href="#" class="cssbutton2" data-toggle="modal" data-target="#edit_note" onclick="search_install_note('<?= $value["bn_master_id"] ?>');">備註</a></td>
							<td><button class="cssbutton2" onclick="show_bn_install('<?= $value["bn_master_id"] ?>');" data-toggle="modal" data-target="#show_bn_install">約配安裝歷程</button></td>

						</tr>

			<?php
					}
				}
			}
			?>
		</table>
	</div>
	<?php require_once("../include/pager_nav.php"); ?>
</div>

<?php require_once("../include/admin_footer.php") ?>

<div class="modal fade" id="show_bn">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-body show_bn">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="show_bn_status">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-body show_bn_status">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="show_bn_install">
	<div class="modal-dialog modal-xl">
		<div class="modal-content">
			<div class="modal-body show_bn_install">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="edit_note">
	<div class="modal-dialog modal-xl">
		<div class="modal-content modal-content2">
			<div class="modal-header">
				<h6 class="modal-title">備註</h6>
			</div>
			<div class="modal-body">
				<table class="table-list2">
					<input type="hidden" id="edit_id" value="">
					<tr style="height: 40px;">
						<th><span class="txt_13_red">※</span>備註</th>
						<td><textarea rows="4" cols="80" id="edit_install_note"> <?= @$bn_master["install_note"] ?></textarea></td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<table>
					<tr align="center">
						<td><a href="#" class="cssbutton3" onclick="edit_note();">送出</a></td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>