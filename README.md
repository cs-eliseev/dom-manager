English | [Русский](https://github.com/cs-eliseev/dom-manager/blob/master/README.ru_RU.md)

DOM Manager
=======

A simple library for management the DOM (XML, HTML) document.

Project repository: https://github.com/cs-eliseev/dom-manager

**DEMO**

```php
use cse\DOMManager\DomManager;
...
$content = file_get_contents('https://www.w3schools.com/xml/simple.xml');
$easyLoader = new DomManager();
$node = $easyLoader->parse($content);
$name = $node->find('name')->first()->text(); // Belgian Waffles
```

***


## Install

You can find the most recent version of this project [here](https://github.com/cs-eliseev/dom-manager).

### Composer

Execute the following command to get the latest version of the package:
```bash
composer require cse/dom-manager
```

Or file composer.json should include the following contents:
```json
{
    "require": {
        "cse/dom-manager": "*"
    }
}
```

### Git

Clone this repository locally:
```bash
git clone https://github.com/cs-eliseev/dom-manager.git
```

### Download

[Download the latest release here](https://github.com/cs-eliseev/dom-manager/archive/master.zip).

## Usage

The following demonstrates how to use the functions of this library in a PHP application.

### Init

The DomManager instance convert data into a structure for manipulating the DOM tree.

Converting XML structure:

```php
use cse\DOMManager\IDomManager;
...
$easyLoader = new IDomManager();
$nodes = $easyLoader->parse('<div><br/><br/></div>'); // Nodes entity
```

Converting HTML structure via DOMDocument:

```php
use cse\DOMManager\DomManager;
...
$domDocument = new DOMDocument('1.0', 'UTF-8');
$domDocument->loadHTML('<div><br><br></div>');
$easyLoader = new DomManager();
$nodes = $easyLoader->parse($domDocument); // Nodes entity
```

Converting DOMNodeList:

```php
use cse\DOMManager\DomManager;
...
$domDocument = new DOMDocument('1.0', 'UTF-8');
$domDocument->loadXML('<div><br/><br/></div>');

$easyLoader = new DomManager();
$nodes = $easyLoader->parse($domDocument->getElementsByTagName('br')); // Nodes entity
```

Converting DOMNode:

```php
use cse\DOMManager\DomManager;
...
$domDocument = new DOMDocument('1.0', 'UTF-8');
$domDocument->loadXML('<div><br/><br/></div>');

$easyLoader = new DomManager();
$nodes = $easyLoader->parse($domDocument->getElementsByTagName('br')->item(1)); // Nodes entity
```

An instance of the `Nodes` represents a list of DOMNode objects, can be manipulation.

### Methods
|#|Method|Parameters|Return values|Description|
|:---|:---|:---:|:---|:---|
| | Navigation methods
|[#](#find)|find($node_name)|$node_name - search parameter|Nodes|Returns all found node elements|
|[#](#first)|first($node_name)|$node_name - search parameter (optional)|Nodes|Returns the first found node element|
|[#](#last)|last($node_name)|$node_name - search parameter (optional)|Nodes|Returns the last found node element|
|[#](#getByPosition)|getByPosition($position, $node_name)|$position - number index, $node_name - search parameter (optional)|Nodes|Returns the element by index|
|[#](#closest)|closest($node_name)|$node_name - parent element search parameter (optional)|Nodes|Returns the closest parent element|
|[#](#parent)|parent()| |Nodes|Returns the parent element|
|[#](#root)|root()| |Nodes|Returns the root element|
|[#](#childes)|childes($node_name)|$node_name - search parameter (optional)|Nodes|Returns all children of the node|
|[#](#firstChild)|firstChild($node_name)|$node_name - search parameter (optional)|Nodes|Returns the first child of the node|
|[#](#getNodeByPosition)|getNodeByPosition($position)|$position - number index|DOMNode|Returns the DOMNode element by index|
|[#](#findNodeByPosition)|findNodeByPosition($position, $node_name)|$position - number index, $node_name - search parameter|Nodes|Returns the found DOMNode element by index|
| |  Node management methods
|[#](#name)|name()| |string|Returns node name|
|[#](#rename)|rename($new_node_name, $old_node_name)|$new_node_name - new node name, $old_node_name - search parameter (optional)|Nodes|Rename node|
|[#](#replace)|replace($content, $node_name)|$content - replacement data, $node_name - search parameter (optional)|Nodes|Replace node|
|[#](#remove)|remove($node_name)|$node_name - search parameter (optional)|Nodes|Remove node|
| |  Node information
|[#](#count)|count($node_name)|$node_name - search parameter (optional)|int|Counting the number of elements|
|[#](#exist)|exist($node_name)|$node_name - search parameter (optional)|bool|Checking for node existence|
|[#](#notExist)|notExist($node_name)|$node_name - search parameter (optional)|bool|Checking for node not existence|
|[#](#isElem)|isElem()| |bool|Checking that the number of elements is 1|
|[#](#isList)|isList()| |bool|Checks that the number of elements is more than 1|
|[#](#isDomComment)|isDomComment()| |bool|Validation DOMComment|
|[#](#isDomElement)|isDomElement()| |bool|Validation DOMElement|
|[#](#isDomText)|isDomText()| |bool|Validation DOMText|
|[#](#type)|type()| |string|Return type|
| |  Methods for management text
|[#](#text)|text()| |string|Returns text|
|[#](#addText)|addText($text)|$text - adding text|Nodes|Adds text to the end of a node|
|[#](#replaceText)|replaceText($text)|$text - replace text|Nodes|Replacing text in a node|
|[#](#removeText)|removeText()| |Nodes|Remove text in a node|
| |  Methods for management attributes
|[#](#attr)|attr($attribute, $default)|$attribute - attribute name, $default - default value (optional)|string|Return attribute value|
|[#](#hasAttr)|hasAttr($attribute)|$attribute - attribute name|bool|Checking if an attribute exists|
|[#](#setAttr)|setAttr($attribute, $value)|$attribute - attribute name, $value - value to insert|Nodes|Set attribute value|
|[#](#removeAttr)|removeAttr($attribute)|$attribute - attribute name|Nodes|Remove attribute|
| |  Methods for management childes
|[#](#appendChild)|appendChild($content, $node_name)|$content - replace data, $node_name - search parameter (optional)|Nodes|Adding child node|
|[#](#replaceChildes)|replaceChildes($content, $node_name)|$content - replacement data, $node_name - search parameter (optional)|Nodes|Replace childes node|
|[#](#removeChildes)|removeChildes($node_name)|$node_name - search parameter (optional)|Nodes|Remove childes node|
| |  Transform methods
|[#](#toArray)|toArray()| |DOMNode[]|Returns a list of DOMNode elements|
|[#](#toList)|toList()| |NodeList|Return NodeList|
|[#](#toString)|toString($node_name)|$node_name - search parameter (optional)|string|Returns the markup of an element, including its content.|
| |  List iteration methods
|[#](#each)|each(function ($elem) {})| | |Calls a callback function for each item|

### Example

Example of document content:
```HTML
<main class="main" role="main">
    <div class="content">
        <div>
            <h1><i class="icon"/><span>Header</span>-subheader</h1>
            <img src="content_img.jpg" alt="content img"/>
            <p><span class="text">First text</span></p>
        </div>
        <br/>
        <p>Last text</p>
    </div>
    <div class="description" role="contentinfo">
        <p>First description</p>
        <br/>
        <em>Middle description</em>
        <p><span>Last description</span></p>
    </div>
</main>
```

### <a name="find"></a> Find elements

Returns all found node elements.

Search by tag name:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div');
```

Result:
```html
<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>
<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>
<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>
```

Find by XPath:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('//div/div');
```

Result:
```html
<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>
```

Find by attributes:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('//*[@class="content"]');
```

Result:
```html
<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>
```

### <a name="first"></a> First element

Returns the first found node element.

The first item in the list:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->first();
```

Result:
```html
<p><span class="text">First text</span></p>
```

First found elements in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->first('p');
```

Result:
```html
<p><span class="text">First text</span></p>
```

First found elements in a node by XPath:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->first('//span[@class]');
```

Result:
```html
<span class="text">First text</span>
```

First found elements in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->first('p');
```

Result:
```html
<p><span class="text">First text</span></p>
<p><span class="text">First text</span></p>
<p>First description</p>
```

### <a name="last"></a> Last elements

Returns the last found node element.

The last item in the list:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->last();
```

Result:
```html
<p><span>Last description</span></p>
```

Last found elements in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->last('p');
```

Result:
```html
<p><span>Last description</span></p>
```

Last found elements in a node by XPath:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->last('//span[@class]');
```

Result:
```html
<span class="text">First text</span>
```

Last found elements in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->last('p');
```

Result:
```html
<p>Last text</p>
<p><span class="text">First text</span></p>
<p><span>Last description</span></p>
```

### <a name="getByPosition"></a> N element

Returns the element by index.

N list item:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->getByPosition(1);
```

Result:
```html
<p>Last text</p>
```

N found elements in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->getByPosition(1, 'p');
```

Result:
```html
<p>Last text</p>
```

N found elements in a node by XPath:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->getByPosition(2, '//*[@class]');
```

Result:
```html
<i class="icon"/>
```

N found elements in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->getByPosition(1, 'p');
```

Result:
```html
<p>Last text</p>
<p><span>Last description</span></p>
```

### <a name="closest"></a> Closest

Returns the closest parent element.

Closest parent element by tag name:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('span')->closest('div');
```

Result:
```html
<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>
<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>
<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>
```

Parent element:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('span')->closest();
```

Result:
```html
<h1><i class="icon"/><span>Header</span>-subheader</h1>
<p><span class="text">First text</span></p>
<p><span>Last description</span></p>
```

### <a name="parent"></a> Parent

Returns the parent element.

Parent element:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('span')->parent();
```

Result:
```html
<h1><i class="icon"/><span>Header</span>-subheader</h1>
<p><span class="text">First text</span></p>
<p><span>Last description</span></p>
```

### <a name="root"></a> Root

Returns the root element.

Main parent:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('span')->root();
```

Result:
```html
<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>
```

### <a name="childes"></a> Childes

Returns all children of the node.

Get the childes in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->childes();
```

Result:
```html
<span class="text">First text</span>
<span>Last description</span>
```

Find the childes in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->childes('p');
```

Result:
```html
<span class="text">First text</span>
<span>Last description</span>
```

Find by XPath:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->childes('//*[@class="description"]/p');
```

Result:
```xml
<span>Last description</span>
```

### <a name="firstChild"></a> First childes

Returns the first child of the node.

Get the first childes in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->firstChild();
```

Result:
```html
<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>
<h1><i class="icon"/><span>Header</span>-subheader</h1>
<p>First description</p>
```

Find the childes in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->firstChild();
```

Result:
```html
<span class="text">First text</span>
<span>Last description</span>
```

Find the childes in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->firstChild('div');
```

Result:
```html
<span class="text">First text</span>
<span>Last description</span>
```

Find the childes in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->firstChild('p');
```

Result:
```html
<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>
<h1><i class="icon"/><span>Header</span>-subheader</h1>
<p>First description</p>
```

Find by XPath:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->firstChild('//div/div');
```

Result:
```html
<h1><i class="icon"/><span>Header</span>-subheader</h1>
```

### <a name="getNodeByPosition"></a> Get DOMNode

Returns the DOMNode element by index.

Get an element by index:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->getNodeByPosition(1);
```

Result:
```php
class DOMElement {}
```

### <a name="findNodeByPosition"></a> Find DOMNode

Returns the found DOMNode element by index.

Find element:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->findNodeByPosition(1, 'p');
```

Result:
```php
class DOMElement {}
```

### <a name="name"></a> Node name

Returns node name.

Node name:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->name();
```

Result:
```text
div
div
div
```

### <a name="rename"></a> Rename node

Rename node.

Rename current node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->rename('section');
```

Result:
```html
<section class="content"><section><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></section><br/><p>Last text</p></section>
<section><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></section>
<section class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></section>
```

Find and rename a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->rename('section', 'div');
```

```html
<div class="content"><div><h1><i class="icon"/><strong>Header</strong>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><strong class="text">First text</strong></p></div><br/><p>Last text</p></div>
<div><h1><i class="icon"/><strong>Header</strong>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><strong class="text">First text</strong></p></div>
<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><strong>Last description</strong></p></div>
```

### <a name="replace"></a> Replace node

Replace node.

Replace current node.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->replace('<section><div>Header</div>Content</section>');
```

```html
<main class="main" role="main"><section><div>Header</div>Content</section><section><div>Header</div>Content</section></main>
```

Finde nad replace a node.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->replace('<section><div>Header</div>Content</section>', 'div');
```

Result:
```html
<main class="main" role="main"><section><div>Header</div>Content</section><section><div>Header</div>Content</section></main>
```

Find by XPath and replace node.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->replace('<section><div>Header</div>Content</section>', '//div/div');
```

Result:
```html
<main class="main" role="main"><div class="content"><section><div>Header</div>Content</section><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>
```

### <a name="remove"></a> Remove node

Remove node.

Remove current node.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->remove();
```

Result:
```html
<main class="main" role="main"/>
```

Find and remove a node.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->remove('div');
```

Result:
```html
<main class="main" role="main"/>
```

Find by XPath and remove node.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->remove('//div/div');
```

Result:
```html
<main class="main" role="main"><div class="content"><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>
```

### <a name="count"></a> Count

Counting the number of elements.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->count();     // 4
$nodes->count('p');             // 4
$nodes->count('//*[@class]');   // 5
```

### <a name="exist"></a> Element exist

Checking for node existence.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->exist();     // true
$nodes->exist('p');             // true
$nodes->exist('//*[@class]');   // true
$nodes->exist('hr');            // false
```

### <a name="notExist"></a> Element not exist

Checking for node not existence.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->notExist();      // false
$nodes->notExist('p');              // false
$nodes->notExist('//*[@class]');    // false
$nodes->notExist('hr');             // true
```

### <a name="isElem"></a> Is element

Checking that the number of elements is 1.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->isElem();  // true
$nodes->find('p')->isElem();    // false
```

### <a name="isList"></a> Is list

Checks that the number of elements is more than 1.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->isList();  // false
$nodes->find('p')->isList();    // true
```

### <a name="isDomComment"></a> DomComment

Validate DOMComment. Use isElem. Parsing by default ignore the node DOMComment.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->isDomComment();  // false
$nodes->find('p')->isDomComment();    // false
```

### <a name="isDomElement"></a> DomElement

Validate DomElement. Use isElem.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->isDomElement();        // true
$nodes->find('p')->isDomElement();          // false
$nodes->find('p')->first()->isDomElement(); // true
```

### <a name="isDomText"></a> DomText

Validate DomText. Use isElem. Parsing by default ignore the node DomText.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->isDomText();  // false
$nodes->find('p')->isDomText();    // false
```

### <a name="type"></a> Node type

Node type. Parsing by default ignore the node type not 1.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->type();  // 1
$nodes->find('p')->type();    // 1\n1\n1\n1
```

### <a name="text"></a> Text

Returns text.

Get the text of the current item:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('//h1/span')->text();              // Header
$nodes->find('h1')->text();                     // Header-subheader
$nodes->find('//*[@class="content"]')->text();  // Header-subheaderFirst textLast text
```

Get the text of the list:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->text();
```

Result:
```text
First text
Last text
First description
Last description
```

### <a name="addText"></a> Add text

Adds text to the end of a node.

Adding text to an empty element:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('//h1/i')->addText('add text');
```

Result:
```html
<i class="icon">add text</i>
```

Adding text to the end of an element:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->addText('add text');
```

Result:
```html
<h1><i class="icon"/><span>Header</span>-subheaderadd text</h1>
```

Adding text to the list:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->addText('add text');
```

Result:
```html
<p><span class="text">First text</span>add text</p>
<p>Last textadd text</p>
<p>First descriptionadd text</p>
<p><span>Last description</span>add text</p>
```

### <a name="replaceText"></a> Replace text

Replace text in a node.

Adding text to an empty element:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('//h1/i')->replaceText('change text');
```

Result:
```html
<i class="icon">add text</i>
```

Replace text in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->replaceText('change text');
```

Result:
```html
<h1><i class="icon"/><span>Header</span>change text</h1>
```

Replace text to the list:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->replaceText('change text');
```

Result:
```html
<p><span class="text">First text</span>change text</p>
<p>change text</p>
<p>change text</p>
<p><span>Last description</span>change text</p>
```

### <a name="removeText"></a> Remove text

Remove text in a node.

Remove text in a node:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->removeText();
```

Result:
```html
<h1><i class="icon"/><span>Header</span></h1>
```

Remove text to the list:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->replaceText('change text');
```

Result:
```html
<p><span class="text">First text</span></p>
<p></p>
<p></p>
<p><span>Last description</span></p>
```

### <a name="attr"></a> Attribute

Return attribute value.

Get list values:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->attr('class');
```

Result:
```text
content
description
```

Get value:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->attr('role');
```

Result:
```text
contentinfo
```

Default value:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->attr('role', 'default');
```

Result:
```text
default
default
contentinfo
```

### <a name="hasAttr"></a> Has attribute

Checking if an attribute exists.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->hasAttr('src');        // true
$nodes->find('i')->hasAttr('class');        // true
$nodes->find('p')->hasAttr('class');        // false
$nodes->find('div')->hasAttr('class');      // false
```

### <a name="setAttr"></a> Set attribute

Set attribute value.

Set attribute to the element:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$elem = $nodes->find('i');
$elem->setAttr('class', 'value');               // <i class="value"/>
$elem->setAttr('data-value', 'edit');           // <i class="value" data-value="edit"/>
$elem->setAttr('class', 'icon value');          // <i class="icon value" data-value="edit"/>
```

Set attribute to the list:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$elem = $nodes->find('p')->setAttr('class', 'text');
```

Result:
```html
<p class="text"><span class="text">First text</span></p>
<p class="text">Last text</p>
<p class="text">First description</p>
<p class="text"><span>Last description</span></p>
```

### <a name="removeAttr"></a> Remove attribute

Remove attribute.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$elem = $nodes->find('span')->removeAttr('class');
```

Result:
```html
<span>Header</span>
<span>First text</span>
<span>Last description</span>
```

### <a name="appendChild"></a> Append child

Adding child node.

Adding to an empty element:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('i')->appendChild('<section><div>Header</div>Content</section>');
```

Result:
```html
<i class="icon"><section><div>Header</div>Content</section></i>
```

Adding to the list:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->appendChild('<section><div>Header</div>Content</section>');
```

Result:
```html
<p><span class="text">First text</span><section><div>Header</div>Content</section></p>
<p>Last text<section><div>Header</div>Content</section></p>
<p>First description<section><div>Header</div>Content</section></p>
<p><span>Last description</span><section><div>Header</div>Content</section></p>
```

Find and add:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->appendChild('<section><div>Header</div>Content</section>', 'p');
```

Result:
```html
<p><span class="text">First text</span><section><div>Header</div>Content</section></p>
<p>Last text<section><div>Header</div>Content</section></p>
<p>First description<section><div>Header</div>Content</section></p>
<p><span>Last description</span><section><div>Header</div>Content</section></p>
```

### <a name="replaceChildes"></a> Replace childes

Replace childes node.

Replacing all childes:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->replaceChildes('<section><div>Header</div>Content</section>');
```

Result:
```html
<h1><section><div>Header</div>Content</section><section><div>Header</div>Content</section>-subheader</h1>
```

Replacing children by node name:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->replaceChildes('<section><div>Header</div>Content</section>', 'i');
```

Result:
```html
<h1><section><div>Header</div>Content</section><span>Header</span>-subheader</h1>
```

### <a name="removeChildes"></a> Remove chides

Remove childes node.

Removing all childes:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->removeChildes();
```

Result:
```html
<h1>-subheader</h1>
```

Removing descendants by node name:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->removeChildes('i');
```

Result:
```html
<h1><span>Header</span>-subheader</h1>
```

### <a name="toArray"></a> DOMNode list

Returns a list of DOMNode elements.

List:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->toArray();
```

Result:
```php
[
    class DOMElement {},
    class DOMElement {},
    class DOMElement {},
    class DOMElement {}
]
```

### <a name="toList"></a> NodeList

Return NodeList.

NodeList:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->toList();
```

Result:
```php
class NodeList {}
```

### <a name="toString"></a> Content

Returns the markup of an element, including its content.

Get the content of the current element:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->toString();
```

Result:
```html
<h1><i class="icon"/><span>Header</span>-subheader</h1>
```

Find and get the content of the element:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->toString('h1');
```

Result:
```html
<h1><i class="icon"/><span>Header</span>-subheader</h1>
```

Find by XPath and get the content of the element:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->toString('//div/p');
```

Result:
```html
<p><span class="text">First text</span></p>
<p>Last text</p>
<p>First description</p>
<p><span>Last description</span></p>a
```

### <a name="each"></a> Foreach elements

Calls a callback function for each item.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$elem = $nodes->find('div');
$elem->each(function (\cse\DOMManager\Nodes\Nodes $item) {
    if ($item->hasAttr('class')) {
        $item->removeAttr('class');
    }
    $item->addText('this div element');
});
echo $elem->root()->content();
```

Result:
```html
<main class="main" role="main"><div><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p>this div element</div><br/><p>Last text</p>this div element</div><div role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p>this div element</div></main>
```


## Testing & Code Coverage

PHPUnit is used for unit testing. Unit tests ensure that class and methods does exactly what it is meant to do.

General PHPUnit documentation can be found at https://phpunit.de/documentation.html.

To run the PHPUnit unit tests, execute:
```bash
phpunit PATH/TO/PROJECT/tests/
```

If you want code coverage reports, use the following:
```bash
phpunit --coverage-html ./report PATH/TO/PROJECT/tests/
```

Used PHPUnit default config:
```bash
phpunit --configuration PATH/TO/PROJECT/phpunit.xml
```


## Support project

Many thanks to those who are ready to help in the development of the project. You can help:
* Add a bug report or suggestion for improvement.
* Share code improvements by sending a Pull Request.
* Make a translation or optimize it for your country.
* Modify the documentation.
* Also any other help.


## License

This PHP library is open-source under the MIT license. Please see [License File](https://github.com/cs-eliseev/dom-manager/blob/master/LICENSE.md) for more information.

***

> GitHub [@cs-eliseev](https://github.com/cs-eliseev)