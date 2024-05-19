<?php
namespace Edith\Admin\Contracts;

use Edith\Admin\Support\Json;
use Illuminate\Filesystem\Filesystem;

interface EdithModuleInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getLowerName(): string;

    /**
     * @return string
     */
    public function getStudlyName(): string;

    /**
     * @return string
     */
    public function getSnakeName(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return array
     */
    public function getAliases(): array;

    /**
     * @return int
     */
    public function getPriority(): int;

    /**
     * @return string
     */
    public function getVersion(): string;

    /**
     * @return array
     */
    public function getRequires(): array;

    /**
     * @return string
     */
    public function getPath(): string;

    /**
     * @param string $path
     * @return EdithModuleInterface
     */
    public function setPath(string $path): EdithModuleInterface;

    /**
     * @param string $path
     * @return string
     */
    public function getExtraPath(string $path) : string;

    /**
     * @param Json $json
     * @return mixed
     */
    public function withComposerProperty(Json $json);

    /**
     * @param Json $moduleProperty
     * @return mixed
     */
    public function withModuleProperty(Json $moduleProperty);

    /**
     * @return void
     */
    public function install(): void;

    /**
     * @return void
     */
    public function uninstall(): void;

    /**
     * @param bool $down
     * @return void
     */
    public function runMigrations(bool $down = false): void;

    /**
     * @return string
     */
    public function getAssetPath(): string;
}