<?php
//ini_set('display_errors', 0);

$API_TOKEN = "kKJK7YEpjJtUys1IQVn0DeKbaTPbEzSOgfS2TCGf";
$SUB_DOMAIN = "mkh90";
$APP_NO = 14;
// ������kintone�̐ݒ�
define($API_TOKEN, "");
define($SUB_DOMAIN, "");
define($APP_NO, "1");
//�T�[�o���M����HTTP�w�b�_��ݒ�
$options = array(
		'http'=>array(
				'method'=>'GET',
				'header'=> "X-Cybozu-API-Token:". $API_TOKEN ."\r\n"
		)
);
//�R���e�L�X�g�𐶐�
$context = stream_context_create( $options );
// �T�[�o�ɐڑ����ăf�[�^��Ⴄ
$contents = file_get_contents( 'https://'. $SUB_DOMAIN .'.cybozu.com/k/v1/records.json?app='. $APP_NO , FALSE, $context );
//var_dump($http_response_header); //�w�b�_�\��

//JSON�`������Array�ɕϊ�
$data = json_decode($contents, true);
//�\���͒P���ȃe�[�u����



//echo count($data['records']);
//�S���ҁC��ƎҁC�^�X�N�̐��C
//*�^�X�N�̐����I���̂͏Ȃ�
//var_dump($data);
$n=0;
$task_data = array();
for($i=0; $i<count($data['records']); $i++){

	var_dump($task_data);
	
//	echo $data["records"]["�S����"]["value"]["name"];
//	echo $data["records"][$i]["Assignees"]["value"][0]["name"];//�S����
	echo "<br>";
	echo $data["records"][$i]["Worker"]["value"][0]["name"];//��Ǝ�
	echo $data["records"][$i]["Worker"]["value"][0]["code"];//�p��
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