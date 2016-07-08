<?php
//pdo封装的mysql操作类
class DB {
    public static $dbtype = 'mysql';
    public static $dbhost = '';
    public static $dbport = '';
    public static $dbname = '';
    public static $dbuser = '';
    public static $dbpass = '';
    public static $charset = '';
    public static $stmt = null;
    public static $DB = null;
    public static $connect = true; // 是否長连接
    public static $debug = false;
    public static $affectedRows = '';

    /**
     * 构造函数，初始化数据库连接
     */
    public function __construct() {
        self::$dbtype = 'mysql';
        self::$dbhost = 'localhost';
        self::$dbport = '3306';
        self::$dbname = 'test';
        self::$dbuser = 'root';
        self::$dbpass = '';
        self::$connect = true;
        self::$charset = 'UTF8';
        self::connect ();
        self::$DB -> setAttribute ( PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true );
        self::$DB -> setAttribute ( PDO::ATTR_EMULATE_PREPARES, true );
        self::$DB -> exec( 'SET NAMES ' . self::$charset );
    }
    /**
     * 析构函数，释放资源
     */
    public function __destruct() {
        self::close ();
    }

    /**
     * *******************基本方法开始********************
     */
    //作用:连結数据库
    private function connect() {
        try {
            self::$DB = new PDO ( self::$dbtype . ':host=' . self::$dbhost . ';port=' . self::$dbport . ';dbname=' .
                self::$dbname, self::$dbuser, self::$dbpass, array (PDO::ATTR_PERSISTENT => self::$connect ) );
        } catch ( PDOException $e ) {
            die ( "Connect Error Infomation:" . $e->getMessage () );
        }
    }

    /**
     * 关闭数据连接
     */
    public function close() {
        self::$DB = null;
    }

    /**
     * 字符串转义
     */
    public function quote($str) {
        return self::$DB->quote ( $str );
    }

    /**
     * 作用:获取数据表里的字段
     * 返回:表字段结构
     * 类型:二维数组
     */
    public function getFields($table) {
        self::$stmt = self::$DB->query ( "DESCRIBE $table" );
        $result = self::$stmt->fetchAll ( PDO::FETCH_ASSOC );
        self::$stmt = null;
        return $result;
    }

    /**
     * 作用:获得最后INSERT的主鍵ID
     * 返回:最后INSERT的主鍵ID
     * 类型:数字
     */
    public function getLastId() {
        return self::$DB->lastInsertId ();
    }

    /**
     * 作用:執行INSERT\UPDATE\DELETE
     * 返回:执行語句影响行数
     * 类型:数字
     */
    private function execute($sql) {
        self::getPDOError ( $sql );
        self::$stmt = self::$DB -> prepare($sql);
        $res = self::$stmt->execute ();
        self::$affectedRows = self::$stmt->rowCount();
        return $res;
    }

    /**
     * 获取要操作的数据,排除空数据
     * 返回:合併后的SQL語句
     * 类型:字串
     */
    private function getCode($table, $arr) {
        $code = '';
        if (is_array ( $arr )) {
            foreach ( $arr as $k => $v ) {
                if ($v == '') {
                    continue;
                }
                $code .= "`$k`='$v',";
            }
        }
        $code = substr ( $code, 0, - 1 );
        return $code;
    }

    public function optimizeTable($table) {
        $sql = "OPTIMIZE TABLE $table";
        self::execute ( $sql );
    }

    /**
     * 执行具体SQL操作
     * 返回:运行結果
     * 类型:数组
     */
    private function _fetch($sql, $type) {
        $result = array ();
        self::$stmt = self::$DB->query ( $sql );
        self::getPDOError ( $sql );
        self::$stmt->setFetchMode ( PDO::FETCH_ASSOC );
        switch ($type) {
            case '0' :
                $result = self::$stmt->fetch ();
                break;
            case '1' :
                $result = self::$stmt->fetchAll ();
                break;
            case '2' :
                $result = self::$stmt->rowCount ();
                break;
        }
        self::$stmt = null;
        return $result;
    }
    //处理数据，过滤与表无关字段数据
    public function create($table,$dataArr){
        $field = $this->getFields($table);
        foreach($field as $k => $v){
            if(strtolower($v['Key']) == 'pri' && strtolower($v['Extra']) == 'auto_increment'){
                continue;//排除主键
            }
            if(strpos(strtolower($v['Extra']),'update') !== false){
                continue;//排除on update字段
            }
            $arr[] = $v['Field'];
        }
        foreach($dataArr as $k=>$v){
            if(in_array($k,$arr)){
                $newarr[$k] = $v;
            }
        }
        return $newarr;
    }

