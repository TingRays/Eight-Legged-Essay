<?php
// 抽象表达式类
abstract class Expression
{
    abstract public function interpret($context);
}
// 终结符表达式类
class TerminalExpression extends Expression
{
    public function interpret($context)
    {
        if (strpos($context, $this->data) !== false) {
            return true;
        }
        return false;
    }
}
// 非终结符表达式类
class OrExpression extends Expression
{
    protected $expr1;
    protected $expr2;
    public function __construct(Expression $expr1, Expression $expr2)
    {
        $this->expr1 = $expr1;
        $this->expr2 = $expr2;
    }
    public function interpret($context)
    {
        return $this->expr1->interpret($context) || $this->expr2->interpret($context);
    }
}
class AndExpression extends Expression
{
    protected $expr1;
    protected $expr2;
    public function __construct(Expression $expr1, Expression $expr2)
    {
        $this->expr1 = $expr1;
        $this->expr2 = $expr2;
    }
    public function interpret($context)
    {
        return $this->expr1->interpret($context) && $this->expr2->interpret($context);
    }
}
// 上下文类
class Context
{
    protected $context;
    public function __construct($context)
    {
        $this->context = $context;
    }
    public function getContext()
    {
        return $this->context;
    }
}
// 客户端代码
$context = new Context("Hello, World!");
$terminal1 = new TerminalExpression("Hello");
$terminal2 = new TerminalExpression("World");
$orExpression = new OrExpression($terminal1, $terminal2);
$andExpression = new AndExpression($terminal1, $terminal2);
echo $orExpression->interpret($context->getContext()) ? "True\n" : "False\n";
echo $andExpression->interpret($context->getContext()) ? "True\n" : "False\n";