<?php
define('API_KEY','742905448:AAEsj2hzXdXMBFkNVSX9krejh_e2Bffm2gQ');
//----######------

function makereq($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

//##############=--API_REQ
function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }

  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }

  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = "https://api.telegram.org/bot".API_KEY."/".$method.'?'.http_build_query($parameters);

  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);

  return exec_curl_request($handle);
}

//----######------
//---------
$update = json_decode(file_get_contents('php://input'));
var_dump($update);
//=========
$chat_id = $update->message->chat->id;
$message_id = $update->message->message_id;
$from_id = $update->message->from->id;
$name = $update->message->from->first_name;
$username = $update->message->from->username;
$textmessage = isset($update->message->text)?$update->message->text:'';
$reply = $update->message->reply_to_message->forward_from->id;
$stickerid = $update->message->reply_to_message->sticker->file_id;
$photo = $update->message->photo;
$video = $update->message->video;
$sticker = $update->message->sticker;
$file = $update->message->document;
$music = $update->message->audio;
$voice = $update->message->voice;
$forward = $update->message->forward_from;
$step = file_get_contents("data/$from_id/step.txt");
$ax = file_get_contents("data/$from_id/ax.txt");
$matn = file_get_contents("data/$from_id/matnesh.txt");
$loca = file_get_contents("data/$from_id/loc.txt");
$font = file_get_contents("data/$from_id/size.txt");
$rang = file_get_contents("data/$from_id/color.txt");
$time = file_get_contents("https://provps.ir/td/?td=time");
$date = file_get_contents("https://provps.ir/td/?td=date");
$dafeat = file_get_contents("data/$from_id/dafe.txt");
//-------
function SendMessage($ChatId, $TextMsg)
{
 makereq('sendMessage',[
'chat_id'=>$ChatId,
'text'=>$TextMsg,
'parse_mode'=>"MarkDown"
]);
}
function SendSticker($ChatId, $sticker_ID)
{
 makereq('sendSticker',[
'chat_id'=>$ChatId,
'sticker'=>$sticker_ID
]);
}
function Forward($KojaShe,$AzKoja,$KodomMSG)
{
makereq('ForwardMessage',[
'chat_id'=>$KojaShe,
'from_chat_id'=>$AzKoja,
'message_id'=>$KodomMSG
]);
}

function save($filename,$TXTdata)
	{
	$myfile = fopen($filename, "w") or die("Unable to open file!");
	fwrite($myfile, "$TXTdata");
	fclose($myfile);
	}
//===========Code Writing==================//


