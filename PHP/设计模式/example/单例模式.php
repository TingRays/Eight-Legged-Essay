<?php
 
class Singleton
{
    private static $instance = null;
 
    // 禁止被实例化
    private function __construct()
    {
 
    }
 
    // 禁止clone
    private function __clone()
    {
 
    }
        //  实例化自己并保存到$instance中，已实例化则直接调用
    public static function getInstance(): object
    {
        if (empty(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
 
    public function test(): string
    {
        return '这是一个单例模式';
    }
 
}
 
// 两次调用返回同一个实例
$single1 = Singleton::getInstance();
$single2 = Singleton::getInstance();
 
var_dump($single1, $single2);
echo $single1->test();
 
// new Singleton(); // Fatal error: Uncaught Error: Call to private Singleton::__construct() from invalid context
// clone $single1; // Fatal error: Uncaught Error: Call to private Singleton::__construct() from invalid contexts