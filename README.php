	<?php
	error_reporting("0");
	/*
		 channel : @source_home  کانال سورس خونه پر از سورس های ربات
	*/
	//--------------------------------------------------------------
	//Add Your Bot Token :
	define('API_KEY','742905448:AAEsj2hzXdXMBFkNVSX9krejh_e2Bffm2gQ');
	//--------------------------------------------------------------
	//Function Curl :
	function Telegram($method,$datas=[]){
		$url = "https://api.telegram.org/bot".API_KEY."/".$method;
		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
		$res = curl_exec($ch);
		if(curl_error($ch)){
			var_dump(curl_error($ch));
		}else{
			return json_decode($res);
		}
	}
	//--------------------------------------------------------------
	//Update Telegram :
	$update = json_decode(file_get_contents('php://input'));
	$message = $update->message;
	$from_id = $message->from->id;
	$chat_id = $message->chat->id;
	$message_id = $message->message_id;
	$first_name = $message->from->first_name;
	$last_name = $message->from->last_name;
	$username = $message->from->username;
	$textmassage = $message->text;
	$chat_id2= $update->callback_query->message->chat->id;
	$from_id2 = $update->callback_query->from->id;
	$data = $update->callback_query->data;
	$first_name2 = $update->callback_query->message->chat->first_name;
	$user_name2= $update->callback_query->message->chat->username;
	$message_id2 = $update->callback_query->message->message_id;
	$chattype= $update->message->chat->type;
	$reply= $update->message->reply_to_message;
	$replymessageid = $update->message->reply_to_message->message_id;
	$replyfromid = $update->message->reply_to_message->from->id;
	$edit = $update->edited_message;
	$message_edit_id = $update->edited_message->message_id;
	$chat_edit_id = $update->edited_message->chat->id;
	$users = json_decode(file_get_contents("users.json"),true);
	$photonumber = $users[$from_id]["photonumber"];
	$photonumber2 = $users[$from_id2]["photonumber"];
	$step= $users[$from_id]["step"];
	$Dev = 663739433;
	$web = "https://site.com/photobot";
	$channel = "userchannel";
	//--------------------------------------------------------------
	//Functions :
	function SendMessage($chat_id, $text){
	Telegram('sendMessage',[
	'chat_id'=>$chat_id,
	'text'=>$text,
	'parse_mode'=>'MarkDown']);
	}
	function save($filename, $data){
	$file = fopen($filename, 'w');
	fwrite($file, $data);
	fclose($file);
	}
	function sendAction($chat_id, $action){
	Telegram('sendChataction',[
	'chat_id'=>$chat_id,
	'action'=>$action]);
	}
	function Forward($berekoja,$azchejaei,$kodompayam)
	{
	Telegram('ForwardMessage',[
	'chat_id'=>$berekoja,
	'from_chat_id'=>$azchejaei,
	'message_id'=>$kodompayam
	]);
	}
	
