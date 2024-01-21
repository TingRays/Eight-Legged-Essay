1. 静态属性与方法可以在不实例化类的情况下调用，直接使用`类名::方法名`的方式进行调用。静态属性**不允许**对象使用->操作符调用。

   > ```
   > 1.非静态方法可以调用静态方法，静态方法不可以调用非静态方法
   > 2.静态方法是属于类的，即静态方法是随着类的加载而加载的，在加载类时，程序就会为静态方法分配内存。
   > 3.非静态方法是属于对象的，对象是在类加载之后创建的。
   > 也就是说静态方法先于对象存在，当你创建一个对象时，程序为其分配内存，一般是通过this指针来指向该对象。静态方法不依赖于对象的调用，它是通过‘类名.静态方法名’这样的方式来调用的。而对于非静态方法，在对象创建的时候程序才会为其分配内存，然后通过类的对象去访问非静态方法。
   > ```

2. parent用来继承的时候用,我们可以使用parent去继承重写上面的方法，但是却不是叠加。

```PHP
<?php
class Car {
    public $speed = 0; //汽车的起始速度是0
    
    public function speedUp() {
        $this->speed += 10;
        return $this->speed;
    }
}
//定义继承于Car的Truck类
class Truck extends Car{
    public function speedUp(){
        $this->speed = parent::speedUp()+50;//只是覆盖上面的方法而已
    }
}
 
$car = new Truck();
$car->speedUp();
echo $car->speed;//答案60
```

#### 不存在继承的时候

不存在继承的意思就是，就书写一个单独的类来使用的时候。self和static在范围解析操作符 （::） 的使用上，并无区别。

- 在静态函数中，self和static可以调用静态属性和静态函数（没有实例化类，因此不能调用非静态的属性和函数，就是不能实例化）。
- 在非静态函数中，self和static可以调用静态属性和静态函数以及**非静态函数**

此时，self和static的表现是一样的，可以替换为该类名::的方式调用。

```PHP
<?php
class Demo{
    public static $static;
    public $Nostatic; 
    public function __construct(){
        self::$static = "static";
        $this->Nostatic = "Nostatic";
    }
    public static function get(){
        return __CLASS__;
    }
    public function show(){
        return "this is function show with ".$this->Nostatic;
    }
    public function test(){
        echo Demo::$static."<br/>";  //使用类名调用静态属性
        echo Demo::get()."<br/>";  //使用类名调用静态属性
        echo Demo::show()."<br/>";  //使用类名调用静态属性
        echo self::$static."<br/>";  //self调用静态属性
        echo self::show()."<br/>";  //self调用非静态方法
        echo self::get()."<br/>";   //self调用静态方法
        echo static::$static."<br/>";//static调用静态属性
        echo static::show()."<br/>";//static调用非静态方法
        echo static::get()."<br/>"; //static调用静态方法
    }
}
$obj = new Demo();
$obj->test();

//结果输出
static
Demo
this is function show with Nostatic
static
this is function show with Nostatic
Demo
static
this is function show with Nostatic
Demo
```

#### 继承的时候

在继承时，self和static在范围解析操作符 （::） 的使用上有差别。parent也是在继承的时候使用的。

```php
<?php
class A{
    static function getClassName(){
        return "this is class A";
    }
    static function testSelf(){
        echo self::getClassName();
    }
    static function testStatic(){
        echo static::getClassName();
    }
}
class B extends A{
    static function getClassName(){
        return "this is class B";
    }
}
B::testSelf();
echo "<br/>";
B::testStatic();

//结果
this is class A
this is class B
```

> self调用的静态方法或属性始终表示其在使用的时候的当前类（A）的方法或属性，可以替换为其类名，但是在类名很长或者有可能变化的情况下，使用self::的方式无疑是更好的选择。

> static调用的静态方法或属性会在继承中被其子类重写覆盖，应该替换为对应的子类名（B）。

> parent关键字用于调用父类的方法和属性。在静态方法中，可以调用父类的静态方法和属性；在非静态方法中，可以调用父类的方法和属性。

```php
<?php
class A{
    public static $static;
    public $Nostatic; 
    public function __construct(){
        self::$static = "static";
        $this->Nostatic = "Nostatic";
    }
    public static function staticFun(){
        return self::$static;
    }
    public function noStaticFun(){
        return "this is function show with ".$this->Nostatic;
    }
}
class B extends A{
    static function testS(){
        echo parent::staticFun();
    }
    function testNoS(){
        echo parent::noStaticFun();
    }
}
$obj = new B();
$obj->testS();
echo "<br/>";
$obj->testNoS();

//结果
static
this is function show with Nostatic
```

##### 一个例子

```php
<?php
class A {
    public static function foo() {
        static::who();
    }
 
    public static function who() {
        echo __CLASS__."\n";
    }
}
 
class B extends A {
    public static function test() {
        A::foo();
        parent::foo();
        self::foo();
    }
 
    public static function who() {
        echo __CLASS__."\n";
    }
}
class C extends B {
    public static function who() {
        echo __CLASS__."\n";
    }
}
 
C::test();
?> 
```

1. `A::foo();`这个语句是可以在任何地方执行的，它表示使用A去调用静态方法foo()得到’A’，然后直接调用A里面的who()方法。
2. `parent::foo();`C的parent是B，B的parent是A，回溯找到了A的foo方法；`static::who();`语句中的static::调用的方法会被子类覆盖，所以优先调用C的who()方法，如果C的who方法不存在会调用B的who方法，如果B的who方法不存在会调用A的who方法。所以，输出结果是’C’。优先级c->b
3. `self::foo();`这个self::是在B中使用的，所以self::等价于B::，但是B没有实现foo方法，B又继承自A，所以我们实际上调用了A::foo()这个方法。foo方法使用了static::who()语句，导致我们又调用了C的who函数。



原文地址：https://blog.csdn.net/qq_38588845/article/details/81187551