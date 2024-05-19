<?php
namespace Edith\Admin\Contracts;

use Illuminate\Filesystem\Filesystem;

interface EdithModuleCoreInterface
{
    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @return Filesystem
     */
    public function getFiles(): Filesystem;

    /**
     * @param string $name
     * @return bool
     */
    public function enabled(string $name): bool;

    /**
     * @param string $name
     * @return bool
     */
    public function disabled(string $name): bool;

    /**
     * @param string $name
     * @param bool $install
     * @return EdithModuleInterface
     */
    public function findOrFail(string $name, bool $install = false): EdithModuleInterface;

    /**
     * @return array|null
     */
    public function scan(): ?array;
}