function infophoto($amar){
	header('Content-type: image/png');
	$im = imagecreatetruecolor(3000, 3000);
	$white = imagecolorallocate($im, 255, 255, 255);
	imagefill($im, 0, 0,$white);
	$black = imagecolorallocate($im, 300, 300, 300);
	$font = 'font.ttf';
	$fontSize=150;
	$top=90;
	$text = "
PhotoEffect Bot Information : 
------------------------
Users : $amar
Users Block : 0
version Bot : 1.0
------------------------
photo
";
	imagettftext($im, $fontSize, 0, 11, ($top-1), $black, $font, $text);
	imagettftext($im, $fontSize, 0, 11, $top, $black, $font, $text);
	imagepng($im);
	imagedestroy($im);
	}
	//--------------------------------------------------------------
	if($textmassage=="/start" && $chattype == "private"){
	if($users[$from_id] == null){
		$users[$from_id]["step"] = "none";
		$users[$from_id]["photonumber"] = "";
		file_put_contents("users.json",json_encode($users));
	  }
			sendAction($chat_id, 'typing');
		Telegram('sendmessage',[
		'chat_id'=>$chat_id,
			'text'=>"سلام دوستم گلم🌹
	به ربات `افکت گزاری تصاویر` خوش اومدی برای افکت تصاویر لطفا عکس خود را بفرستید.",
			'parse_mode'=>'MarkDown',
	'reply_markup'=>json_encode([
		'resize_keyboard'=>true,
		'inline_keyboard'=>[
		 [
						['text' => "کانال ما", 'https://telegram.me/mgh_team' => '$channel']
					],
					[
						['text' => "اشتراک من با دیگران", 'switch_inline_query' => 'ads']
					],
		]
		])
		
		]);
		}
		if($update->message->photo && $chattype == "private"){
			if($users[$from_id]["photonumber"] != ""){
	unlink("photo/$photonumber.jpg");
	  }
			$rand = rand(1,999999);
		   $users[$from_id]["photonumber"] = "$rand";
		  file_put_contents("users.json",json_encode($users));
			$photo = $update->message->photo;
			$file = $photo[count($photo) - 1]->file_id;
			$get = Telegram('getfile', [
			'file_id' => $file
			]);
			$patch = $get->result->file_path;
			file_put_contents("photo/$rand.jpg", file_get_contents("https://api.telegram.org/file/bot" . API_KEY . "/$patch"));
		Telegram('sendmessage',[
		'chat_id'=>$chat_id,
			'text'=>"خب تصویر شما برای انجام افکت گزاری اماده است لطفا یکی از افکت ها را درلیست زیر انتخاب کنید :",
		 'parse_mode'=>'MarkDown',
 'reply_markup'=>json_encode([
  'resize_keyboard'=>true,
  'inline_keyboard'=>[
  [['text' => "boost", 'callback_data' => 'boost'],['text' => "bubbles", 'callback_data' => 'bubbles']],
  [['text' => "colorise", 'callback_data' => 'colorise'],['text' => "sepia", 'callback_data' => 'sepia']],
  [['text' => "sepia2", 'callback_data' => 'sepia2'],['text' => "sharpen", 'callback_data' => 'sharpen']],  
  [['text' => "emboss", 'callback_data' => 'emboss'],['text' => "cool", 'callback_data' => 'cool']],    
  [['text' => "old", 'callback_data' => 'old'],['text' => "old2", 'callback_data' => 'old2']],    
  [['text' => "old3", 'callback_data' => 'old3'],['text' => "light", 'callback_data' => 'light']],   
[['text'=>"aqua",'callback_data'=>'aqua'],['text'=>"boost2",'callback_data'=>'boost2']],
[['text'=>"gray",'callback_data'=>'gray'],['text'=>"antiaue",'callback_data'=>'antique']],
[['text'=>"blackwhite",'callback_data'=>'blackwhite'],['text'=>"blur",'callback_data'=>'blur']],
[['text'=>"vintage",'callback_data'=>'vintage'],['text'=>"concentrate",'callback_data'=>'concentrate']],
[['text'=>"everglow",'callback_data'=>'everglow'],['text'=>"freshblue",'callback_data'=>'freshblue']],
[['text'=>"tender",'callback_data'=>'tender'],['text'=>"dream",'callback_data'=>'dream']],
[['text'=>"frozen",'callback_data'=>'frozen'],['text'=>"forest",'callback_data'=>'forest']],
[['text'=>"rain",'callback_data'=>'rain'],['text'=>"orangepeel",'callback_data'=>'orangepeel']],
[['text'=>"darken",'callback_data'=>'darken'],['text'=>"summer",'callback_data'=>'summer']],
[['text'=>"retro",'callback_data'=>'retro'],['text'=>"country",'callback_data'=>'country']],
[['text'=>"washed",'callback_data'=>'washed']], 
		]
		])
		
		]);
		}
		
		 if(isset($data)) {
		    
	Telegram('answercallbackquery', [
			'callback_query_id' => $update->callback_query->id,
			'text' => "در حال اعمال افکت..."
		]);
		sendAction($chat_id2, 'upload_photo');
				Telegram('sendPhoto',[
	 'chat_id' =>$from_id2,
	 'photo' =>"$web/?filter=$data&url=http://irantm.tk/boteffect/photo/$photonumber2.jpg"
	
	 ]);
	}
	elseif ($update->inline_query->query == "ads") {
   Telegram('answerInlineQuery', [
        'inline_query_id' => $update->inline_query->id,
        'results' => json_encode([[
            'type' => 'article',
             'thumb_url'=>"http://uupload.ir/files/6pg_images.jpg",
            'id' => base64_encode(rand(5, 555)),
            'title' => 'بنر تبلیغاتی',
            'input_message_content' =>[
            'parse_mode' => 'MarkDown',
            'message_text' => "ربات افکت گزاری تصاویر 
					دارای افکت های بسیار زیبا
					میخوای عکستو افکت گزاری کنی پس بزن بریم
		➖➖➖"
		],
            'reply_markup' => [
                'inline_keyboard' => [
                    [
                        ['text' => "عضویت در ربات", 'url' => '$channel']
                    ],
                    [
                        ['text' => "اشتراک با دیگران", 'switch_inline_query' => 'ads']
                    ]
                ]
            ]
        ]])
    ]);
}   
$users = file_get_contents('users.txt');
$members = explode("\n", $users);
if (!in_array($from_id, $members)) {
    $adduser = file_get_contents('users.txt');
    $adduser .= $from_id . "\n";
    file_put_contents('users.txt', $adduser);
}
elseif($textmassage=="/botinfo"  && $from_id== $Dev){
$txtt = file_get_contents('users.txt');
$membersidd= explode("\n",$txtt);
                        $mmemcount = count($membersidd) -1;
$s= infophoto($mmemcount);
  file_put_contents('users.jpg',"$s");
                      
            sendAction($chat_id2, 'upload_photo');
				
		}
elseif($textmassage=="/forwardtoall" && $from_id== $Dev){
        $users[$from_id]["step"] = "forward";
		file_put_contents("users.json",json_encode($users));
	   	Telegram('sendmessage',[
		'chat_id'=>$chat_id,
			'text'=>"پیام خود را بفرستید :",
			'parse_mode'=>'MarkDown',
		
		]);

}elseif ($step == "forward") {
SendMessage($chat_id,"در حال ارسال...");
$mem = fopen( "users.txt", 'r');
    while( !feof( $mem)) {
    $memuser = fgets( $mem);
Forward($memuser, $chat_id,$message_id);
    }
	       $users[$from_id]["step"] = "none";
		file_put_contents("users.json",json_encode($users));
		SendMessage($chat_id,"ارسال شد.");
}  
elseif($textmassage=="/sendtoall" && $from_id== $Dev){
        $users[$from_id]["step"] = "sendtoall";
		file_put_contents("users.json",json_encode($users));
	   	Telegram('sendmessage',[
		'chat_id'=>$chat_id,
			'text'=>"پیام خود را بفرستید :",
			'parse_mode'=>'MarkDown',
		
		]);

}elseif ($step == "sendtoall") {
SendMessage($chat_id,"در حال ارسال...");
$mem = fopen( "users.txt", 'r');
    while( !feof( $mem)) {
    $memuser = fgets( $mem);
SendMessage($memuser,"$textmassage");
    }
	       $users[$from_id]["step"] = "none";
		file_put_contents("users.json",json_encode($users));
		SendMessage($chat_id,"ارسال شد.");
} 
