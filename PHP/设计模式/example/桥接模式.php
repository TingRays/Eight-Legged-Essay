<?php
 
/******************************Abstraction **************************/
/**
 * 
 * Abstraction抽象类的接口
 * @author guisu
 *
 */
abstract class BrushPenAbstraction {
    protected $_implementorColor = null;
 
    /**
     * 
     * Enter description here ...
     * @param Color $color
     */
    public function setImplementorColor(ImplementorColor $color) {
        $this->_implementorColor = $color;
    }
    /**
     * 
     * Enter description here ...
     */
    public abstract function operationDraw();
}
/******************************RefinedAbstraction **************************/
/**
 * 
 * 扩充由Abstraction;大毛笔
 * @author guisu
 *
 */
class BigBrushPenRefinedAbstraction extends BrushPenAbstraction {
    public function operationDraw() {
        echo 'Big and ', $this->_implementorColor->bepaint (), ' drawing';
    }
}
/**
 * 
 * 扩充由Abstraction;中毛笔
 * @author guisu
 *
 */
class MiddleBrushPenRefinedAbstraction extends BrushPenAbstraction {
    public function operationDraw() {
        echo 'Middle and ', $this->_implementorColor->bepaint (), ' drawing';
    }
}
/**
 * 
 * 扩充由Abstraction;小毛笔
 * @author guisu
 *
 */
class SmallBrushPenRefinedAbstraction extends BrushPenAbstraction {
    public function operationDraw() {
        echo 'Small and ', $this->_implementorColor->bepaint(), ' drawing';
    }
}
 
/******************************Implementor **************************/
/**
 * 实现类接口(Implementor)
 * 
 * @author mo-87
 *
 */
class ImplementorColor {
    protected $value;
 
    /**
     * 着色
     * 
     */
    public  function bepaint(){
        echo $this->value;
    }
}
/******************************oncrete Implementor **************************/
class oncreteImplementorRed extends ImplementorColor {
    public function __construct() {
        $this->value = "red";
    }
    /**
     * 可以覆盖
     */
    public function bepaint() {
        echo $this->value;
    }
}
 
class oncreteImplementorBlue extends ImplementorColor {
    public function __construct() {
        $this->value = "blue";
    }
}
 
class oncreteImplementorGreen extends ImplementorColor {
    public function __construct() {
        $this->value = "green";
    }
}
 
class oncreteImplementorWhite extends ImplementorColor {
    public function __construct() {
        $this->value = "white";
    }
}
 
class oncreteImplementorBlack extends ImplementorColor {
    public function __construct() {
        $this->value = "black";
    }
}
/**
 * 
 * 客户端程序
 * @author guisu
 *
 */
class Client {
    public static function Main() {
 
        //小笔画红色
        $objRAbstraction = new SmallBrushPenRefinedAbstraction();
        $objRAbstraction->setImplementorColor(new oncreteImplementorRed());
        $objRAbstraction->operationDraw();
    }
}
Client::Main();