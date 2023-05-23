<?php

class Foo
{
    private static $id;
    private static $instance;

    private function __construct()
    {
        ++self::$id;
        fwrite(STDOUT, "construct, instance id: " . self::$id . "\n");
    }

    public static function getSingleton()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}

$instance1 = Foo::getSingleton();
var_dump($instance1);

# ReflectionClass 类报告了一个类的有关信息,建立Foo这个类的反射类
$class = new ReflectionClass("Foo");
# 获取类的构造函数
$constructor = $class->getConstructor();

// var_dump(ReflectionProperty::IS_PUBLIC);exit;
// var_dump($constructor->getModifiers());


//var_dump(ReflectionProperty::IS_PUBLIC & $constructor->getModifiers());exit;//0

# ReflectionProperty::IS_PUBLIC,检查属性是否为公共
# Gets the property modifiers,获取属性修饰符
if ((ReflectionProperty::IS_PUBLIC & $constructor->getModifiers()) === 0) {
    # 设置访问控制权：setAccessible 可获取私有的方法/属性。
    # 注意：setAccessible 只是让方法/成员变量可以 invoke/getValue/setValue，并不代表类定义的访问存取权限改变；
    $constructor->setAccessible(true);
}
# 创建一个新的类的实例而不调用它的构造函数。
$instance2 = $class->newInstanceWithoutConstructor();
# ReflectionMethod::invoke()函数是PHP中的内置函数，用于调用指定的反射方法并返回方法的结果。
$constructor->invoke($instance2);
var_dump($instance2);




