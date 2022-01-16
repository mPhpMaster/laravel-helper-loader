<?php
/*
 * Copyright © 2020. mPhpMaster(https://github.com/mPhpMaster) All rights reserved.
 */

namespace MPhpMaster\LaravelHelperLoader;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Symfony\Component\Finder\SplFileInfo;

/**
 * Class HelpersLoader
 */
class HelperLoader
{
    /**
     * Included paths
     * @var array
     */
    protected static $included = [];

    /** @var string|null */
    public ?string $path;
    /** @var Collection|null */
    public ?Collection $files = null;

    /**
     * HelpersLoader constructor.
     *
     * @param string|null $directory_name
     */
    public function __construct(?string $directory_name = null)
    {
        $this->files = collect();
        if( $this->setPath($directory_name) ) {
            $this->files = collect((new Filesystem)->files($this->path))
                ->filter(fn(SplFileInfo $current_file) => static::isIncludable($current_file))
                ->map(
                    static fn(SplFileInfo $current_file) => include_once(static::registerIncludedPath($current_file))
                );
        }
    }

    public function setPath($path): bool
    {
        $path = (
            ($path = value($path)) &&
            file_exists($path) &&
            is_readable($path) &&
            is_dir($path)
        ) ? $path : false;

        if( !$path ) {
            if( config('app.debug') == true && isRunningInConsole() ) {
                dump(" # Failed to load Path: {$path}");
            }

            return false;
        }

        $this->path = $path;
        return true;
    }

    public static function isIncluded(SplFileInfo $current_file): bool
    {
        return in_array($current_file->getRealPath(), self::$included, true);
    }

    public static function hasAllowedSuffix(SplFileInfo $current_file): bool
    {
        $allowed_suffix = toCollect((array) config('helper-loader.allowed_suffix', [ '.functions', '.class' ]))
            ->filter();

        return !$allowed_suffix->count() ||
               ends_with(pathinfo($current_file->getFilename(), PATHINFO_FILENAME), $allowed_suffix->toArray());
    }

    public static function hasAllowedExtension(SplFileInfo $current_file): bool
    {
        $allowed_extension = str_start(trim(config('helper-loader.allowed_extension', '.php')), '.');
        return empty($allowed_extension) ||
               ("." . $current_file->getExtension() === $allowed_extension);
    }

    public static function isIncludable(SplFileInfo $current_file): bool
    {
        return !static::isIncluded($current_file) &&
               static::hasAllowedSuffix($current_file) &&
               static::hasAllowedExtension($current_file) &&
               $current_file->isFile() &&
               $current_file->isReadable();
    }

    public static function registerIncludedPath(SplFileInfo $current_file): string
    {
        self::$included[] = $path = $current_file->getRealPath();
        self::$included = array_unique(self::$included);
        return $path;
    }

    public static function autoLoad(...$paths): int
    {
        $paths = array_merge($paths, (array) config('helper-loader.auto_load_paths', []));
        if( !empty($paths) ) {
            foreach( $paths as $path ) {
                new static($path);
            }
        }

        return count($paths);
    }
}
