<?php

declare(strict_types=1);

namespace cse\DOMManager\Nodes;

use Closure;
use cse\DOMManager\Contracts\IChildNodeHandleable;
use cse\DOMManager\Contracts\IContentParsable;
use cse\DOMManager\Contracts\INodeHandleable;
use cse\DOMManager\Contracts\INodeListInstance;
use cse\DOMManager\Contracts\INodeListHandleable;
use cse\DOMManager\Contracts\INodesInstance;
use cse\DOMManager\Contracts\IParentNodeHandleable;
use DOMComment;
use DOMDocument;
use DOMElement;
use DOMNode;
use DOMNodeList;
use DOMText;

class Nodes implements INodesInstance
{
    /** @var INodeListInstance $nodeList */
    protected $nodeList;

    /** @var IChildNodeHandleable $childNodeHandler */
    protected $childNodeHandler;

    /** @var INodeHandleable $nodeHandler */
    protected $nodeHandler;

    /** @var INodeListHandleable $nodeListHandler */
    protected $nodeListHandler;

    /** @var IParentNodeHandleable $parentNodeHandler */
    protected $parentNodeHandler;

    /** @var IContentParsable $contentParser */
    protected $contentParser;

    /**
     * Nodes constructor.
     *
     * @param INodeListInstance $nodeList
     * @param IChildNodeHandleable $childNodeHandler
     * @param INodeHandleable $nodeHandler
     * @param INodeListHandleable $nodeListHandler
     * @param IParentNodeHandleable $parentNodeHandler
     * @param IContentParsable $contentParser
     */
    public function __construct(
        INodeListInstance     $nodeList,
        IChildNodeHandleable  $childNodeHandler,
        INodeHandleable       $nodeHandler,
        INodeListHandleable   $nodeListHandler,
        IParentNodeHandleable $parentNodeHandler,
        IContentParsable      $contentParser
    ) {
        $this->nodeList = $nodeList;
        $this->childNodeHandler = $childNodeHandler;
        $this->nodeHandler = $nodeHandler;
        $this->nodeListHandler = $nodeListHandler;
        $this->parentNodeHandler = $parentNodeHandler;
        $this->contentParser = $contentParser;
    }

    /**
     * @param string $text
     *
     * @return Nodes
     */
    public function addText(string $text): INodesInstance
    {
        $this->nodeListHandler->addText($this->toList(), $text);

        return $this;
    }

    /**
     * @param string|INodesInstance|INodeListInstance|DOMNode|DOMNodeList|DOMDocument $content
     * @param string|null $node_name
     *
     * @return Nodes
     */
    public function appendChild($content, ?string $node_name = null): INodesInstance
    {
        $newNodeList = $this->contentParser->parse($content);
        if (isset($node_name)) {
            $this->nodeList = $this->nodeHandler->appendChildes($node_name, $this->toList(), $newNodeList);
        } else {
            $this->nodeList = $this->nodeListHandler->appendChildes($this->toList(), $newNodeList);
        }

        return $this;
    }

    /**
     * @param string $attribute
     * @param string|null $default
     *
     * @return string|null
     */
    public function attr(string $attribute, ?string $default = null): ?string
    {
        return $this->nodeListHandler->attr($this->toList(), $attribute, $default) ?: $default;
    }

    /**
     * @param string|null $node_name
     *
     * @return Nodes
     */
    public function childes(?string $node_name = null): INodesInstance
    {
        if (isset($node_name)) {
            $list = $this->nodeHandler->findChildByNodeName($node_name, $this->toList()->copy(), true);
        } else {
            $list = $this->childNodeHandler->pull($this->toList()->copy(), true);
        }

        return $this->new($list);
    }

    /**
     * @param string|INodesInstance|INodeListInstance|DOMNode|DOMNodeList|DOMDocument $content
     *
     * @return Nodes
     */
    public function add($content): INodesInstance
    {
        $this->nodeList = $this->nodeListHandler->addList($this->toList(), $this->contentParser->parse($content));

        return $this;
    }

    /**
     * @param string|null $node_name
     *
     * @return Nodes
     */
    public function closest(?string $node_name = null): INodesInstance
    {
        if (isset($node_name)) {
            $list = $this->parentNodeHandler->closest($node_name, $this->toList()->copy());
        } else {
            $list = $this->parentNodeHandler->parent($this->toList()->copy());
        }
        return $this->new($list);
    }

