<?php
// 抽象中介者
abstract class Mediator
{
    abstract public function send($message, $colleague);
}
// 抽象同事类
abstract class Colleague
{
    protected $mediator;
    public function __construct(Mediator $mediator)
    {
        $this->mediator = $mediator;
    }
    abstract public function send($message);
    abstract public function receive($message);
}
// 具体中介者
class ConcreteMediator extends Mediator
{
    private $colleague1;
    private $colleague2;
    public function setColleague1(Colleague $colleague)
    {
        $this->colleague1 = $colleague;
    }
    public function setColleague2(Colleague $colleague)
    {
        $this->colleague2 = $colleague;
    }
    public function send($message, $colleague)
    {
        if ($colleague == $this->colleague1) {
            $this->colleague2->receive($message);
        } else {
            $this->colleague1->receive($message);
        }
    }
}
// 具体同事类
class ConcreteColleague1 extends Colleague
{
    public function send($message)
    {
        $this->mediator->send($message, $this);
    }
    public function receive($message)
    {
        echo "ConcreteColleague1 received message: $message\n";
    }
}
class ConcreteColleague2 extends Colleague
{
    public function send($message)
    {
        $this->mediator->send($message, $this);
    }
    public function receive($message)
    {
        echo "ConcreteColleague2 received message: $message\n";
    }
}
$mediator = new ConcreteMediator;
$colleague1 = new ConcreteColleague1($mediator);
$colleague2 = new ConcreteColleague2($mediator);
$mediator->setColleague1($colleague1);
$mediator->setColleague2($colleague2);
$colleague1->send("Hello, colleague2!");
$colleague2->send("Hi, colleague1!");