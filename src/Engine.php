<?php

namespace ArveresTemplate;

use Exception;
use ReflectionClass;

class Engine
{
    private array $data;

    private ?string $layout;

    private ?string $content;

    private string $path;

    private array $dependencies;

    public function __construct(string $path)
    {
        if (!is_dir($path)) {
            throw new Exception($path . ' Is Not a valid dir');
        }

        $this->path = $path;
    }

    /**
     * @throws \ReflectionException
     */
    public function dependencies(array $dependencies): void
    {
        foreach ($dependencies as $dependency) {
            $className = strtolower((new ReflectionClass($dependency))->getShortName());
            $this->dependencies[$className] = $dependency;
        }
    }

    private function load(): string
    {
        return !is_null($this->content) ? $this->content : '';
    }

    private function extends(string $layout, array $data = []): void
    {
        $this->layout = $layout;
        $this->data = array_merge($this->data, $data);
    }

    public function render(string $viewName, array $data): string
    {
        $file = $this->path . $viewName . '.php';

        if (!file_exists($file)) {
            throw new Exception('file ' . $file . ' not found');
        }

        ob_start();

        $this->data = $data;
        require $file;
        $content = ob_get_contents();

        ob_end_clean();

        if (!is_null($this->layout)) {
            $this->content = $content;
            $data = array_merge($this->data, $data);
            $layout = $this->layout;
            $this->layout = null;
            return $this->render($layout, $data);
        }

        return $content;
    }

    public function __call(string $name, array $arguments)
    {
        if (!method_exists($this->dependencies['macros'], $name)) {
            throw new Exception('Method ' . $name . ' does not exist');
        }

        if (empty($arguments)) {
            throw new Exception('Method ' . $name . ' need arguments');
        }

        return forward_static_call_array([
            $this->dependencies['macros'], $name
        ], $arguments);
    }

    public function __get(string $name)
    {
        return $this->data[$name];
    }
}