    /**
     * @return Nodes
     */
    public function parent(): INodesInstance
    {
        return $this->closest();
    }

    /**
     * @param string|null $node_name
     *
     * @return int
     */
    public function count(?string $node_name = null): int
    {
        if (isset($node_name)) {
            return $this->nodeHandler->count($node_name, $this->toList());
        } else {
            return $this->toList()->count();
        }
    }

    /**
     * @param int $position
     *
     * @return DOMNode|null
     */
    public function getNodeByPosition(int $position): ?DOMNode
    {
        return $this->toList()->peek($position);
    }

    /**
     * @param int $position
     * @param string $node_name
     *
     * @return DOMNode[]|null
     */
    public function findNodeByPosition(int $position, string $node_name): ?array
    {
        return $this->nodeHandler->findNodesByPosition($node_name, $position, $this->toList()->copy())->pull();
    }

    /**
     * @param Closure $closure
     *
     * @return Nodes[]
     */
    public function each(Closure $closure): array
    {
        $data = [];
        foreach ($this->toList()->all() as $key => $node) {
            $data[] = $closure($this->new($node), $key);
        }

        return $data;
    }

    /**
     * @param string|null $node_name
     *
     * @return bool
     */
    public function exist(?string $node_name = null): bool
    {
        return $this->count($node_name) > 0;
    }

    /**
     * @param string $node_name
     *
     * @return Nodes
     */
    public function find(string $node_name): INodesInstance
    {
        return $this->new($this->nodeHandler->find($node_name, $this->toList()->copy()));
    }

    /**
     * @param string|null $node_name
     *
     * @return Nodes
     */
    public function first(?string $node_name = null): INodesInstance
    {
        if (isset($node_name)) {
            $data = $this->new($this->nodeHandler->firstNodes($node_name, $this->toList()->copy()));
        } else {
            $data = $this->new($this->getNodeByPosition(0));
        }

        return $this->new($data);
    }

    /**
     * @param int $position
     * @param string|null $node_name
     *
     * @return Nodes
     */
    public function getByPosition(int $position, ?string $node_name = null): INodesInstance
    {
        if (isset($node_name)) {
            $data = $this->nodeHandler->findNodesByPosition($node_name, $position, $this->toList()->copy());
        } else {
            $data = $this->getNodeByPosition($position);
        }

        return $this->new($data);
    }

    /**
     * @param string|null $node_name
     *
     * @return Nodes
     */
    public function firstChild(?string $node_name = null): INodesInstance
    {
        if (isset($node_name)) {
            $list = $this->nodeHandler->findChildByNodeName($node_name, $this->toList()->copy(), false);
        } else {
            $list = $this->childNodeHandler->pull($this->toList()->copy(), false);
        }

        return $this->new($list);
    }

    /**
     * @param string $attribute
     *
     * @return bool
     */
    public function hasAttr(string $attribute): bool
    {
        return $this->nodeListHandler->hasAttr($this->toList(), $attribute);
    }

    /**
     * @return bool
     */
    public function isDomComment(): bool
    {
        return $this->isElem() && $this->getNodeByPosition(0) instanceof DOMComment;
    }

    /**
     * @return bool
     */
    public function isDomElement(): bool
    {
        return $this->isElem() && $this->getNodeByPosition(0) instanceof DOMElement;
    }

    /**
     * @return bool
     */
    public function isDomText(): bool
    {
        return $this->isElem() && $this->getNodeByPosition(0) instanceof DOMText;
    }

    /**
     * @return bool
     */
    public function isElem(): bool
    {
        return $this->count() == 1;
    }

    /**
     * @return bool
     */
    public function isList(): bool
    {
        return $this->count() > 1;
    }

    /**
     * @param string|null $node_name
     *
     * @return Nodes
     */
    public function last(?string $node_name = null): INodesInstance
    {
        if (isset($node_name)) {
            $data = $this->nodeHandler->lastNodes($node_name, $this->toList()->copy());
        } else {
            $data = $this->getNodeByPosition($this->count() - 1);
        }
        return $this->new($data);
    }

    /**
     * @return Nodes
     */
    public function root(): INodesInstance
    {
        return $this->new($this->parentNodeHandler->root($this->toList()));
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->nodeListHandler->name($this->toList());
    }

    /**
     * @param string|null $node_name
     *
     * @return bool
     */
    public function notExist(?string $node_name = null): bool
    {
        return $this->count($node_name) == 0;
    }

