<?php

declare(strict_types=1);

namespace Tests;

use cse\DOMManager\Contracts\INodeListInstance;
use cse\DOMManager\DomManager;
use cse\DOMManager\Handlers\DomNode\XPathHandler;
use cse\DOMManager\Nodes\Nodes;
use DOMNode;
use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Class BaseTestCase
 */
class BaseTestCase extends TestCase
{
    protected const FILE_EXAMPLE_2 = 'example-2.html';
    protected const FILE_EXAMPLE_3 = 'example-3.html';
    protected const FILE_ITEM = 'example-4.html';

    /** @var DomManager $domManager */
    protected $domManager;

    /** @var XPathHandler $xPath */
    protected $xPath;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->domManager = new DomManager();
        $this->xPath = new XPathHandler();
    }

    /**
     * @param string $file_name
     *
     * @return string
     */
    protected function getFileContent(string $file_name = self::FILE_EXAMPLE_3): string
    {
        return file_get_contents($this->pathResource() . DIRECTORY_SEPARATOR . $file_name);
    }

    /**
     * @param string $file_name
     *
     * @return \DOMDocument
     */
    protected function getDocumentByFileName(string $file_name = self::FILE_EXAMPLE_3): \DOMDocument
    {
        $domDocument = new \DOMDocument('1.0', 'UTF-8');
        $domDocument->loadXML($this->getFileContent($file_name));

        return $domDocument;
    }

    /**
     * @param string $filter
     * @param string $file_name
     *
     * @return DOMNode|\DOMNodeList
     */
    protected function getDomNodeByElem(string $filter, string $file_name = self::FILE_EXAMPLE_3)
    {
        $document = $this->getDocumentByFileName($file_name);
        $domNode = $document->getElementsByTagName($filter);
        if ($domNode->count() === 0) {
            $domNode = $this->xPath->filter($filter, $document->documentElement);
        }
        return $domNode;
    }

    /**
     * @param string $file_name
     *
     * @return INodeListInstance
     */
    protected function getNodeListByFile(string $file_name = self::FILE_EXAMPLE_3): INodeListInstance
    {
        return $this->domManager->create($this->getFileContent($file_name))->toList();
    }

    /**
     * @param string $filter
     * @param string $file_name
     *
     * @return INodeListInstance
     */
    protected function getNodeListDocumentByElem(string $filter, string $file_name = self::FILE_EXAMPLE_3): INodeListInstance
    {
        return $this->domManager->create($this->getDomNodeByElem($filter, $file_name))->toList();
    }

    /**
     * @return string
     */
    protected function pathResource(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'Resources';
    }

    /**
     * @param Nodes|null $nodes
     * @param array|null $equals
     *
     * @return void
     *
     * @throws Exception
     */
    protected function assertEqualsNodesContent(?Nodes $nodes, ?array $equals): void
    {
        if (is_null($equals)) {
            $equals = [$this->domManager->create()];
        }

        if ($nodes->notExist()) {
            $this->checkNodes($equals);
            $this->assertTrue(empty($equals));
            return;
        }

        $nodes->each(function (Nodes $node) use (&$equals) {
            if ($node->exist()) {
                $this->checkContent($node, $equals);
            } else {
                $this->checkNodes($equals);
            }
        });

        $this->assertTrue(empty($equals));
    }

    /**
     * @param INodeListInstance $nodeList
     * @param array|null $equals
     *
     * @return void
     *
     * @throws Exception
     */
    protected function assertEqualsNodeListContent(INodeListInstance $nodeList, ?array $equals): void
    {
        if (empty($equals)) {
            $this->assertTrue($nodeList->isEmpty());
            return;
        }
        $this->assertEqualsNodesContent($this->domManager->create($nodeList), $equals);
    }

    /**
     * @param array|null $dom_node_array
     * @param array|null $equals
     *
     * @return void
     *
     * @throws Exception
     */
    protected function assertEqualsArrayDomNodeContent(?array $dom_node_array, ?array $equals): void
    {
        if (empty($equals)) {
            $this->assertTrue(empty($dom_node_array));
            return;
        }
        $this->assertEqualsNodesContent($this->domManager->create($dom_node_array), $equals);
    }

    /**
     * @param INodeListInstance $nodeList
     * @param array|null $equals
     *
     * @return void
     *
     * @throws Exception
     */
    protected function assertEqualsTagsNodeList(INodeListInstance $nodeList, ?array $equals): void
    {
        if (empty($equals)) {
            $this->assertTrue($nodeList->isEmpty());
            return;
        }

        $this->assertTagsDomNodes($nodeList->all(), $equals);
    }

    /**
     * @param DOMNode[]|null $nodes
     * @param string[]|null $equals
     *
     * @return void
     */
    protected function assertTagsDomNodes(?array $nodes, ?array $equals): void
    {
        if (is_null($equals)) {
            $this->assertNull($nodes);
            return;
        }

        foreach ($nodes as $node) {
            $result = false;
            foreach ($equals as $key => $equal) {
                if ($equal == $node->nodeName) {
                    $result = true;
                    unset($equals[$key]);
                    break;
                }
            }

            $this->assertTrue($result);
        }

        $this->assertTrue(empty($equals));
    }

    /**
     * @param array|null $list
     * @param array|null $equals
     *
     * @return void
     */
    protected function assertArray(?array $list, ?array $equals): void
    {
        if (is_null($equals)) {
            $this->assertNull($list);
            return;
        }

        foreach ($list as $item) {
            $result = false;
            foreach ($equals as $key => $equal) {
                if ($equal == $item) {
                    $result = true;
                    unset($equals[$key]);
                    break;
                }
            }

            $this->assertTrue($result);
        }

        $this->assertTrue(empty($equals));
    }

    /**
     * @param Nodes $node
     * @param array $equals
     *
     * @return void
     *
     * @throws Exception
     */
    protected function checkContent(Nodes $node, array &$equals): void
    {
        $continue = false;
        try {
            $content = $node->toString();
        } catch (Exception $e) {
            if ($e->getMessage() == "Couldn't fetch DOMElement. Node no longer exists") {
                $continue = true;
            } else {
                throw $e;
            }
        }

        if (!$continue) {
            $result = false;
            foreach ($equals as $key => $equal) {
                if ($equal == $content) {
                    $result = true;
                    unset($equals[$key]);
                    break;
                }
            }

            $this->assertTrue($result);
        }
    }

    /**
     * @param array $equals
     *
     * @return void
     */
    protected function checkNodes(array &$equals): void
    {
        $result = false;
        foreach ($equals as $key => $equal) {
            if ($equal instanceof Nodes) {
                $result = true;
                $this->assertTrue($equal->notExist());
                unset($equals[$key]);
                break;
            }
        }

        $this->assertTrue($result);
    }
}
