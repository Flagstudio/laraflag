<?php

namespace App\Ship\Apiato\Foundation;

use App\Ship\Apiato\Exceptions\ClassDoesNotExistException;
use App\Ship\Apiato\Exceptions\MissingContainerException;
use App\Ship\Apiato\Exceptions\WrongConfigurationsException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class Apiato
{
    public function getContainersNamespace(): string
    {
        return Config::get('apiato.containers.namespace');
    }

    public function getContainersNames(): array
    {
        $containersNames = [];

        foreach ($this->getContainersPaths() as $containersPath) {
            $containersNames[] = basename($containersPath);
        }

        return $containersNames;
    }

    public function getShipFoldersNames(): array
    {
        $portFoldersNames = [];

        foreach ($this->getShipPath() as $portFoldersPath) {
            $portFoldersNames[] = basename($portFoldersPath);
        }

        return $portFoldersNames;
    }

    public function getContainersPaths(): array
    {
        return File::directories(app_path('Containers'));
    }

    public function getShipPath(): array
    {
        return File::directories(app_path('Ship'));
    }

    public function getClassObjectFromFile($filePathName)
    {
        $classString = $this->getClassFullNameFromFile($filePathName);

        $object = new $classString;

        return $object;
    }

    public function getClassFullNameFromFile(string $filePathName): string
    {
        return $this->getClassNamespaceFromFile($filePathName) . '\\' . $this->getClassNameFromFile($filePathName);
    }

    protected function getClassNamespaceFromFile(string $filePathName): ?string
    {
        $src = file_get_contents($filePathName);

        $tokens = token_get_all($src);
        $count = count($tokens);
        $i = 0;
        $namespace = '';
        $namespace_ok = false;
        while ($i < $count) {
            $token = $tokens[$i];
            if (is_array($token) && $token[0] === T_NAMESPACE) {
                // Found namespace declaration
                while (++$i < $count) {
                    if ($tokens[$i] === ';') {
                        $namespace_ok = true;
                        $namespace = trim($namespace);
                        break;
                    }
                    $namespace .= is_array($tokens[$i]) ? $tokens[$i][1] : $tokens[$i];
                }
                break;
            }
            $i++;
        }
        if (!$namespace_ok) {
            return null;
        }
        return $namespace;
    }

    protected function getClassNameFromFile(string $filePathName)
    {
        $php_code = file_get_contents($filePathName);

        $classes = [];
        $tokens = token_get_all($php_code);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_CLASS
                && $tokens[$i - 1][0] == T_WHITESPACE
                && $tokens[$i][0] == T_STRING
            ) {
                $class_name = $tokens[$i][1];
                $classes[] = $class_name;
            }
        }

        return $classes[0];
    }

    public function stringStartsWith(string $word, string $startsWith): string
    {
        return (substr($word, 0, strlen($startsWith)) === $startsWith);
    }

    public function uncamelize(string $word, string $splitter = " ", bool $uppercase = true): string
    {
        $word = preg_replace(
            '/(?!^)[[:upper:]][[:lower:]]/',
            '$0',
            preg_replace('/(?!^)[[:upper:]]+/', $splitter . '$0', $word)
        );

        return $uppercase ? ucwords($word) : $word;
    }

    public function getLoginWebPageName()
    {
        $loginPage = Config::get('apiato.containers.login-page-url');

        if (is_null($loginPage)) {
            throw new WrongConfigurationsException();
        }

        return $loginPage;
    }

    public function buildClassFullName(string $containerName, string $className): string
    {
        return 'App\Containers\\' . $containerName . '\\' . $this->getClassType($className) . 's\\' . $className;
    }

    public function getClassType(string $className): string
    {
        $array = preg_split('/(?=[A-Z])/', $className);

        return end($array);
    }

    public function verifyContainerExist(string $containerName)
    {
        if (!is_dir(app_path('Containers/' . $containerName))) {
            throw new MissingContainerException("Container ($containerName) is not installed.");
        }
    }

    public function verifyClassExist(string $className)
    {
        if (!class_exists($className)) {
            throw new ClassDoesNotExistException("Class ($className) is not installed.");
        }
    }
}
