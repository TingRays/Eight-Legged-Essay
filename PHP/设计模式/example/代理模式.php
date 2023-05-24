<?php

/**顶层接口 
 * Interface IGiveGift 
 */  
interface IGiveGift  
{  
    function giveRose();  
    function giveChocolate();  
}  
  
/**追求者 
 * Class Follower 
 */  
class Follower implements IGiveGift  
{  
    private $girlName;  
  
    function __construct($name='Girl')  
    {  
        $this->girlName=$name;  
    }  
  
    function giveRose()  
    {  
        echo "{$this->girlName}:这是我送你的玫瑰，望你能喜欢。<br/>";  
    }  
  
    function giveChocolate()  
    {  
        echo "{$this->girlName}:这是我送你的巧克力，望你能收下。<br/>";  
    }  
}  
  
/**代理 
 * Class Proxy 
 */  
class Proxy implements IGiveGift  
{  
    private $follower;  
  
    function __construct($name='Girl')  
    {  
        $this->follower=new Follower($name);  
    }  
  
    function giveRose()  
    {  
        $this->follower->giveRose();  
    }  
  
    function giveChocolate()  
    {  
        $this->follower->giveChocolate();  
    }  
}  
$proxy=new Proxy('李冰冰');  
$proxy->giveRose();  
$proxy->giveChocolate();  