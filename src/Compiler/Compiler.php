<?php


namespace PeterVanDommelen\Parser\Compiler;


use PeterVanDommelen\Parser\Expression\ExpressionInterface;
use PeterVanDommelen\Parser\Handler\Cache;
use PeterVanDommelen\Parser\Handler\ClassMapHandler;

class Compiler extends ClassMapHandler implements CompilerInterface
{
    private $cache;

    public function __construct(array $class_rewriters)
    {
        parent::__construct($class_rewriters);
        $this->cache = new Cache();
    }

    protected function getInterfaceName()
    {
        return CompilerInterface::class;
    }

    public function compile(ExpressionInterface $expression)
    {
        /** @var ExpressionInterface $expression */
        $expression = $this->resolveArgument($expression);

        if ($this->cache->has($expression) === false) {
            $lazy_result = new LazyParser();
            $this->cache->set($expression, $lazy_result);

            $result = $this->getHandlerUsingClassMap($expression)->compile($expression);
            $lazy_result->setResult($result);
            $this->cache->set($expression, $result);
        } else {
            $result = $this->cache->get($expression);
        }
        return $result;
    }
}