    /**********************基本方法結束*********************/

    /**********************Sql操作方法开始*********************/

    //插入
    public function add($table, $arr) {
        $sql = "INSERT INTO `$table` SET ";
        $code = self::getCode ( $table, $arr );
        $sql .= $code;
        return self::execute ( $sql );
    }

    //修改
    public function update($table, $arr, $where) {
        $code = self::getCode ( $table, $arr );
        $sql = "UPDATE `$table` SET ";
        $sql .= $code;
        $sql .= " Where $where";
        return self::execute ( $sql );
    }

    //删除
    public function delete($table, $where) {
        $sql = "DELETE FROM `$table` Where $where";
        return self::execute ( $sql );
    }

    // 获取表中指定的一条数据
    public function getOne($table, $field = '*', $where = false) {
        $sql = "SELECT {$field} FROM `{$table}`";
        $sql .= ($where) ? " WHERE $where" : '';
        return self::_fetch ( $sql, $type = '0' );
    }

    //获取表中所有数据
    public function getAll($table, $field = '*', $where = false, $orderby = false) {
        $sql = "SELECT {$field} FROM `{$table}`";
        $sql .= ($where) ? " WHERE $where" : '';
        $sql .= ($orderby) ? " ORDER BY $orderby" : '';
        return self::_fetch ( $sql, $type = '1' );
    }

    //获取表的总记录数
    public function getRowCount($table, $field = '*', $where = false) {
        $sql = "SELECT COUNT({$field}) AS num FROM $table";
        $sql .= ($where) ? " WHERE $where" : '';
        $arr = self::_fetch ( $sql, $type = '0' );
        return $arr['num'];
    }

    //获得受影响的行数
    public function getAffectedRows(){
        return self::$affectedRows;
    }

    //直接执行sql语句
    public function execSql($sql){
        $sql = ltrim($sql);
        if(strpos(strtolower($sql),'select') !== false){
            $stmt = self::$DB -> query($sql);
            $res = $stmt -> fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }else{
            return self::$DB -> exec($sql);
        }
    }

    /**
     * *******************Sql操作方法結束********************
     */

    /**
     * *******************错误处理开始********************
     */

    /**
     * 設置是否为调试模式
     */
    public function setDebugMode($mode = true) {
        return ($mode == true) ? self::$debug = true : self::$debug = false;
    }

    /**
     * 捕获PDO错误信息
     * 返回:出错信息
     * 类型:字串
     */
    private function getPDOError($sql) {
        self::$debug ? self::errorfile ( $sql ) : '';
        if (self::$DB->errorCode () != '00000') {
            $info = (self::$stmt) ? self::$stmt->errorInfo () : self::$DB->errorInfo ();
            echo (self::sqlError ( 'mySQL Query Error', $info [2], $sql ));
            exit ();
        }
    }
    private function getSTMTError($sql) {
        self::$debug ? self::errorfile ( $sql ) : '';
        if (self::$stmt->errorCode () != '00000') {
            $info = (self::$stmt) ? self::$stmt->errorInfo () : self::$DB->errorInfo ();
            echo (self::sqlError ( 'mySQL Query Error', $info [2], $sql ));
            exit ();
        }
    }

    /**
     * 寫入错误日志
     */
    private function errorfile($sql) {
        echo $sql . '<br />';
        $errorfile = _ROOT . './dberrorlog.php';
        $sql = str_replace ( array (
            "\n",
            "\r",
            "\t",
            "  ",
            "  ",
            "  "
        ), array (
            " ",
            " ",
            " ",
            " ",
            " ",
            " "
        ), $sql );
        if (! file_exists ( $errorfile )) {
            $fp = file_put_contents ( $errorfile, "<?PHP exit('Access Denied'); ?>\n" . $sql );
        } else {
            $fp = file_put_contents ( $errorfile, "\n" . $sql, FILE_APPEND );
        }
    }

    /**
     * 作用:运行错误信息
     * 返回:运行错误信息和SQL語句
     * 类型:字符
     */
    private function sqlError($message = '', $info = '', $sql = '') {

        $html = '';
        if ($message) {
            $html .=  $message;
        }

        if ($info) {
            $html .= 'SQLID: ' . $info ;
        }
        if ($sql) {
            $html .= 'ErrorSQL: ' . $sql;
        }

        throw new Exception($html);
    }
    /**
     * *******************错误处理結束********************
     */
}