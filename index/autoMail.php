<?php  
    mb_internal_encoding('UTF-8');
    $mailTo = "yuta.toyomi.9f@stu.hosei.ac.jp, toyomi.zemi@gmail.com";
    $subject = "テスト";
    $message = "送信テスト";
    $headers = "From: labAdmin <yuta26504@gmail.com>";
    if ($result = mb_send_mail($mailTo, $subject, $message, $headers)){
        echo "成功";
    }else{
        echo "失敗";
    };
?>