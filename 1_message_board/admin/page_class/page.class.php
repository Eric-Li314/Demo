<?php

class Page
{
    private $total;        //总记录数
    private $page_size;    //每页显示条数
    private $limit;        //用于sql语句
    private $page;         //当前页码
    private $page_num;     //总页码数
    private $url;          //分页的url地址
    private $both_num;     //两边保持数字分页的量

    //构造方法初始化
    public function __construct($_total, $_page_size)
    {
        $this->total = $_total ? $_total : 1;
        $this->page_size = $_page_size;
        $this->page_num = ceil($this->total / $this->page_size);
        $this->page = $this->setPage();
        $this->limit = "LIMIT " . ($this->page - 1) * $this->page_size . ",$this->page_size";
        $this->url = $this->setUrl();
        $this->both_num = 4;
    }

    //获取当前页码
    private function setPage()
    {
        if (!empty($_GET['page'])) {
            if ($_GET['page'] > 0) {
                return $_GET['page'] > $this->page_num ? $this->page_num : $_GET['page'];
            } else {
                return 1;
            }
        } else {
            return 1;
        }
    }

    //获取地址
    private function setUrl()
    {
        $_url = $_SERVER["REQUEST_URI"];
        $_par = parse_url($_url);//解析 URL 字符串
        if (isset($_par['query'])) { //获取url中?后面部分
            parse_str($_par['query'], $_query);//把查询字符串解析到变量中
            unset($_query['page']);//去掉page
            if ($_query) {//如果去掉page后有查询值则后面加 &
                $_url = $_par['path'] . '?' . http_build_query($_query) . '&';
            } else {//无值则在基地址后加？
                $_url = $_par['path'] . '?';
            }
        } else {
            $_url = $_par['path'] . '?';
        }
        return $_url;
    }

    //数字目录
    private function pageList()
    {
        $_pagelist = '';
        for ($i = $this->both_num; $i >= 1; $i--) {
            $_page = $this->page - $i;
            if ($_page < 1) continue;
            $_pagelist .= ' <a href="' . $this->url . 'page=' . $_page . '">' . $_page . '</a> ';
        }
        $_pagelist .= ' <a class="cur">' . $this->page . '</a> ';
        for ($i = 1; $i <= $this->both_num; $i++) {
            $_page = $this->page + $i;
            if ($_page > $this->page_num) break;
            $_pagelist .= ' <a href="' . $this->url . 'page=' . $_page . '">' . $_page . '</a> ';
        }
        return $_pagelist;
    }

    //首页
    private function first()
    {
        /*if ($this->page > $this->both_num+1) {
            return ' <a href="'.$this->url.'"></a> ...';
        }*/
        if ($this->page == 1) {
            return '<a>首页</a>';
        }
        return '<a href="' . $this->url . 'page=1' . '">首页</a>';
    }

    //上一页
    private function prev()
    {
        if ($this->page == 1) {
            return '<a class="disabled">上一页</a>';
        }
        return ' <a href="' . $this->url . 'page=' . ($this->page - 1) . '">上一页</a> ';
    }

    //下一页
    private function next()
    {
        if ($this->page == $this->page_num) {
            return '<a class="disabled">下一页</a>';
        }
        return ' <a href="' . $this->url . 'page=' . ($this->page + 1) . '">下一页</a> ';
    }

    //尾页
    private function last()
    {
        /*if ($this->page_num - $this->page > $this->both_num) {
            return ' ...<a href="'.$this->url.'page='.$this->page_num.'">'.$this->page_num.'</a> ';
        }*/
        if ($this->page == $this->page_num) {
            return '<a>尾页</a>';
        }
        return '<a href="' . $this->url . 'page=' . $this->page_num . '">尾页</a>';
    }

    //统计信息
    private function addition()
    {
        $start = ($this->page - 1) * $this->page_size + 1;
        $end = min($this->page * $this->page_size, $this->total);
        $str = '<p class="pageRemark">';
        $str .= "共<b style='color:green'>{$this->page_num}</b>页<b style='color:green'>{$this->total}</b>条数据";
        $str .= " 当前第<b style='color:darkgreen'>{$start}</b>-<b style='color:darkgreen'>{$end}</b>条。";
        $str .= '</p>';
        return $str;
    }

    //获取limit的偏移量 limit start,length
    public function getStart(){
        $start = ($this->page - 1) * $this->page_size;
        return $start;
    }

    //分页信息
    public function showpage()
    {
        $_page = '';
        $_page .= $this->first();
        $_page .= $this->prev();
        $_page .= $this->pageList();
        $_page .= $this->next();
        $_page .= $this->last();
        $_page .= $this->addition();
        return $_page;
    }
}
