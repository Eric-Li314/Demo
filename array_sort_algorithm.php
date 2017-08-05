<?php
//各种排序算法解析

$arr = array(17,22,4,8,10,13,5,5,5,5); var_dump($arr);echo "<hr/>";

//1-选择排序,基本思想是，首先，选出最小的数，放在第一个位置；然后，选出第二小的数，放在第二个位置；以此类推，直到所有的数从小到大排序。
function choice_sort($arr){
    $len = count($arr);
    for($a=0;$a<$len-1;$a++){ //一共进行$len-1 论排序
        for($b=$a+1;$b<$len;$b++){ //每轮排序后，起始元素位置后移一位
            if($arr[$a]>$arr[$b]){
                $temp = $arr[$a];
                $arr[$a] = $arr[$b];
                $arr[$b] = $temp;
            }
        }
    }
    return $arr;
}

//var_dump(choice_sort($arr));
//2-冒泡排序，基本思想就是不断比较相邻的两个数，让较大的元素不断地往后移。经过一轮比较，就选出最大的数；经过第2轮比较，就选出次大的数，以此类推
//方向是从后向前进行排序,
function bubble_sort($arr){
    $len = count($arr);
    for($a=0;$a<$len-1;$a++){
        for($b=0;$b<$len-$a-1;$b++){ //每轮排序后，结束位置向前移动一位
            if($arr[$b]>$arr[$b+1]){
                $temp = $arr[$b+1];
                $arr[$b+1] = $arr[$b];
                $arr[$b] = $temp;
            }
        }
    }
    return $arr;
}

//var_dump(bubble_sort($arr));
//3-插入排序，是稳定的排序，不会改变相同数字的位置，假定第一个数是排好的序列，后面数字按序依次插入
function insert_sort($arr){
    $len = count($arr);
    for($i=1;$i<$len;$i++){  // 5327 3527
        $temp=$arr[$i]; //待插入的元素
        $key=$i-1; //已排序数组最后一个元素位置（最大的一个）  $key $i 都代表的位置,$key 代表假定需要插入的初始位置
        while($key>=0&&$temp<$arr[$key]){ //只要待插元素小于已排序数组的最后一个，则要通过向前比较插入到有序序列中
            $arr[$key+1]=$arr[$key];//只要待插元素小于有序序列中的元素则有序元素往后移一个位置
            $key--;//依次向前比较有序序列中的元素
        }
        if(($key+1)!=$i) //只要经过了上面的循环参与了向前插入的过程，$key会变化，该表达式条件成立，表示插入的位置不等于原来的位置
            $arr[$key+1]=$temp;//$key+1 表示插入有序序列的位置
    }
    return $arr;
}

//var_dump(insert_sort($arr));

//4-快速排序：
//（1）在数据集之中，选择一个元素作为"基准"。
//（2）所有小于"基准"的元素，都移到"基准"的左边；所有大于"基准"的元素，都移到"基准"的右边。
//（3）对"基准"左边和右边的两个子集，不断重复第一步和第二步，直到所有子集只剩下一个元素为止。
//实现过程：找到当前数组中的任意一个元素（一般选择第一个元素），作为标准，新建两个空数组，遍历整个数组元素，
//如果遍历到的元素比当前的元素要小，那么就放到左边的数组，否则放到右面的数组，然后再对新数组进行同样的操作
function quick_sort($arr){
    //判断参数是否是一个数组
    if(!is_array($arr)) return false;
    //递归出口:数组长度为1，直接返回数组
    $length=count($arr);
    if($length<=1) return $arr;
    //数组元素有多个,则定义两个空数组
    $left=array();
    $right=array();
    //使用for循环进行遍历，把第一个元素当做比较的对象
    for($i=1;$i<$length;$i++)
    {
        //判断当前元素的大小,以数组中第一个元素作为基准
        if($arr[$i]<$arr[0]){
            $left[]=$arr[$i];
        }else{
            $right[]=$arr[$i];
        }
    }
    //递归调用
    $left=quick_sort($left);
    $right=quick_sort($right);
    //将所有的结果合并
    $ret = array_merge($left,array($arr[0]),$right);
    return $ret;
}
$arr1 = array(4,6,5,9,2,1);
var_dump(quick_sort($arr1));

//快递排序，再同一个数组内进行
//模拟c 实现quick sort,同一个数组进行排序
function qs(&$arr,$l,$r){ //$l 是数组起始位置编号，$r是结束位置编号，&$arr 引用传值取地址，改变外部变量
    if($l<$r){ //数组个数大于1个才进行比较
        $base = $arr[$l]; //基准数 选最左边的一个数
        $i = $l; //分别赋值给变量以便进行移动计算 左边移动开始位置
        $j = $r; //右边移动开始位置
        while($i<$j){ //当左右位置变量相向移动还没碰到一起时
            while($i<$j && $arr[$j]>=$base){//右边开始向左移动，直到找到小于基准数
                $j--;//大于基准数直接跳过，然后向前移动一位
            }
            if($i<$j){
                $arr[$i++] = $arr[$j];//左右没碰到一起时，把右边找到的小于基准数的数字放到基准值的位置，然后左边向后移动一位
            }
            while($i<$j && $arr[$i]<=$base){//左边向右移动，直到找到大于基准数
                $i++;//小于基准数直接跳过，然后向后移动一位
            }
            if($i<$j){
                $arr[$j--] = $arr[$i];//左右没碰到一起时，把左边找到的大于基准数的数字放到右边找到的小于基准数的位置，然后右边向前移动一位
            }
            //只要还没左右相碰，继续相向移动比较，注意时右边先向左边移动
        }
        //当左右变量都指向同一个数时，$i=$j,循环结束,把基准值放倒$i的位置，则左边<=基准值，右边>=基准值
        $arr[$i] = $base;
        //再分别对数组左右两部分递归调用
        qs($arr,$l,$i-1);//基准值前面的数组元素
        qs($arr,$i+1,$r);//基准值后面的数组元素
    }
}



//顺序查找，逐个值进行比较
function order_search($arr,$search){
    foreach($arr as $v){
        if($v == $search) {
            var_dump($v);
            return true;}
    }
    return false;
}
$arr = range(1,1000000);
$times = microtime(true);echo "<br/>";
order_search($arr,888888);
echo microtime(true)-$times;echo "<br/>";

//二分查找，要求是已经排好的有序数组，每次取中间值比较，直到相等
function two_search($arr,$search,$s,$e){
    $middle = floor($s+($e-$s)/2);
    if($arr[$middle] == $search){
        var_dump($arr[$middle]);
        return true;
    }

    elseif($arr[$middle] > $search)
        two_search($arr,$search,$s,$middle);
    elseif($arr[$middle] < $search)
        two_search($arr,$search,$middle,$e);

}

$times = microtime(true);echo "<br/>";
two_search($arr,888888,0,count($arr)-1);
echo microtime(true)-$times;echo "<br/>";