<?php

declare(strict_types=1);

namespace cse\DOMManager\Handlers\Nodes;

use cse\DOMManager\Contracts\IDomNodeHandleable;
use cse\DOMManager\Contracts\IDomNodeListHandleable;
use cse\DOMManager\Contracts\INodeListInstance;
use cse\DOMManager\Contracts\INodeListHandleable;

final class NodeListHandler implements INodeListHandleable
{
    /** @var IDomNodeHandleable $domNodeHandler */
    protected $domNodeHandler;

    /** @var IDomNodeListHandleable $domNodeListHandler */
    protected $domNodeListHandler;

    /**
     * NodeListHandler constructor.
     *
     * @param IDomNodeHandleable $domNodeHandler
     * @param IDomNodeListHandleable $domNodeListHandler
     */
    public function __construct(
        IDomNodeHandleable  $domNodeHandler,
        IDomNodeListHandleable $domNodeListHandler
    ) {
        $this->domNodeHandler = $domNodeHandler;
        $this->domNodeListHandler = $domNodeListHandler;
    }

    /**
     * @param INodeListInstance $nodeList
     * @param string $text
     *
     * @return void
     */
    public function addText(INodeListInstance $nodeList, string $text): void
    {
        foreach ($nodeList->all() as $domNode) {
            $domNode->appendChild($domNode->ownerDocument->createTextNode($text));
        }
    }

    /**
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newNodeList
     *
     * @return INodeListInstance
     */
    public function addList(INodeListInstance $nodeList, INodeListInstance $newNodeList): INodeListInstance
    {
        if ($nodeList->isEmpty()) {
            return $nodeList->replace($newNodeList);
        } elseif ($newNodeList->isEmpty()) {
            return $nodeList;
        }

        foreach ($newNodeList->pull() as $domNode) {
            $nodeList->push($domNode);
        }

        return $nodeList;
    }

    /**
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newNodeList
     *
     * @return INodeListInstance
     */
    public function appendChildes(INodeListInstance $nodeList, INodeListInstance $newNodeList): INodeListInstance
    {
        if ($nodeList->isEmpty()) {
            return $newNodeList;
        } elseif ($newNodeList->isEmpty()) {
            return $nodeList;
        }

        foreach ($nodeList->all() as $domNode) {
            foreach ($newNodeList->all() as $newDomNode) {
                $this->domNodeHandler->appendChild($domNode, $newDomNode);
            }
        }

        return $nodeList;
    }

    /**
     * @param INodeListInstance $nodeList
     * @param string $attribute
     * @param string|null $default
     *
     * @return string
     */
    public function attr(INodeListInstance $nodeList, string $attribute, ?string $default = null): string
    {
        $list = [];

        foreach ($nodeList->all() as $domNode) {
            if ($domNode->hasAttribute($attribute)) {
                $list[] = $domNode->getAttribute($attribute);
            } elseif (!is_null($default)) {
                $list[] = $default;
            }
        }

        return implode(PHP_EOL, $list);
    }

    /**
     * @param INodeListInstance $nodeList
     *
     * @return string
     */
    public function toString(INodeListInstance $nodeList): string
    {
        $list = [];

        foreach ($nodeList->all() as $domNode) {
            $list[] = $domNode->ownerDocument->saveXML($domNode);
        }

        return implode(PHP_EOL, $list);
    }

