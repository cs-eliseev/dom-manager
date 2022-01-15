<?php

declare(strict_types=1);

namespace cse\DOMManager\Contracts;

interface INodesInstance
{
    /**
     * @param string $text
     *
     * @return INodesInstance
     */
    public function addText(string $text): INodesInstance;

    /**
     * @param string|INodesInstance|INodeListInstance|\DOMNode|\DOMNodeList|\DOMDocument $content
     * @param string|null $node_name
     *
     * @return INodesInstance
     */
    public function appendChild($content, ?string $node_name = null): INodesInstance;

    /**
     * @param string|null $node_name
     *
     * @return INodesInstance
     */
    public function childes(?string $node_name = null): INodesInstance;

    /**
     * @param string|null $node_name
     *
     * @return INodesInstance
     */
    public function closest(?string $node_name = null): INodesInstance;

    /**
     * @return INodesInstance
     */
    public function parent(): INodesInstance;

    /**
     * @param string|null $node_name
     *
     * @return int
     */
    public function count(?string $node_name = null): int;

    /**
     * @param int $position
     *
     * @return \DOMNode|null
     */
    public function getNodeByPosition(int $position): ?\DOMNode;

    /**
     * @param int $position
     * @param string $node_name
     *
     * @return \DOMNode[]|null
     */
    public function findNodeByPosition(int $position, string $node_name): ?array;

    /**
     * @param \Closure $closure
     *
     * @return INodesInstance[]
     */
    public function each(\Closure $closure): array;

    /**
     * @param string|null $node_name
     *
     * @return bool
     */
    public function exist(?string $node_name = null): bool;

    /**
     * @param string $node_name
     *
     * @return INodesInstance
     */
    public function find(string $node_name): INodesInstance;

    /**
     * @param string|null $node_name
     *
     * @return INodesInstance
     */
    public function first(?string $node_name = null): INodesInstance;

    /**
     * @param int $position
     * @param string|null $node_name
     *
     * @return INodesInstance
     */
    public function getByPosition(int $position, ?string $node_name = null): INodesInstance;

    /**
     * @param string|null $node_name
     *
     * @return INodesInstance
     */
    public function firstChild(?string $node_name = null): INodesInstance;

    /**
     * @param string $attribute
     *
     * @return bool
     */
    public function hasAttr(string $attribute): bool;

    /**
     * @return bool
     */
    public function isDomComment(): bool;

    /**
     * @return bool
     */
    public function isDomElement(): bool;

    /**
     * @return bool
     */
    public function isDomText(): bool;

    /**
     * @return bool
     */
    public function isElem(): bool;

    /**
     * @return bool
     */
    public function isList(): bool;

    /**
     * @param string|null $node_name
     *
     * @return INodesInstance
     */
    public function last(?string $node_name = null): INodesInstance;

    /**
     * @return INodesInstance
     */
    public function root(): INodesInstance;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @param string|null $node_name
     *
     * @return bool
     */
    public function notExist(?string $node_name = null): bool;

    /**
     * @param string|null $node_name
     *
     * @return INodesInstance
     */
    public function remove(?string $node_name = null): INodesInstance;

    /**
     * @param string $attribute
     *
     * @return INodesInstance
     */
    public function removeAttr(string $attribute): INodesInstance;

    /**
     * @return INodesInstance
     */
    public function removeText(): INodesInstance;

    /**
     * @param string $new_node_name
     * @param string|null $old_node_name
     *
     * @return INodesInstance
     */
    public function rename(string $new_node_name, ?string $old_node_name = null): INodesInstance;

    /**
     * @param string|INodesInstance|INodeListInstance|\DOMNode|\DOMNodeList|\DOMDocument $content
     * @param string|null $node_name
     *
     * @return INodesInstance
     */
    public function replace($content, ?string $node_name = null): INodesInstance;

    /**
     * @param string|INodesInstance|INodeListInstance|\DOMNode|\DOMNodeList|\DOMDocument $content
     *
     * @param string|null $node_name
     *
     * @return INodesInstance
     */
    public function replaceChildes($content, ?string $node_name = null): INodesInstance;

    /**
     * @param string $text
     *
     * @return INodesInstance
     */
    public function replaceText(string $text): INodesInstance;

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return INodesInstance
     */
    public function setAttr(string $attribute, string $value): INodesInstance;

    /**
     * @return string
     */
    public function text(): string;

    /**
     * @return string
     */
    public function type(): string;

    /**
     * @return \DOMNode[]
     */
    public function toArray(): array;

    /**
     * @return INodeListInstance
     */
    public function toList(): INodeListInstance;

    /**
     * @param string|null $node_name
     *
     * @return string
     */
    public function toString(?string $node_name = null): string;
}
