<?php

declare(strict_types=1);

namespace App\Template;

use App\Template;
use Ronanchilvers\Utility\File;

class Factory
{
    protected static $baseDir;

    public static function setBaseDir(string $baseDir)
    {
        if (!is_dir($baseDir)) {
            throw new \Exception(sprintf(
                "Base dir %s doesn't exist",
                $baseDir
            ));
        }
        static::$baseDir = $baseDir;
    }

    public static function make(string $template): Template
    {
        $path = File::join(
            static::$baseDir,
            $template
        );

        return new Template($path);
    }

    public static function exists(string $template): bool
    {
        $path = File::join(
            static::$baseDir,
            $template
        );

        return file_exists($path);
    }
}
