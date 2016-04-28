<?php


namespace PeterVanDommelen\Parser\Expression\Named;


use PeterVanDommelen\Parser\Expression\ExpressionInterface;
use PeterVanDommelen\Parser\Handler\RecursionAwareInterface;
use PeterVanDommelen\Parser\Handler\RecursionAwareTrait;
use PeterVanDommelen\Parser\Rewriter\ExpressionRewriterInterface;

class NamedExpressionRewriter implements ExpressionRewriterInterface, RecursionAwareInterface
{
    use RecursionAwareTrait;

    /** @var Grammar */
    private $grammar;

    /**
     * @param $grammar
     */
    public function __construct($grammar)
    {
        $this->grammar = $grammar;
    }

    public function rewriteExpression(ExpressionInterface $expression)
    {
        /** @var NamedExpression $expression */
        return $this->getRecursiveHandler()->rewriteExpression($this->grammar->getExpression($expression->getName()));
    }

    public function getExpressionResultRewriter(ExpressionInterface $expression)
    {
        /** @var NamedExpression $expression */
        return $this->getRecursiveHandler()->getExpressionResultRewriter($this->grammar->getExpression($expression->getName()));
    }


}