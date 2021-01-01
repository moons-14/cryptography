<?php
header('Content-Type: application/json; charset=UTF-8');
if($_GET['mode']=="encryption"){
    if(isset($_GET['key'])&&isset($_GET['text'])){
        $key= htmlspecialchars($_GET["key"]);
        $text= htmlspecialchars($_GET["text"]);
        $arr["status"] = "yes";
        $arr["mode"] = "encryption";
        $arr["key"] = $key;
        $arr["text"]=$text;
        $arr["response"] = openssl_encrypt($text, 'AES-128-ECB', $key);
    }else{
        $arr["status"] = "no";
    }
    
}else if($_GET['mode']=="decryption"){
    if(isset($_GET['key'])&&isset($_GET['text'])){
        $key= htmlspecialchars($_GET["key"]);
        $text= htmlspecialchars($_GET["text"]);
        $text = str_replace(" ", "+", $text);
        if(openssl_decrypt($text, 'AES-128-ECB', $key)){

        
        $arr["status"] = "yes";
        $arr["mode"] = "decryption";
        $arr["key"] = $key;
        $arr["text"]=$text;
        $arr["response"] = openssl_decrypt($text, 'AES-128-ECB', $key);
        }else{
            $arr["status"] = "no";
            $arr["response"]="Illegal value";
        }
    }else{
        $arr["status"] = "no";
    }
}else if($_GET['mode']=="hash"){
    if(isset($_GET['text'])){
        $text= htmlspecialchars($_GET["text"]);
        $arr["status"] = "yes";
        $arr["mode"] = "hash";
        $arr["text"]=$text;
        $arr["hash"] = hash("sha256",$text);
        $arr["md5"] = md5($text);
        $arr["sha1"] = sha1($text);
    }else{
        $arr["status"] = "no";
    }
}else if($_GET['mode']=="password_hash"){
    if(isset($_GET['text'])){
        $text= htmlspecialchars($_GET["text"]);
        $text = str_replace(" ", "+", $text);
        $arr["status"] = "yes";
        $arr["mode"] = "password_hash";
        $arr["text"]=$text;
        $arr["response"] =password_hash($text, PASSWORD_DEFAULT);

    }else{
        $arr["status"] = "no";
    }
}else{
    $arr["status"] = "no mode";
}

print json_encode($arr,  JSON_UNESCAPED_UNICODE);
