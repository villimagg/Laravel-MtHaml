<?php namespace Villimagg\LaravelMthaml\Lexer;

/**
 * Based on Silex-Mthaml: https://github.com/arnaud-lb/Silex-MtHaml
 */

use MtHaml\Environment;

class Lexer implements \Twig_LexerInterface
{
    private $environment;
    private $lexer;

    public function __construct(Environment $environment, \Twig_LexerInterface $lexer)
    {
        $this->environment = $environment;
        $this->lexer = $lexer;
    }

    public function tokenize($code, $filename = null)
    {
        if (null !== $filename && preg_match('/\.haml$/', $filename)) {
            $code = $this->environment->compileString($code, $filename);
        }
        return $this->lexer->tokenize($code, $filename);
    }
}