if($textmessage == '/start')
{
if (!file_exists("data/$from_id/step.txt")) {
mkdir("data/$from_id");
save("data/$from_id/step.txt","none");
save("data/$from_id/dafe.txt","1");
$myfile2 = fopen("data/users.txt", "a") or die("Unable to open file!");	
fwrite($myfile2, "$from_id\n");
}
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"سلام $name عزیز😃
من یک ربات هستم که توانایی دارم متن شما رو بچسبونم روی عکس😌
کاربا من خیلی اسونه.😝
موفق باشی😅",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"شروع به کار"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
}
elseif($textmessage == "شروع به کار"){
file_put_contents("data/$from_id/step.txt","c1");
makereq('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"خب دوست عزیز این مرحله یک هستش. یعنی باید عکس خودتون رو ارسال کنید",
 'parse_mode'=>"MarkDown",
      'reply_markup'=>json_encode([
            'keyboard'=>[
              [
              ['text'=>"برگشت"]
              ]
              ]
        ])
 ]);
}
elseif($step == "c1"){
if(isset($update->message->photo)){
$phot = $update->message->photo;
$fil = $phot[count($phot)-1]->file_id;
      $get = makereq('getfile',['file_id'=>$fil]);
      $patch = $get->result->file_path;
file_put_contents("data/$from_id/step.txt","c2");
save("data/$from_id/ax.txt", 'https://api.telegram.org/file/bot'.API_KEY.'/'.$patch);
	  sendMessage($chat_id,"خب رفتیم به مرحله دوم توی این مرحله شما باید متن خودتون رو ارسال کنید تا متن بزارمش روی عکس
	 `توجه داشته باشید به علت محدودیت باید متن شما انگلیسی باشد`");
}    }
elseif($step == "c2"){
	save("data/$from_id/matnesh.txt","$textmessage");
file_put_contents("data/$from_id/step.txt","c3");
makereq('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"خب رفتیم مرحله سوم توی این مرحله باید مکان عکست رو انتخاب کنی
 bottomright = پایین راست
 topleft = بالا چپ
 topright = بالا راست
 bottomleft = پایین چپ
 ",
 'parse_mode'=>"MarkDown",
   'reply_markup'=>json_encode([
   'keyboard'=>[
   [
   ['text'=>"bottomright"],['text'=>"topleft"]
   ],
   [
   ['text'=>"topright"],['text'=>"bottomleft"]
   ]
   ]
   ])
   ]);
}
elseif($step == "c3"){
    save("data/$from_id/loc.txt","$textmessage"); 
file_put_contents("data/$from_id/step.txt","c4");
makereq('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"خب رفتیم به مرحله سوم توی این مرحله باید سایز متنت رو انتخاب کنی♥",
 'parse_mode'=>"MarkDown",
   'reply_markup'=>json_encode([
   'keyboard'=>[
[
['text'=>'11'],['text'=>'12'],['text'=>'13'],['text'=>'14'],['text'=>'15']
],
[
['text'=>'16'],['text'=>'17'],['text'=>'18'],['text'=>'19'],['text'=>'20']
],
[
['text'=>'21'],['text'=>'22'],['text'=>'23'],['text'=>'24'],['text'=>'25']
],
[
['text'=>'26'],['text'=>'27'],['text'=>'28'],['text'=>'29'],['text'=>'30']
],
[
['text'=>'31'],['text'=>'32'],['text'=>'33'],['text'=>'34'],['text'=>'35']
],
[
['text'=>'36'],['text'=>'37'],['text'=>'38'],['text'=>'39'],['text'=>'50']
]
   ],
   'resize_keyboard'=>true
   ])
   ]);
}
elseif($step == "c4"){
    save("data/$from_id/size.txt","$textmessage");
file_put_contents("data/$from_id/step.txt","c5");
makereq('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"خب رسیدیم به مرحله اخر توی این مرحله بتیئ رنگت رو انتخاب کنی.
 رنگت رو باید به صورت
 `1bbc9b`
 بفرستی
 برای دریافت این کد ها میتونی به سایت زیر مراجعه کنی:
 به یاد داشته باش که نباید # رو ارسال کنی
 http://flatcolor.ir
 چند رنگ پیشنهادی:
 59abe3 = ابی
 bf55ec = بنفش
 F9690E = نارنجی
 2c3e50 = سرمه ای",
 'parse_mode'=>"MarkDown",
   /*'reply_markup'=>json_encode([
   'keyboard'=>[
[
['text'=>'بساز']
]
   ],
   'resize_keyboard'=>true
   ])*/
   ]);
   }
   elseif($step == "c5"){
       save("data/$from_id/color.txt","$textmessage");
	file_put_contents("data/$from_id/step.txt","none");
makereq('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"خب حالا بزن روی دکمه زیر تا عکستو تحویل بدمت 😅",
 'parse_mode'=>"MarkDown",
   'reply_markup'=>json_encode([
   'keyboard'=>[
[
['text'=>'بساز']
]
   ],
   'resize_keyboard'=>true
   ])
   ]);
   }
   elseif($textmessage == "بساز" and $step == "none"){
file_put_contents("data/$from_id/step.txt","none");
$new = $dafeat + 1;
save("data/$from_id/dafe.txt",$new);
save("data/dafe.txt",$new);
makereq('sendPhoto',[
 'chat_id'=>$chat_id,
 'photo'=>"https://api.feelthecode.xyz/copyright/?image=$ax&text=$matn&location=$loca&fontsize=$font&color=$rang",
 'parse_mode'=>"MarkDown",
   'reply_markup'=>json_encode([
   'keyboard'=>[
[
['text'=>'برگشت']
]
   ],
   'resize_keyboard'=>true
   ])
   ]);
   makereq('sendMessage',[
 'chat_id'=>$chat_id,
 'text'=>"هم اکنون زمان و تاریخ:
     $time - $date
     و تعداد دفعات استفاده شما:
         $dafeat",
 'parse_mode'=>"MarkDown",
   'reply_markup'=>json_encode([
   'keyboard'=>[
[
['text'=>'برگشت']
]
   ],
   'resize_keyboard'=>true
   ])
   ]);
   }
   elseif($textmessage == "برگشت"){
	file_put_contents("data/$from_id/step.txt","none");
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"سلام $name عزیز😃
من یک ربات هستم که توانایی دارم متن شما رو بچسبونم روی عکس😌
کاربا من خیلی اسونه.😝
موفق باشی😅",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"شروع به کار"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
   }
   elseif($text == "/smart"){
        makereq('sendmessage', [
                'chat_id' => $chat_id,
                'text' =>"ادمین عزیز به پنل مدیریتی ربات خودش امدید",
                'parse_mode'=>'html',
      'reply_markup'=>json_encode([
            'keyboard'=>[
              [
              ['text'=>"آمار"],['text'=>""]
              ],
              ],'resize_keyboard'=>true
        ])
            ]);
        }
elseif($textmessage == "/panel" && $from_id == $admin){
        makereq('sendmessage', [
                'chat_id' => $chat_id,
                'text' =>"ادمین عزیز به پنل مدیریتی ربات خودش امدید",
                'parse_mode'=>'html',
      'reply_markup'=>json_encode([
            'keyboard'=>[
              [
              ['text'=>"آمار"],['text'=>""]
              ],
              ],'resize_keyboard'=>true
        ])
            ]);
        }
elseif($textmessage == "آمار" && $from_id == $admin){
    $user = file_get_contents("data/users.txt");
    $member_id = explode("\n",$user);
    $member_count = count($member_id) -1;
 sendmessage($chat_id , " آمار کاربران : $member_count" , "html");
}
elseif($textmessage == "پیام همگانی" && $from_id == $admin){
    file_put_contents("data/$from_id/step.txt","bc");
 makereq('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>" پیام مورد نظر رو در قالب متن بفرستید:",
    'parse_mode'=>'html',
    'reply_markup'=>json_encode([
      'keyboard'=>[
   [['text'=>'/panel']],
      ],'resize_keyboard'=>true])
  ]);
}
elseif($step == "bc" ){
    file_put_contents("data/$from_id/step.txt","none");
 makereq('sendmessage',[
    'chat_id'=>$chat_id,
    'text'=>" پیام همگانی فرستاده شد.",
  ]);
 $all_member = fopen( "data/users.txt", "r");
  while( !feof( $all_member)) {
    $user = fgets( $all_member);
   SendMessage($user,$text,"html");
  }
}
?>

