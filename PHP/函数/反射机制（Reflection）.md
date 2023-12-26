PHP自5.0版本以后添加了反射机制，它提供了一套强大的反射API，允许你在PHP运行环境中，访问和使用类、方法、属性、参数和注释等，其功能十分强大，经常用于高扩展的PHP框架，自动加载插件，自动生成文档，甚至可以用来扩展PHP语言。由于它是PHP內建的oop扩展，为语言本身自带的特性，所以不需要额外添加扩展或者配置就可以使用。
如其名，反射是（从镜子里）照出自身。我们写代码，告诉代码怎么运行，事件发生在编译期。代码运行期间，代码如何知道自己的结构以及能力呢？反射机制能够使代码感知自身结构，并可（部分）改变运行行为。

### 参考文档

https://www.php.net/manual/zh/book.reflection.php
https://www.php.net/manual/zh/class.reflection.php

```不管类中定义的成员权限声明是否为public，都可以获取到。```

```php
<?php 
namespace Extend;

use ReflectionClass;
use Exception;

/**
 * 用户相关类
 * Class User
 * @package Extend
 */
class User{
    const ROLE = 'Students';
    public $username = '';
    private $password = '';

    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * 获取用户名
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * 设置用户名
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * 获取密码
     * @return string
     */
    private function getPassword()
    {
        return $this->password;
    }

    /**
     * 设置密码
     * @param string $password
     */
    private function setPassowrd($password)
    {
        $this->password = $password;
    }
}

$class = new ReflectionClass('Extend\User');  // 将类名User作为参数，即可建立User类的反射类
$properties = $class->getProperties();  // 获取User类的所有属性，返回ReflectionProperty的数组
$property = $class->getProperty('password'); // 获取User类的password属性ReflectionProperty
$methods = $class->getMethods();   // 获取User类的所有方法，返回ReflectionMethod数组
$method = $class->getMethod('getUsername');  // 获取User类的getUsername方法的ReflectionMethod
$constants = $class->getConstants();   // 获取所有常量，返回常量定义数组
$constant = $class->getConstant('ROLE');   // 获取ROLE常量
$namespace = $class->getNamespaceName();  // 获取类的命名空间
$comment_class = $class->getDocComment();  // 获取User类的注释文档，即定义在类之前的注释
$comment_method = $class->getMethod('getUsername')->getDocComment();  // 获取User类中getUsername方法的注释文档
```

一旦创建了反射类的实例，我们不仅可以通过反射类访问原来类的方法和属性，还能创建原来类的实例或则直接调用类里面的方法。

```php
$class = new ReflectionClass('Extend\User');  // 将类名User作为参数，即可建立User类的反射类
$instance = $class->newInstance('youyou', 1, '***');  // 创建User类的实例

$instance->setUsername('youyou_2');  // 调用User类的实例调用setUsername方法设置用户名
$value = $instance->getUsername();   // 用过User类的实例调用getUsername方法获取用户名
echo $value;echo "\n";   // 输出 youyou_2

$class->getProperty('username')->setValue($instance, 'youyou_3');  // 通过反射类ReflectionProperty设置指定实例的username属性值
$value = $class->getProperty('username')->getValue($instance);  // 通过反射类ReflectionProperty获取username的属性值
echo $value;echo "\n";   // 输出 youyou_3

$class->getMethod('setUsername')->invoke($instance, 'youyou_4'); // 通过反射类ReflectionMethod调用指定实例的方法，并且传送参数
$value = $class->getMethod('getUsername')->invoke($instance);    // 通过反射类ReflectionMethod调用指定实例的方法
echo $value;echo "\n";   // 输出 youyou_4

try {
    $property = $class->getProperty('password_1');
    $property->setAccessible(true);   // 修改 $property 对象的可访问性
    $property->setValue($instance, 'password_2');  // 可以执行
    $value = $property->getValue($instance);     // 可以执行
    echo $value;echo "\n";   // 输出 password_2
    $class->getProperty('password')->setAccessible(true);    // 修改临时ReflectionProperty对象的可访问性
    $class->getProperty('password')->setValue($instance, 'password');// 不能执行，抛出不能访问异常
    $value = $class->getProperty('password')->getValue($instance);   // 不能执行，抛出不能访问异常
    $value = $instance->password;   // 不能执行，类本身的属性没有被修改，仍然是private
}catch(Exception $e){echo $e;}
```

#### 注意事项

1. 直接访问 protected 或则 private 的熟悉或者方法会抛出异常
2. 需要调用指定的 ReflectionProperty 或则 ReflectionMethod 对象 setAccessible(true)方法才能访问非公有成员
3. 修改非公有成员的访问权限只作用于当前的反射类的实例
4. 需要注意获取静态成员和非静态成员所使用的方法不一样
5. 获取父类成员的方法和一般的不一样
