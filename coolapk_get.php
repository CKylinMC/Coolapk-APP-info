<?php
@error_reporting(false);
/**
* 酷安软件信息抓取
* @author CKylin
* @version 0.1
* @description 在酷市场网页版抓取软件信息
*/

/*
 * 使用方法：get(包名);
 * 如： get('com.coolapk.market');
 */

function get($pkg){
    $return = array();
    if(empty($pkg)){
        $return['status'] = 'err';
        $return['code'] = 'NoPkg';
        return jsonOutput($return);
    }
    $result = getHtml($pkg);
    if($result[0]==1){
        $return['status'] = 'err';
        $return['code'] = 'HttpErr:'.$result[1];
        return jsonOutput($return);
    }
    //echo($result);
    $arr = parseHtml($result[1]);
    //print_r($arr);
    $return['status'] = 0;
    $return['pkg'] = $pkg;
    $return['url'] = $result[2];
    $return['msg'] = $arr;
    return jsonOutput($return);
}

function jsonOutput($arr){
    return json_encode($arr);
}

function getHtml($pkg){
    $url = 'http://www.coolapk.com/apk/'.$pkg;
    if(@fopen($url, 'r')){
        $res = file_get_contents($url);
        return array(0,$res,$url);
    } else {
        $http = get_headers($url,1);
        $http = $http[0];
        if($http=='HTTP/1.1 404 Not Found'){
            $http = 'APP not found or no permissions.(404)';
        }
        return array(1,$http);
    }
}

function parseHtml($html){
    preg_match("/\<meta name\=\"description\" content\=\".*\"\/\>/",$html,$des);
    $des = $des[0];
    $des = str_replace("<meta name=\"description\" content=\"","",$des);
    $des = str_replace("\"/>","",$des);
    preg_match("/\"https\:\/\/dl\.coolapk\.com\/down\\?pn\=.*\"\;/",$html,$down);
    $down = $down[0];
    $down = str_replace("\"","",$down);
    $down = str_replace(";","",$down);
    preg_match("/\<span class\=\"ex\-apk\-rank\-score\"\>.*\<\/span\>/",$html,$vote);
    $vote = $vote[0];
    $vote = str_replace("</span>","",$vote);
    $vote = str_replace("<span class=\"ex-apk-rank-score\">","",$vote);
    preg_match("/\<small\>.*\<\/small\>/",$html,$vert);
    $verres = $vert[0];
    $verres = str_replace("<small>","",$verres);
    $Version = str_replace("</small>","",$verres);
    $msgres = preg_match("/\<\/span\>\<span\>.*\<\/span\>/",$html,$msgt);
    $msgres = $msgt[0];
    $msgres = str_replace("<span>","",$msgres);
    $msgres = str_replace("</span>","",$msgres);
    $msgres = str_replace("<span>","",$msgres);
    $msgres = str_replace("</span>","",$msgres);
    $msgs = explode("，",$msgres);
    //print_r($msgs);
    $Size = $msgs[0];
    $Req = $msgs[1];
    $Updatedate = $msgs[2];
    $return = array(
    'ver'=>$Version,
    'description'=>$des,
    'size'=>$Size,
    'req'=>$Req,
    'vote'=>$vote,
    'update'=>$Updatedate,
    'download'=>$down
    // 'permissions'=>$perms
    );
    return $return;
}