    /**
     * @param string|null $node_name
     *
     * @return Nodes
     */
    public function remove(?string $node_name = null): INodesInstance
    {
        if (isset($node_name)) {
            $this->nodeHandler->remove($node_name, $this->toList());
        } elseif ($this->isList()) {
            $this->nodeListHandler->remove($this->toList());
        } else {
            $this->nodeListHandler->removeFirst($this->toList());
        }

        return $this;
    }

    /**
     * @param string $attribute
     *
     * @return Nodes
     */
    public function removeAttr(string $attribute): INodesInstance
    {
        $this->nodeListHandler->removeAttr($this->toList(), $attribute);

        return $this;
    }

    /**
     * @param string|null $node_name
     *
     * @return INodesInstance
     */
    public function removeChildes(?string $node_name = null): INodesInstance
    {
        if (isset($node_name)) {
            $this->childNodeHandler->removeByName($node_name, $this->toList());
        } else {
            $this->childNodeHandler->remove($this->toList());
        }

        return $this;
    }

    /**
     * @return Nodes
     */
    public function removeText(): INodesInstance
    {
        $this->nodeListHandler->removeText($this->toList());

        return $this;
    }

    /**
     * @param string $new_node_name
     * @param string|null $old_node_name
     *
     * @return Nodes
     */
    public function rename(string $new_node_name, ?string $old_node_name = null): INodesInstance
    {
        if (isset($old_node_name)) {
            $this->nodeHandler->rename($new_node_name, $old_node_name, $this->toList());
        } else {
            $this->nodeListHandler->rename($new_node_name, $this->toList());
        }

        return $this;
    }

    /**
     * @param string|INodesInstance|INodeListInstance|DOMNode|DOMNodeList|DOMDocument $content
     * @param string|null $node_name
     *
     * @return Nodes
     */
    public function replace($content, ?string $node_name = null): INodesInstance
    {
        $newNodeList = $this->contentParser->parse($content);
        if (isset($node_name)) {
            $this->nodeHandler->replace($node_name, $this->toList(), $newNodeList);
        } else {
            $this->nodeListHandler->replace($this->toList(), $newNodeList);
        }

        return $this->root();
    }

    /**
     * @param string|INodesInstance|INodeListInstance|DOMNode|DOMNodeList|DOMDocument $content
     *
     * @param string|null $node_name
     *
     * @return Nodes
     */
    public function replaceChildes($content, ?string $node_name = null): INodesInstance
    {
        $newNodeList = $this->contentParser->parse($content);
        if (isset($node_name)) {
            $this->childNodeHandler->replaceByName($node_name, $this->toList(), $newNodeList);
        } else {
            $this->childNodeHandler->replace($this->toList(), $newNodeList);
        }

        return $this;
    }

    /**
     * @param string $text
     *
     * @return Nodes
     */
    public function replaceText(string $text): INodesInstance
    {
        $this->nodeListHandler->replaceText($this->toList(), $text);

        return $this;
    }

    /**
     * @param string $attribute
     * @param string $value
     *
     * @return Nodes
     */
    public function setAttr(string $attribute, string $value): INodesInstance
    {
        $this->nodeListHandler->setAttr($this->toList(), $attribute, $value);

        return $this;
    }

    /**
     * @return string
     */
    public function text(): string
    {
        return $this->nodeListHandler->text($this->toList());
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->nodeListHandler->type($this->toList());
    }

    /**
     * @return DOMNode[]
     */
    public function toArray(): array
    {
        return $this->toList()->all();
    }

    /**
     * @return INodeListInstance
     */
    public function toList(): INodeListInstance
    {
        return $this->nodeList;
    }

    /**
     * @param string|null $node_name
     *
     * @return string
     */
    public function toString(?string $node_name = null): string
    {
        if (isset($node_name)) {
            return $this->nodeHandler->toString($node_name, $this->toList());
        } else {
            return $this->nodeListHandler->toString($this->toList());
        }
    }

    /**
     * @param string|array|INodesInstance|INodeListInstance|DOMNode|DOMNodeList|DOMDocument|null $content
     *
     * @return INodesInstance
     */
    protected function new($content = null): INodesInstance
    {
        $nodes = new self(
            $this->toList()->new(),
            $this->childNodeHandler,
            $this->nodeHandler,
            $this->nodeListHandler,
            $this->parentNodeHandler,
            $this->contentParser
        );
        if (!empty($content)) {
            $nodes->add($content);
        }
        return $nodes;
    }
}
