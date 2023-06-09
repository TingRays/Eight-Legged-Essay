<?php
// 定义写日志的接口规范
interface log
{
    public function write();  
}
 
// 文件记录日志
class FileLog implements Log
{
    public function write(){
        echo 'file log write...';
    }  
}
 
// 数据库记录日志
class DatabaseLog implements Log
{
    public function write(){
        echo 'database log write...';
    }  
}
 
// 程序操作类  没有控制反转
/*class User
{
    protected $fileLog;
 
    public function __construct()
    {
        $this->fileLog = new FileLog();  
    }
 
    public function login()
    {
        // 登录成功，记录登录日志
        echo 'login success...';
        $this->fileLog->write();
    }
 
}
 
$user = new User();
$user->login();*/
// 通过构造函数参数传递就实现，这就是“控制反转”。不需要自己内容修改，改成由外部外部传递。这种由外部负责其依赖需求的行为，我们可以称其为 “控制反转（IoC）”。
class User
{
    protected $log;
 
    public function __construct(Log $log)
    {
        $this->log = $log;  
    }
 
    public function login()
    {
        // 登录成功，记录登录日志
        echo 'login success...';
        $this->log->write();
    }
 
}
 /*
 * 由外部注入应用程序依赖的对象
 */
//$user = new User(new FileLog());
$user = new User(new DatabaseLog());
$user->login();