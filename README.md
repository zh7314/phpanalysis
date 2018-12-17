本文用于http://www.phpbone.com/phpanalysis/ v2版本的composer使用


使用实例
因为composer https://packagist.org/ 的包有不同程度的封装影响此插件的使用，so，独立上传一份包

demo

// 严格开发模式
ini_set('display_errors', 'On');
ini_set('memory_limit', '64M');
error_reporting(E_ALL);

$t1 = $ntime = microtime(true);
$endtime = '未执行任何操作，不统计！';
function print_memory($rc, &$infostr)
{
    global $ntime;
    $cutime = microtime(true);
    $etime = sprintf('%0.4f', $cutime - $ntime);
    $m = sprintf('%0.2f', memory_get_usage()/1024/1024);
    $infostr .= "{$rc}: &nbsp;{$m} MB 用时：{$etime} 秒<br />\n";
    $ntime = $cutime;
}

header('Content-Type: text/html; charset=utf-8');

$memory_info = '';
print_memory('没任何操作', $memory_info);

require_once 'phpanalysis.class.php';

$str = (isset($_POST['source']) ? $_POST['source'] : '');

$loadtime = $endtime1  = $endtime2 = $slen = 0;

$do_fork = $do_unit = true;
$do_multi = $do_prop = $pri_dict = false;

if($str != '')
{
    //岐义处理
    $do_fork = empty($_POST['do_fork']) ? false : true;
    //新词识别
    $do_unit = empty($_POST['do_unit']) ? false : true;
    //多元切分
    $do_multi = empty($_POST['do_multi']) ? false : true;
    //词性标注
    $do_prop = empty($_POST['do_prop']) ? false : true;
    //是否预载全部词条
    $pri_dict = empty($_POST['pri_dict']) ? false : true;
    
    $tall = microtime(true);
    
    //初始化类
    PhpAnalysis::$loadInit = false;
    $pa = new PhpAnalysis('utf-8', 'utf-8', $pri_dict);
    print_memory('初始化对象', $memory_info);
    
    //载入词典
    $pa->LoadDict();
    print_memory('载入基本词典', $memory_info);    
        
    //执行分词
    $pa->SetSource($str);
    $pa->differMax = $do_multi;
    $pa->unitWord = $do_unit;
    
    $pa->StartAnalysis( $do_fork );
    print_memory('执行分词', $memory_info);
    
    $okresult = $pa->GetFinallyResult(' ', $do_prop);
    print_memory('输出分词结果', $memory_info);
    
    $pa_foundWordStr = $pa->foundWordStr;
    
    $t2 = microtime(true);
    $endtime = sprintf('%0.4f', $t2 - $t1);
    
    $slen = strlen($str);
    $slen = sprintf('%0.2f', $slen/1024);
    
    $pa = '';
    
laravel 使用demo

composer require zh7314/phpanalysis dev-master

引入空间命名
use zh7314\phpanalysis\PhpAnalysis;

实际demo代码
 public function test(Request $Request) {

        $str = '老王爱看世界杯';
//岐义处理
        $do_fork = true;
//新词识别
        $do_unit = true;
//多元切分
        $do_multi = true;
//词性标注
        $do_prop = true;
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
        }
