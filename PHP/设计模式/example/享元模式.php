<?php
//用户类
class User
{
    private $name;

    function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}

//定义一个抽象的创建网站的抽象类 - 享元抽象类
abstract class WebSite
{
    abstract public function use(User $user);
}

// 具体网站类 - 具体享元类
class ConcreteWebSite extends WebSite
{
    private $name = '';

    function __construct($name)
    {
        $this->name = $name;
    }

    public function use(User $user)
    {
        echo "{$user->getName()}使用我们开发的{$this->name}" . PHP_EOL;
    }
}

//网站工厂 - 享元工厂类
class WebSiteFactory
{
    private $flyweights = [];

    public function getWebSiteGategory($key)
    {
        if (empty($this->flyweights[$key])) {
            $this->flyweights[$key] = new ConcreteWebSite($key);
        }
        return $this->flyweights[$key];
    }
}

$f = new WebSiteFactory();
$fx = $f->getWebSiteGategory('电商网站 ');
$fx->use(new User('客户A'));

$fy = $f->getWebSiteGategory('电商网站 ');
$fy->use(new User('客户B'));


$fl = $f->getWebSiteGategory('资讯网站 ');
$fl->use(new User('客户C'));

$fm = $f->getWebSiteGategory('资讯网站 ');
$fm->use(new User('客户D'));