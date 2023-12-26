控制反转和依赖注入说的实际上是同一个东西，它们是一种设计模式，这种设计模式用来减少程序间的耦合  

### 控制反转

Inversion of Control 简写IOC ，他不是一种技术,从容器的角度在描述来看：容器控制应用程序，由容器反向的向应用程序注入应用程序所需要的外部资源  

传统应用程序都是由我们在类内部主动创建依赖对象，从而导致类与类之间高耦合，难于测试；但是有了IoC容器后，把创建和查找依赖对象的控制权交给了容器，由容器进行注入组合对象，所以对象与对象之间是 松散耦合，这样也方便测试，利于功能复用，更重要的是使得程序的整个体系结构变得非常灵活。

> 注：IoC对编程带来的最大改变不是从代码上，而是从思想上，发生了“主从换位”的变化。应用程序原本是老大，要获取什么资源都是主动出击，但是在IoC/DI思想中，应用程序就变成被动的了，被动的等待IoC容器来创建并注入它所需要的资源了。

> IoC很好的体现了面向对象设计法则之一—— 好莱坞法则：“别找我们，我们找你”；即由IoC容器帮对象找相应的依赖对象并注入，而不是由对象主动去找。

### 依赖注入

Dependency Injection 简写DI，他是实现控制反转思想的的技术方式，从应用程序的角度来描述：应用程序依赖容器创建并注入它所需要的外部资源  

> 有效的分离了对象和它所需要的外部资源，使得它们松散耦合，有利于功能复用，更重要的是使得程序的整个体系结构变得非常灵活  

> 组件之间依赖关系由容器在运行期决定，形象的说，即由容器动态的将某个依赖关系注入到组件之中。依赖注入的目的并非为软件系统带来更多功能，而是为了提升组件重用的频率，并为系统搭建一个灵活、可扩展的平台。通过依赖注入机制，我们只需要通过简单的配置，而无需任何代码就可指定目标需要的资源，完成自身的业务逻辑，而不需要关心具体的资源来自何处，由谁实现。也需要理解几个词：谁依赖谁，为什么需要依赖，谁注入谁，注入了什么？

#### 1.谁依赖于谁

应用程序依赖于IoC容器

#### 2为什么需要依赖

应用程序需要IoC容器来提供对象需要的外部资源

#### 3谁注入谁

IoC容器注入应用程序某个对象，应用程序依赖的对象

#### 4注入了什么

注入某个对象所需要的外部资源（包括对象、资源、常量数据）

#### 例子

##### 普通例子：

```php
<?php
/**
 * 没有IoC/DI的时候，常规的A类使用C类的示例
 */

/**
 * Class c
 */
class c
{
    public function say()
    {
        echo 'hello';
    }
}

/**
 * Class a
 */
class a
{
    private $c;
    public function __construct()
    {
        $this->c = new C(); // 实例化创建C类
    }

    public function sayC()
    {
        echo $this->c->say(); // 调用C类中的方法
    }
}

$a = new a();
$a->sayC(); 

//--------------------------------------------------------------------------------------------------------

/**
 * 当有IoC/DI的容器后,a类依赖c实例注入的示例
 */

/**
 * Class c
 */
class c {

    public function say()
    {
        echo 'hello';
    }
}

/**
 * Class a
 */
class a {
    private $c;
    public function setC(C $c) {
        $this->c = $c; // 实例化创建C类
    }

    public function sayC(){
        echo $this->c->say(); // 调用C类中的方法
    }
}

$c = new C();
$a = new a();
$a->setC($c);
$a->sayC();
```

##### 通过记录日志案例实现：

```php
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
class User
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
$user->login();
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

$user = new User(new DatabaseLog());
$user->login();
```
