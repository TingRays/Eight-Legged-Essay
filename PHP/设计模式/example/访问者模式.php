<?php

/**
 *Component接口声明了一个“accept”方法，该方法应将base访问者接口作为参数。
 */
interface Component
{
    public function accept(Visitor $visitor): void;
}

/**
 *每个具体组件必须以这样的方式实现“accept”方法：它调用与组件类对应的访问者方法。
 */
class ConcreteComponentA implements Component
{
    /*
     * 注意，我们调用的是与当前类名匹配的“visitContainerComponentA”。通过这种方式，我们让访问者知道它所使用的组件的类
     */
    public function accept(Visitor $visitor): void
    {
        $visitor->visitConcreteComponentA($this);
    }

    /*
     * 具体组件可能具有其基类或接口中不存在的特殊方法。Visitor仍然能够使用这些方法，因为它知道组件的具体类
     */
    public function exclusiveMethodOfConcreteComponentA(): string
    {
        return "A";
    }
}

class ConcreteComponentB implements Component
{
    /**
     * 此处相同：visitContainerComponentB=>ConcreteComponentB
     */
    public function accept(Visitor $visitor): void
    {
        $visitor->visitConcreteComponentB($this);
    }

    public function specialMethodOfConcreteComponentB(): string
    {
        return "B";
    }
}

/**
 *Visitor接口声明了一组与组件类相对应的访问方法。访问方法的签名允许访问者标识它正在处理的组件的确切类。
 */
interface Visitor
{
    public function visitConcreteComponentA(ConcreteComponentA $element): void;

    public function visitConcreteComponentB(ConcreteComponentB $element): void;
}

/**
 *Concrete Visitors实现了同一算法的多个版本，它可以与所有具体组件类一起工作。当将Visitor模式与复杂的对象结构（如Composite树）一起使用时，您可以体验到它的最大好处。在这种情况下，在对结构的各个对象执行访问者的方法时，存储算法的一些中间状态可能会有所帮助。
 */
class ConcreteVisitor1 implements Visitor
{
    public function visitConcreteComponentA(ConcreteComponentA $element): void
    {
        echo $element->exclusiveMethodOfConcreteComponentA() . " + ConcreteVisitor1\n";
    }

    public function visitConcreteComponentB(ConcreteComponentB $element): void
    {
        echo $element->specialMethodOfConcreteComponentB() . " + ConcreteVisitor1\n";
    }
}

class ConcreteVisitor2 implements Visitor
{
    public function visitConcreteComponentA(ConcreteComponentA $element): void
    {
        echo $element->exclusiveMethodOfConcreteComponentA() . " + ConcreteVisitor2\n";
    }

    public function visitConcreteComponentB(ConcreteComponentB $element): void
    {
        echo $element->specialMethodOfConcreteComponentB() . " + ConcreteVisitor2\n";
    }
}

/**
 *客户端代码可以在任何一组元素上运行访问者操作，而无需弄清楚它们的具体类。accept操作将调用指向访问者对象中的适当操作。
 */
function clientCode(array $components, Visitor $visitor)
{
    // ...
    foreach ($components as $component) {
        $component->accept($visitor);
    }
    // ...
}


//调用端
$components = [
    new ConcreteComponentA(),
    new ConcreteComponentB(),
];

echo "客户端代码通过基本访问者界面与所有访问者一起工作:\n";
$visitor1 = new ConcreteVisitor1();
clientCode($components, $visitor1);
echo "\n";

echo "它允许相同的客户端代码与不同类型的访问者一起工作：\n";
$visitor2 = new ConcreteVisitor2();
clientCode($components, $visitor2);