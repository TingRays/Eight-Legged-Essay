<?php

/**
 * 门面设计模式(Facade)
 */
 
class Camera 
{
 
    /**
     * 打开录像机
     */
    public function turnOn()
    {
        echo "打开录像机" . '<br/>';
    }
 
    /**
     * 关闭录像机
     */
    public function turnOff()
    {
        echo "关闭录像机" . '<br/>';
    }
 
}

class Light
{
 
    /**
     * 开灯
     */
    public function turnOn()
    {
        echo "开灯" . '<br/>';
    }
 
    /**
     * 关灯
     */
    public function turnOff()
    {
        echo "关灯" . '<br/>';
    }
 
    /**
     * 换灯泡
     */
    public function changeBulb()
    {
        echo "换灯泡" . '<br/>';
    }

}
 
class Sensor 
{
 
    /**
     * 启动感应器
     */
    public function activate()
    {
        echo "启动感应器" . '<br/>';
    }
 
    /**
     * 关闭感应器
     */
    public function deactivate()
    {
        echo "关闭感应器" . '<br/>';
    }
 
    /**
     * 触发感应器
     */
    public function trigger()
    {
        echo "触发感应器" . '<br/>';
    }

}

class Alarm {
 
    /**
     * 启动警报器
     */
    public function activate()
    {
        echo "启动报警器" . '<br/>';
    }
 
    /**
     * 关闭警报器
     */
    public function deactivate()
    {
        echo "关闭报警器" . '<br/>';
    }
 
    /**
     * 拉响警报器
     */
    public function ring()
    {
        echo "拉响报警器" . '<br/>';
    }
 
    /**
     * 停掉警报器
     */
    public function stopRing()
    {
        echo "停掉报警器" . '<br/>';
    }

}
 
/**
 * 门面类(Facade)
 * 负责将"分散"的功能提供统一接口
 */
class Facade
{
 
    /* 录像机 */
    private $_camera;
 
    /* 灯 */
    private $_light;
 
    /* 感应器 */
    private $_sensor;
 
    /* 警报器 */
    private $_alarm;
    
    public function __construct()
    {
        $this->_camera = new Camera();
        $this->_light = new Light();
        $this->_sensor = new Sensor();
        $this->_alarm = new Alarm();
    }
    
    /**
     * 启动接口: (打开录像机/开灯/启动感应器/启动报警器)
     * @return void
     */
    public function activate()
    {
        // 打开录像机
        $this->_camera -> turnOn();
        // 开灯
        $this->_light -> turnOn();
        // 启动感应器
        $this->_sensor -> activate();
        // 启动报警器
        $this->_alarm -> activate();
        // 分隔符(方便观察)
        echo '<hr>';
    }

    /**
     * 关闭接口: (关闭录像机/关灯/关闭感应器/关闭报警器)
     * @return void
     */
    public function deactivate()
    {
        // 关闭录像机
        $this->_camera -> turnOff();
        // 关灯
        $this->_light -> turnOff();
        // 关闭感应器
        $this->_sensor -> deactivate();
        // 关闭报警器
        $this->_alarm -> deactivate();
        // 分隔符(方便观察)
        echo '<hr>';
    }

    /**
     * 其他功能接口: (换灯泡/触发感应器/拉响警报器/停掉警报器)
     * @return void
     */
    public function otherFunction()
    {
        // 换灯泡
        $this->_light -> changeBulb();
        // 触发感应器
        $this->_sensor -> trigger();
        // 拉响警报器
        $this->_alarm -> ring();
        // 停掉警报器
        $this->_alarm -> stopRing();
        // 分隔符(方便观察)
        echo '<hr>';
    }
}
 
 
/**
 * 客户端(由用户触发接口功能)
 */
class Client
{
 
    private static $_security;
    
    /**
     * 主程序(Main program)
     * @return void
     */
    public static function main()
    {   
        // 实例化门面类(Facade)
        self::$_security = new Facade();

        /**
         * 用户操作(operation)
         * @activate(): 开启操作
         * @deactivate(): 关闭操作
         * @otherFunction(): 其他操作
         */
        self::$_security -> activate();
        self::$_security -> deactivate();
        self::$_security -> otherFunction();
    }
}

/**
 * console main();
 */
Client::main();