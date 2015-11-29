<?php
//ini_set('display_errors', 0);

$API_TOKEN = "kKJK7YEpjJtUys1IQVn0DeKbaTPbEzSOgfS2TCGf";
$SUB_DOMAIN = "mkh90";
$APP_NO = 14;
// 自分のkintoneの設定
define($API_TOKEN, "");
define($SUB_DOMAIN, "");
define($APP_NO, "1");
//サーバ送信するHTTPヘッダを設定
$options = array(
		'http'=>array(
				'method'=>'GET',
				'header'=> "X-Cybozu-API-Token:". $API_TOKEN ."\r\n"
		)
);
//コンテキストを生成
$context = stream_context_create( $options );
// サーバに接続してデータを貰う
$contents = file_get_contents( 'https://'. $SUB_DOMAIN .'.cybozu.com/k/v1/records.json?app='. $APP_NO , FALSE, $context );
//var_dump($http_response_header); //ヘッダ表示

//JSON形式からArrayに変換
$data = json_decode($contents, true);
//表示は単純なテーブルで



//echo count($data['records']);
//担当者，作業者，タスクの数，
//*タスクの数→終了のは省く
//var_dump($data);
$n=0;
$task_data = array();
for($i=0; $i<count($data['records']); $i++){

	var_dump($task_data);
	
//	echo $data["records"]["担当者"]["value"]["name"];
//	echo $data["records"][$i]["Assignees"]["value"][0]["name"];//担当者
	echo "<br>";
	echo $data["records"][$i]["Worker"]["value"][0]["name"];//作業者
	echo $data["records"][$i]["Worker"]["value"][0]["code"];//英字
	echo "<br>";
	echo "task_data: ".count($task_data);
	echo "<br>";
	if(count($task_data)!==0){
		
		for($j=0; $j<count($task_data); $j++){
		var_dump($task_data);
			if($task_data[$j]['code'] == $data["records"][$i]["Worker"]["value"][0]["code"]){
				$num = array(array(2=>$task_data[$j]["task_num"]+1));
				array_replace(array($task_data, $num));
				echo $task_data[$i]["task_num"]."times";
			}else{
			$task_data = array_push($task_data,
						array("worker" => $data["records"][$i]["Worker"]["value"][0]["name"],
								"code" => $data["records"][$i]["Worker"]["value"][0]["code"], "task_num"=>1));
			echo $task_data[$j]["task_num"]."times";
				}
			}
		
	}else{
		array_push($task_data,
				array("worker" => $data["records"][$i]["Worker"]["value"][0]["name"],
						"code" => $data["records"][$i]["Worker"]["value"][0]["code"], "task_num"=>1));
	}
}
		
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
</head>
<body>

</body>

</html>


<!--  
<script type="text/javascript">
	var hoge = <?php echo json_encode($hoge); ?>;
</script>
-->