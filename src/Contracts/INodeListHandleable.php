<?php

declare(strict_types=1);

namespace cse\DOMManager\Contracts;

interface INodeListHandleable
{
    /**
     * @param INodeListInstance $nodeList
     * @param string $text
     *
     * @return void
     */
    public function addText(INodeListInstance $nodeList, string $text): void;

    /**
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newNodeList
     *
     * @return INodeListInstance
     */
    public function appendChildes(INodeListInstance $nodeList, INodeListInstance $newNodeList): INodeListInstance;

    /**
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newNodeList
     *
     * @return INodeListInstance
     */
    public function addList(INodeListInstance $nodeList, INodeListInstance $newNodeList): INodeListInstance;

    /**
     * @param INodeListInstance $nodeList
     * @param string $attribute
     * @param string|null $default
     *
     * @return string
     */
    public function attr(INodeListInstance $nodeList, string $attribute, ?string $default = null): string;

    /**
     * @param INodeListInstance $nodeList
     *
     * @return string
     */
    public function toString(INodeListInstance $nodeList): string;

    /**
     * @param INodeListInstance $nodeList
     * @param string $attribute
     *
     * @return bool
     */
    public function hasAttr(INodeListInstance $nodeList, string $attribute): bool;

    /**
     * @param INodeListInstance $nodeList
     *
     * @return string
     */
    public function name(INodeListInstance $nodeList): string;

    /**
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function remove(INodeListInstance $nodeList): INodeListInstance;

    /**
     * @param INodeListInstance $nodeList
     * @param string $attribute
     *
     * @return void
     */
    public function removeAttr(INodeListInstance $nodeList, string $attribute): void;

    /**
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function removeFirst(INodeListInstance $nodeList): INodeListInstance;

    /**
     * @param INodeListInstance $nodeList
     *
     * @return void
     */
    public function removeText(INodeListInstance $nodeList): void;

    /**
     * @param string $new_name
     * @param INodeListInstance $nodeList
     *
     * @return void
     */
    public function rename(string $new_name, INodeListInstance $nodeList): void;

    /**
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newNodeList
     *
     * @return INodeListInstance
     */
    public function replace(INodeListInstance $nodeList, INodeListInstance $newNodeList): INodeListInstance;

    /**
     * @param INodeListInstance $nodeList
     * @param string $text
     *
     * @return void
     */
    public function replaceText(INodeListInstance $nodeList, string $text): void;

    /**
     * @param INodeListInstance $nodeList
     * @param string $attribute
     * @param string $value
     *
     * @return void
     */
    public function setAttr(INodeListInstance $nodeList, string $attribute, string $value): void;

    /**
     * @param INodeListInstance $nodeList
     *
     * @return string
     */
    public function text(INodeListInstance $nodeList): string;

    /**
     * @param INodeListInstance $nodeList
     *
     * @return string
     */
    public function type(INodeListInstance $nodeList): string;
}
