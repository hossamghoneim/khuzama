<?php

if(!function_exists('make_slug')) {

    function make_slug($string = null, $separator = "-")
    {

        if (is_null($string)) {
            return "";
        }

        if (in_array(substr($string, -1), ['?', '!', '.'])) {

            $string = substr_replace($string, "", -1);
        }

        // Remove spaces from the beginning and from the end of the string
        $string = trim($string);

        // Lower case everything
        // using mb_strtolower() function is important for non-Latin UTF-8 string | more info: http://goo.gl/QL2tzK
        $string = mb_strtolower($string, "UTF-8");;

        // Make alphanumeric (removes all other characters)
        // this makes the string safe especially when used as a part of a URL
        // this keeps latin characters and arabic charactrs as well
        $string = preg_replace("/[^a-z0-9_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", "", $string);

        // Remove multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);

        // Convert whitespaces and underscore to the given separator
        $string = preg_replace("/[\s_]/", $separator, $string);


        return $string;
    }
}
if(!function_exists('make_slug_1')) {

    function make_slug_1($string = null, $separator = "_")
    {

        if (is_null($string)) {
            return "";
        }

        if (in_array(substr($string, -1), ['?', '!', '.'])) {

            $string = substr_replace($string, "", -1);
        }

        // Remove spaces from the beginning and from the end of the string
        $string = trim($string);

        // Lower case everything
        // using mb_strtolower() function is important for non-Latin UTF-8 string | more info: http://goo.gl/QL2tzK
        $string = mb_strtolower($string, "UTF-8");;

        // Make alphanumeric (removes all other characters)
        // this makes the string safe especially when used as a part of a URL
        // this keeps latin characters and arabic charactrs as well
        $string = preg_replace("/[^a-z0-9_\s-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", "", $string);

        // Remove multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);

        // Convert whitespaces and underscore to the given separator
        $string = preg_replace("/[\s_]/", $separator, $string);


        return $string;
    }
}


function generateIdentificationCode($for = null) {

    if($for === 'order'){

        return  'O'.\Carbon\Carbon::now()->timestamp; // better than rand()
    }
    if($for === 'batch'){

        return  'B'.\Carbon\Carbon::now()->timestamp; // better than rand()
    }

    return strtoupper(str_random(6)).'_'.\Carbon\Carbon::now()->timestamp;
}


if(!function_exists('bytesToHuman')) {
    /**
     * Return the given object. Useful for chaining.
     *
     * @param  string  $bytes
     * @return string;
     */
    function bytesToHuman($bytes)
    {

        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];

    }
}

function sendSMS($numbers,$message){


//إستدعاء ملف Web Service الخاص بالإرسال
$client = new SoapClient("https://www.mobilywebservices.com/SMSWebService/SMSIntegration.asmx?wsdl");

//تعريف الدوال اللازمه للإرسال
$mobile = "966503332220";							//رقم الجوال (إسم المستخدم) في موبايلي
$password = "bbcbbc99";							//كلمة المرور في موبايلي

$sender = "hdaia.co";					//اسم المرسل الذي سيظهر عند ارسال الرساله، ويتم تشفيره إلى  بشكل تلقائي إلى نوع التشفير (urlencode)

$numbers = "$numbers";							//يجب كتابة الرقم بالصيغة الدولية مثل 96650555555 وعند الإرسال إلى أكثر من رقم يجب وضع الفاصلة (,) وهي التي عند حرف الواو بين كل رقمين
//لا يوجد عدد محدد من الأرقام التي يمكنك الإرسال لها في حال تم الإرسال من خلال بوابة fsockpoen  أو بوابة CURL،
//ولكن في حال تم الإرسال من خلال بوابة fOpen ، فإنه يمكنك الإرسال إلى 120 رقم فقط في كل عملية إرسال


$msg = "$message";		/*
										نص الرسالة
										الرساله العربيه  70 حرف
										الرساله الانجليزيه 160 حرف
										في حال ارسال اكثر من رساله عربيه فان الرساله الواحده تحسب 67
										والرساله الانجليزي 153
										*/

$MsgID = rand(1,99999);					//رقم عشوائي يتم إرفاقه مع الإرساليه، في حال الرغبة بإرسال نفس الإرساليه في أقل من ساعه من إرسال الرساله الأولى.
//موقع موبايلي يمنع تكرار إرسال نفس الرساله خلال ساعه من إرسالها، إلا في حال تم إرسال قيمة مختلفه مع كل إرساليه.

$timeSend = 0;							//لتحديد وقت الإرساليه - 0 تعني الإرسال الآن
//الشكل القياسي للوقت هو hh:mm:ss

$dateSend = 0;							//لتحديد تاريخ الإرساليه - 0 تعني الإرسال الآن
//الشكل القياسي للتاريخ هو mm:dd:yyyy

    //يمكنك من خلال هذه القيمة  القيمه يمكنك من خلالها حذف الرساله من خلال بوابة حذف الرسائل.
//يمكنك تحديد رقم واحد لمجموعه من الإرساليات، بحيث يتم حذفها دفعه واحده.

    $deleteKey = 152485;

    //عند إرسال نص الرسالة بدون أي تشفير يجب إرسال المتغير lang على بوابة الإرسال وبالقيمة 3 .

    $lang = 3;

$sendSMSParam = array(
    'userName'=>$mobile,
    'password'=>$password,
    'numbers'=>$numbers,
    'sender'=>$sender,
    'message'=>$msg,
    'dateSend'=>$dateSend,
    'timeSend'=>$timeSend,
    'deleteKey'=>$deleteKey,
    'lang'=>$lang,
    'messageId'=> $MsgID,
    'applicationType'=>'24',
    'domainName'=>''
);

//إستدعاء عملية الإرسال
$sendSMSProcess = $client->SendSMS($sendSMSParam);

//طباعة نتيجة الإرسال

    $xml = simplexml_load_string($sendSMSProcess->SendSMSResult);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);

    return $array['Status'];
/* معاني نتائج عملية الإرسال
	0 => لم يتم الاتصال بالخادم
	1 => تمت عملية الإرسال بنجاح
	2 => رصيدك 0 , الرجاء إعادة التعبئة حتى تتمكن من إرسال الرسائل
	3 => رصيدك غير كافي لإتمام عملية الإرسال
	4 => إسم الحساب المستخدم غير صحيح
	5 => كلمة المرور الخاصة بالحساب غير صحيحة
	6 => صفحة الانترنت غير فعالة , حاول الارسال من جديد
	7 => نظام المدارس غير فعال
	8 => تكرار رمز المدرسة لنفس المستخدم
	9 => انتهاء الفترة التجريبية
	10 => عدد الارقام لا يساوي عدد الرسائل
	11 => اشتراكك لا يتيح لك ارسال رسائل لهذه المدرسة. يجب عليك تفعيل الاشتراك لهذه المدرسة
	12 => إصدار البوابة غير صحيح
	13 => الرقم المرسل به غير مفعل أو لا يوجد الرمز BS في نهاية الرسالة
	14 => غير مصرح لك بالإرسال بإستخدام هذا المرسل
	15 => الأرقام المرسل لها غير موجوده أو غير صحيحه
	16 => إسم المرسل فارغ، أو غير صحيح
	17 => نص الرسالة غير متوفر أو غير مشفر بشكل صحيح
*/
}