    /**
     * @param INodeListInstance $nodeList
     * @param string $attribute
     *
     * @return bool
     */
    public function hasAttr(INodeListInstance $nodeList, string $attribute): bool
    {
        if ($nodeList->isEmpty()) {
            return false;
        }

        foreach ($nodeList->all() as $domNode) {
            if (!$domNode->hasAttribute($attribute)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param INodeListInstance $nodeList
     *
     * @return string
     */
    public function name(INodeListInstance $nodeList): string
    {
        $list = [];

        foreach ($nodeList->all() as $domNode) {
            $list[] = $domNode->nodeName;
        }

        return implode(PHP_EOL, $list);
    }

    /**
     * @param INodeListInstance $nodeList
     * @param string $attribute
     *
     * @return void
     */
    public function removeAttr(INodeListInstance $nodeList, string $attribute): void
    {
        if ($nodeList->isEmpty()) {
            return;
        }
        foreach ($nodeList->all() as $domNode) {
            $domNode->removeAttribute($attribute);
        }
    }

    /**
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function removeFirst(INodeListInstance $nodeList): INodeListInstance
    {
        if ($nodeList->exist()) {
            $dom_lists = $nodeList->pull();
            $parentNode = $this->domNodeHandler->remove($dom_lists[0]);
            if (isset($parentNode)) {
                $nodeList->push($parentNode->ownerDocument->documentElement);
            }
        }

        return $nodeList;
    }

    /**
     * @param INodeListInstance $nodeList
     *
     * @return INodeListInstance
     */
    public function remove(INodeListInstance $nodeList): INodeListInstance
    {
        if ($nodeList->isEmpty()) {
            return $nodeList;
        }

        foreach ($nodeList->pull() as $domNode) {
            $parentNode = $this->domNodeHandler->remove($domNode);
            if (is_null($parentNode)) {
                break;
            }
        }

        if (isset($parentNode)) {
            $nodeList->push($this->domNodeHandler->rootElement($parentNode));
        }

        return $nodeList;
    }

    /**
     * @param INodeListInstance $nodeList
     *
     * @return void
     */
    public function removeText(INodeListInstance $nodeList): void
    {
        foreach ($nodeList->all() as $domNode) {
            if ($domNode->hasChildNodes()) {
                $domList = $domNode->childNodes;
                foreach ($this->domNodeListHandler->toArray($domList) as $childDomNode) {
                    if ($this->domNodeHandler->isText($childDomNode)) {
                        $this->domNodeHandler->remove($childDomNode);
                    }
                }
            }
        }
    }

    /**
     * @param string $new_name
     * @param INodeListInstance $nodeList
     *
     * @return void
     */
    public function rename(string $new_name, INodeListInstance $nodeList): void
    {
        foreach ($nodeList->pull() as $domNode) {
            $nodeList->push($this->domNodeHandler->rename($new_name, $domNode));
        }
    }

    /**
     * @param INodeListInstance $nodeList
     * @param INodeListInstance $newNodeList
     *
     * @return INodeListInstance
     */
    public function replace(INodeListInstance $nodeList, INodeListInstance $newNodeList): INodeListInstance
    {
        if ($newNodeList->isEmpty()) {
            return $nodeList;
        }

        $newNode = $newNodeList->pop();
        foreach ($nodeList->pull() as $oldNode) {
            $nodeList->push($this->domNodeHandler->replace($oldNode, $newNode));
        }

        return $nodeList;
    }

    /**
     * @param INodeListInstance $nodeList
     * @param string $text
     *
     * @return void
     */
    public function replaceText(INodeListInstance $nodeList, string $text): void
    {
        foreach ($nodeList->all() as $node) {
            $newNode = $node->ownerDocument->createTextNode($text);
            $textNode = null;

            if ($node->hasChildNodes()) {
                $domList = $node->childNodes;
                foreach ($this->domNodeListHandler->toArray($domList) as $domNode) {
                    if ($this->domNodeHandler->isText($domNode)) {
                        $textNode = $domNode;
                    }
                }
            }

            if (is_null($textNode)) {
                $node->appendChild($newNode);
            } else {
                $node->replaceChild($newNode, $textNode);
            }
        }
    }

    /**
     * @param INodeListInstance $nodeList
     * @param string $attribute
     * @param string $value
     *
     * @return void
     */
    public function setAttr(INodeListInstance $nodeList, string $attribute, string $value): void
    {
        foreach ($nodeList->all() as $domNode) {
            $domNode->setAttribute($attribute, $value);
        }
    }

    /**
     * @param INodeListInstance $nodeList
     *
     * @return string
     */
    public function text(INodeListInstance $nodeList): string
    {
        $list = [];

        foreach ($nodeList->all() as $domNode) {
            $list[] = $domNode->nodeValue;
        }

        return implode(PHP_EOL, $list);
    }

    /**
     * @param INodeListInstance $nodeList
     *
     * @return string
     */
    public function type(INodeListInstance $nodeList): string
    {
        $list = [];

        foreach ($nodeList->all() as $domNode) {
            $list[] = $domNode->nodeType;
        }

        return implode(PHP_EOL, $list);
    }
}
