<?php
// 发起人类
class Originator {
    private $state;
    public function setState($state) {
        $this->state = $state;
    }
    public function getState() {
        return $this->state;
    }
    public function createMemento() {
        return new Memento($this->state);
    }
    public function restoreMemento(Memento $memento) {
        $this->state = $memento->getState();
    }
}
// 备忘录类
class Memento {
    private $state;
    public function __construct($state) {
        $this->state = $state;
    }
    public function getState() {
        return $this->state;
    }
}
// 管理者类
class Caretaker {
    private $mementos = [];
    public function addMemento(Memento $memento) {
        $this->mementos[] = $memento;
    }
    public function getMemento($index) {
        return $this->mementos[$index];
    }
}
// 使用备忘录模式
$originator = new Originator();
$caretaker = new Caretaker();
$originator->setState("State 1");
$caretaker->addMemento($originator->createMemento());
$originator->setState("State 2");
$caretaker->addMemento($originator->createMemento());
$originator->setState("State 3");
$caretaker->addMemento($originator->createMemento());
$originator->restoreMemento($caretaker->getMemento(1));
echo $originator->getState(); // 输出：State 2