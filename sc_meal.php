<?php

/*
    Create by lill74 in September 8th 2018

    School meal API (Only avalibe in Korea)

    If you want see more info, please visit my respository.

    Github Repository : https://github.com/

    GPL v3
*/
require('ext/scmeal_parser.php');

// error_reporting(0); // Disable error reporting for security, etc.. (Disabled for debug)
date_default_timezone_set('Asia/Seoul'); //Setup default timezone

$scmeal = new Sc_Meal;
$scmeal -> init();
//데이터베이스에 캐쉬하고 json으로 응답. API 키 인증해야됨.

class Sc_Meal 
{

    function init()
    {
        $date = "";

        if(!(isset($_GET['regCode']) && isset($_GET['scCode']) && isset($_GET['scType']))) {
            $this -> exceptionEx('Some arguments are missing!');
        }

        if(!(isset($_GET['date']))) {
            $date = date("Y.m.d");
        }

        $regCode = $this -> RegionCheck($_GET['regCode']); //교육청 지역 코드
        $scCode = $_GET['scCode']; //학교 코드
        $scType = $_GET['scType']; //학교 종류
        $rsType = "sts_sci_md00_001.do"; //조회 종류

        $uri = "https://stu." . $regCode . "/" . $rsType . "?schulCode=" . $scCode . "&schulCrseScCode=" . $scType . "&schYmd=" . $date;

        $scmealparse = new Scmeal_Parser;
        $scmealparse -> getDoc($uri);
        
    }

    function regionCheck($regCode)
    {
        if(!isset($regCode)) {
            $this -> exceptionEx();
        }

        switch ($regCode) { //uri 앞에 서브도메인 stu를 붙여야됨 (나이스 학생서비스)
            case "seoul":
                return "sen.go.kr"; //서울시교육청
                break;

            case "incheon":
                return "ice.go.kr"; //인천시교육청
                break;

            case "gyeonggi":
                return "goe.go.kr"; //경기도교육청
                break;

            case "busan":
                return "pen.go.kr"; //부산시교육청
                break;
            
            case "gwanju":
                return "gen.go.kr"; //광주 교육청
                break;

            case "daejeon":
                return "dje.go.kr";
                break;

            case "daegue":
                return "dge.go.kr";
                break;

            case "sejong":
                return "sje.go.kr";
                break;
            
            case "ulsan":
                return "use.go.kr";
                break;

            case "kangwon":
                return "kwe.go.kr";
                break;

            case "chungbuk":
                return "cbe.go.kr";
                break;

            case "chungnam":
                return "cne.go.kr";
                break;

            case "gyeongbuk":
                return "gbe.go.kr";
                break;

            case "gyeongnam":
                return "gne.go.kr";
                break;

            case "jeonbuk":
                return "jbe.go.kr";
                break;

            case "jeonnam":
                return "jne.go.kr";
                break;

            case "jeju":
                return "jje.go.kr";
                break;

            default:
            $this -> exceptionEx('May be there isnt mach with dataset.');
            
        }
    }

    function exceptionEx($msg = null)
    {
        if($msg == null){
            echo('Error occured!');
        }
        else{
            echo('Error occured! ' . $msg);
        }

        exit(1);
    }

}

?>