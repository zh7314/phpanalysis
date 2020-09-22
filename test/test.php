<?php

include_once './../src/phpanalysis.class.php';
include_once './Function.php';

use zh7314\phpanalysis\PhpAnalysis;

$str = '老王爱看世界杯';
//岐义处理
$do_fork = true;
//新词识别
$do_unit = true;
//多元切分
$do_multi = true;
//词性标注
$do_prop = false;
//是否预载全部词条
$pri_dict = true;


//初始化类
PhpAnalysis::$loadInit = false;
$pa = new PhpAnalysis('utf-8', 'utf-8', $pri_dict);

//载入词典
$pa->LoadDict();

//执行分词
$pa->SetSource($str);
$pa->differMax = $do_multi;
$pa->unitWord = $do_unit;

$pa->StartAnalysis($do_fork);


$okresult = $pa->GetFinallyResult(' ', $do_prop);

$pa_foundWordStr = $pa->foundWordStr;

p($okresult);
pp($pa_foundWordStr);
