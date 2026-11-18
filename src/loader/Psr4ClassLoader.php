<?php

namespace loader;

class Psr4ClassLoader
{
    private string $prefix;
    private string $root;

    public function __construct(string $prefix, string $root)
    {
        // le préfixe se termine toujours par un seul "\"
        $this->prefix = rtrim($prefix, '\\') . '\\';
        // le répertoire de base ne se termine pas par "/"
        $this->root = rtrim($root, '/\\');
    }

    public function loadClass(string $class): void
    {
        // la classe doit commencer par le préfixe
        if (strpos($class, $this->prefix) !== 0) {
            return;
        }

        // partie du nom située après le préfixe
        $relativeClass = substr($class, strlen($this->prefix));

        // \ -> / et extension .php
        $file = $this->root . '/' . str_replace('\\', '/', $relativeClass) . '.php';

        if (is_file($file)) {
            require_once $file;
        }
    }

    public function register(): void
    {
        spl_autoload_register([$this, 'loadClass']);
    }
}