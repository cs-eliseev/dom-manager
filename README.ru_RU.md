[English](https://github.com/cs-eliseev/dom-manager/blob/master/README.md) | Русский

DOM Manager
=======

Простая библиотека для управления DOM (XML, HTML) документом.

Репозиторий проекта: https://github.com/cs-eliseev/dom-manager

**DEMO**

```php
use cse\DOMManager\DomManager;
...
$content = file_get_contents('https://www.w3schools.com/xml/simple.xml');
$easyLoader = new DomManager();
$nodes = $easyLoader->parse($content);
$name = $nodes->find('name')->first()->text(); // Belgian Waffles
```

***


## Установка

Самая последняя версия проекта доступна [здесь](https://github.com/cs-eliseev/dom-manager).

### Composer

Чтобы установить последнюю версию проекта, выполните следующую команду в терминале:
```shell
composer require cse/dom-manager
```

Или добавьте следующее содержимое в файл composer.json:
```json
{
    "require": {
        "cse/dom-manager": "*"
    }
}
```

### Git

Добавить этот репозиторий локально можно следующим образом:
```shell
git clone https://github.com/cs-eliseev/dom-manager.git
```

### Скачать

[Скачать последнюю версию проекта можно здесь](https://github.com/cs-eliseev/dom-manager/archive/master.zip).

## Использование

Ниже продемонстрированно, как использовать функции данной библиотеки в PHP приложении.

### Инициализация

Объект DomManager преобразовывает данные в структуру для управления DOM деревом.

Преобразование XML структуры:

```php
use cse\DOMManager\DomManager;
...
$easyLoader = new DomManager();
$nodes = $easyLoader->parse('<div><br/></div>'); // Nodes entity
```

Преобразование HTML структуры, через DOMDocument:

```php
use cse\DOMManager\DomManager;
...
$domDocument = new DOMDocument('1.0', 'UTF-8');
$domDocument->loadHTML('<div><br></div>');
$easyLoader = new DomManager();
$nodes = $easyLoader->parse($domDocument); // Nodes entity
```

Преобразование DOMNodeList:

```php
use cse\DOMManager\DomManager;
...
$domDocument = new DOMDocument('1.0', 'UTF-8');
$domDocument->loadXML('<div><br/><br/></div>');

$easyLoader = new DomManager();
$nodes = $easyLoader->parse($domDocument->getElementsByTagName('br')); // Nodes entity
```

Преобразование DOMNode:

```php
use cse\DOMManager\DomManager;
...
$domDocument = new DOMDocument('1.0', 'UTF-8');
$domDocument->loadXML('<div><br/><br/></div>');

$easyLoader = new DomManager();
$nodes = $easyLoader->parse($domDocument->getElementsByTagName('br')->item(1)); // Nodes entity
```

Экземпляр класса Nodes представляет собой набор DOMNode объектов, которыми можно управлять.

### Методы
|#|Метод|Параметры|Возвращаемое значение|Описание|
|:---|:---|:---:|:---|:---|
| | Методы навигации по элементам
|[#](#find)|find($node_name)|$node_name - параметр поиска|Nodes|Возвращает все найденные элементы узла|
|[#](#first)|first($node_name)|$node_name - параметр поиска (необязательный)|Nodes|Возвращает первый найденный элемент узла|
|[#](#last)|last($node_name)|$node_name - параметр поиска (необязательный)|Nodes|Возвращает последний найденный элемент узла|
|[#](#getByPosition)|getByPosition($position, $node_name)|$position - индекс элемента в списке, $node_name - параметр поиска (необязательный)|Nodes|Возвращает элемент по индексу|
|[#](#closest)|closest($node_name)|$node_name - параметр поиска родительского элумента (необязательный)|Nodes|Возвращает ближайший родительский элемент|
|[#](#parent)|parent()| |Nodes|Возвращает родительский элемент|
|[#](#root)|root()| |Nodes|Возвращает корневой элемент|
|[#](#childes)|childes($node_name)|$node_name - параметр поиска (необязательный)|Nodes|Возвращает все дочерние элементы узла|
|[#](#firstChild)|firstChild($node_name)|$node_name - параметр поиска (необязательный)|Nodes|Возвращает первый дочерний элемент узла|
|[#](#getNodeByPosition)|getNodeByPosition($position)|$position - индекс элемента в списке|DOMNode|Возвращает DOMNode элемент по индексу|
|[#](#findNodeByPosition)|findNodeByPosition($position, $node_name)|$position - индекс элемента в списке, $node_name - параметр поиска|DOMNode|Возвращает найденный DOMNode элемент по индексу|
| | Методы работы с узлом
|[#](#name)|name()| |string|Возвращает имя узла|
|[#](#rename)|rename($new_node_name, $old_node_name)|$new_node_name - новое имя узла, $old_node_name - параметр поиска (необязательный)|Nodes|Переименование узла|
|[#](#replace)|replace($content, $node_name)|$content - данные для замены, $node_name - параметр поиска (необязательный)|Nodes|Замена узла|
|[#](#remove)|remove($node_name)|$node_name - параметр поиска (необязательный)|Nodes|Удаление узла|
| | Информация о узле
|[#](#count)|count($node_name)|$node_name - параметр поиска (необязательный)|int|Подсчет количества элементов|
|[#](#exist)|exist($node_name)|$node_name - параметр поиска (необязательный)|bool|Проверка существования узла|
|[#](#notExist)|notExist($node_name)|$node_name - параметр поиска (необязательный)|bool|Проверка отсутствия узла|
|[#](#isElem)|isElem()| |bool|Проверка что количестов элементов равно 1|
|[#](#isList)|isList()| |bool|Проверяет что количество элементов более 1|
|[#](#isDomComment)|isDomComment()| |bool|Проверка что элемент является DOMComment|
|[#](#isDomElement)|isDomElement()| |bool|Проверка что элемент является DOMElement|
|[#](#isDomText)|isDomText()| |bool|Проверка что элемент является DOMText|
|[#](#type)|type()| |string|Возвращает тип узла|
| | Методы работы с текстом
|[#](#text)|text()| |string|Возвращает текст|
|[#](#addText)|addText($text)|$text - текст для вставки|Nodes|Добавляет текст в конец узла|
|[#](#replaceText)|replaceText($text)|$text - текст для замены|Nodes|Замена текста в узле|
|[#](#removeText)|removeText()| |Nodes|Удаление текста в узле|
| | Методы работы с атрибутами
|[#](#attr)|attr($attribute, $default)|$attribute - имя атрибута, $default - значение по умолчанию (необязательный)|string|Возвращает значение атирбута|
|[#](#hasAttr)|hasAttr($attribute)|$attribute - имя атрибута|bool|Проверка наличия атрибута|
|[#](#setAttr)|setAttr($attribute, $value)|$attribute - имя атрибута, $value - подставляемое значение|Nodes|Установка значения атрибута|
|[#](#removeAttr)|removeAttr($attribute)|$attribute - имя атрибута|Nodes|Удаление атрибута|
| | Методы работы с потомками
|[#](#appendChild)|appendChild($content, $node_name)|$content - данные для добавления, $node_name - параметр поиска (необязательный)|Nodes|Добавление нового дочернего элемента|
|[#](#replaceChildes)|replaceChildes($content, $node_name)|$content - данные для замены, $node_name - параметр поиска (необязательный)|Nodes|Замена потомков|
|[#](#removeChildes)|removeChildes($node_name)|$node_name - параметр поиска (необязательный)|Nodes|Удаление дачерних элементов|
| | Методы преобразования
|[#](#toArray)|toArray()| |DOMNode[]|Возвращает список DOMNode элементов|
|[#](#toList)|toList()| |NodeList|Возвращает NodeList|
|[#](#toString)|toString($node_name)|$node_name - параметр поиска (необязательный)|string|Возвращает разметку элемента, включая его контент|
| | Методы перебора списка
|[#](#each)|each(function ($elem) {})| | |Вызывает callback функцию для каждого элемента|

### Примеры

Пример содержимого документа:
```html
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

### <a name="find"></a> Поиск элементов

Возвращает все найденные элементы узла.

Поиск по имени тега:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div');
```

Результат:
```html
<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>
<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>
<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>
```

Поиск через XPath:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('//div/div');
```

Результат:
```html
<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>
```

Поиска по атрибуту:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('//*[@class="content"]');
```

Результат:
```html
<div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div>
```

### <a name="first"></a> Первый элемент

Возвращает первый найденный элемент узла.

Первый элемент списка:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->first();
```

Результат:
```html
<p><span class="text">First text</span></p>
```

Первый найденный элемент:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->first('p');
```

Результат:
```html
<p><span class="text">First text</span></p>
```

Первый найденный элемент через XPath:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->first('//span[@class]');
```

Результат:
```html
<span class="text">First text</span>
```

Первый элемент в узле:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->first('p');
```

Результат:
```html
<p><span class="text">First text</span></p>
<p><span class="text">First text</span></p>
<p>First description</p>
```

### <a name="last"></a> Последний элемент

Возвращает последний найденный элемент узла.

Последний элемент списка:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->last();
```

Результат:
```html
<p><span>Last description</span></p>
```

Последний найденный элемент:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->last('p');
```

Результат:
```html
<p><span>Last description</span></p>
```

Последний найденный элемент через XPath:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->last('//span[@class]');
```

Результат:
```html
<span class="text">First text</span>
```

Последний элемент в узле:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->last('p');
```

Результат:
```html
<p>Last text</p>
<p><span class="text">First text</span></p>
<p><span>Last description</span></p>
```

### <a name="getByPosition"></a> N элемент

Возвращает элемент по индексу.

N элемент списка:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->getByPosition(1);
```

Результат:
```html
<p>Last text</p>
```

N найденный элемент:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->getByPosition(1, 'p');
```

Результат:
```html
<p>Last text</p>
```

N найденный элемент через XPath:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->getByPosition(2, '//*[@class]');
```

Результат:
```html
<i class="icon"/>
```

N элемент в узле:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->getByPosition(1, 'p');
```

Результат:
```html
<p>Last text</p>
<p><span>Last description</span></p>
```

### <a name="closest"></a> Ближайший подходящий предок

Возвращает ближайший родительский элемент.

Ближайший родительский элемент по имени тега:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('span')->closest('div');
```

Результат:
```html
<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>
<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>
<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div>
```

Ближайший родительский элемент:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('span')->closest();
```

Результат:
```html
<h1><i class="icon"/><span>Header</span>-subheader</h1>
<p><span class="text">First text</span></p>
<p><span>Last description</span></p>
```

### <a name="parent"></a> Родитель

Возвращает родительский элемент.

Ближайший родительский элемент:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('span')->parent();
```

Результат:
```html
<h1><i class="icon"/><span>Header</span>-subheader</h1>
<p><span class="text">First text</span></p>
<p><span>Last description</span></p>
```

### <a name="root"></a> Корень документа

Возвращает корневой элемент.

Корневой элемент:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('span')->root();
```

Результат:
```html
<main class="main" role="main"><div class="content"><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>
```

### <a name="childes"></a> Потомки

Возвращает все дочерние элементы узла.

Список потомков:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->childes();
```

Результат:
```html
<span class="text">First text</span>
<span>Last description</span>
```

Поиск потомков:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->childes('p');
```

Результат:
```html
<span class="text">First text</span>
<span>Last description</span>
```

Поиск через xPath:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->childes('//*[@class="description"]/p');
```

Результат:
```xml
<span>Last description</span>
```

### <a name="firstChild"></a> Первый потомок

Возвращает первый дочерний элемент узла.

Первый потомок в узле:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->firstChild();
```

Результат:
```html
<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>
<h1><i class="icon"/><span>Header</span>-subheader</h1>
<p>First description</p>
```

Первый потомок в узле (аналогично childes):

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->firstChild();
```

Результат:
```html
<span class="text">First text</span>
<span>Last description</span>
```

Поиск потомков в узле:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->firstChild('div');
```

Результат:
```html
<span class="text">First text</span>
<span>Last description</span>
```

Поиск потомков в узле (аналогично childes):

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->firstChild('p');
```

Результат:
```html
<div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></div>
<h1><i class="icon"/><span>Header</span>-subheader</h1>
<p>First description</p>
```

Поиск через xPath:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->firstChild('//div/div');
```

Результат:
```html
<h1><i class="icon"/><span>Header</span>-subheader</h1>
```

### <a name="getNodeByPosition"></a> Получение DOMNode элемента

Возвращает DOMNode элемент по индексу.

Получение элемента по индексу:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->getNodeByPosition(1);
```

Результат:
```php
class DOMElement {}
```

### <a name="findNodeByPosition"></a> Возвращает найденный DOMNode элемент по индексу

Возвращает DOMNode элемент по индексу.

Поиск элемента:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->findNodeByPosition(1, 'p');
```

Результат:
```php
class DOMElement {}
```

### <a name="name"></a> Имя узла

Возвращает имя узла.

Имена узлов:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->name();
```

Результат:
```text
div
div
div
```

### <a name="rename"></a> Переименование узла

Изменение имени узла.

Изменение имени текущего узла:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->rename('section');
```

Результат:
```html
<section class="content"><section><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></section><br/><p>Last text</p></section>
<section><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p></section>
<section class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></section>
```

Поиск и изменение имени узла:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->rename('section', 'div');
```

```html
<div class="content"><div><h1><i class="icon"/><strong>Header</strong>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><strong class="text">First text</strong></p></div><br/><p>Last text</p></div>
<div><h1><i class="icon"/><strong>Header</strong>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><strong class="text">First text</strong></p></div>
<div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><strong>Last description</strong></p></div>
```

### <a name="replace"></a> Замена узла

Замена узла.

Замена текущих узлов.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->replace('<section><div>Header</div>Content</section>');
```

```html
<main class="main" role="main"><section><div>Header</div>Content</section><section><div>Header</div>Content</section></main>
```

Поиск и замена узлов.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->replace('<section><div>Header</div>Content</section>', 'div');
```

Результат:
```html
<main class="main" role="main"><section><div>Header</div>Content</section><section><div>Header</div>Content</section></main>
```

Поиск через XPath и замена узла.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->replace('<section><div>Header</div>Content</section>', '//div/div');
```

Результат:
```html
<main class="main" role="main"><div class="content"><section><div>Header</div>Content</section><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>
```

### <a name="remove"></a> Удаление узла

Удаление узла.

Удаление текущих узлов.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('div')->remove();
```

Результат:
```html
<main class="main" role="main"/>
```

Поиск и удаление узлов.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->remove('div');
```

Результат:
```html
<main class="main" role="main"/>
```

Поиск через XPath и замена узла.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->remove('//div/div');
```

Результат:
```html
<main class="main" role="main"><div class="content"><br/><p>Last text</p></div><div class="description" role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p></div></main>
```

### <a name="count"></a> Количество записей

Подсчет количества элементов.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->count();     // 4
$nodes->count('p');             // 4
$nodes->count('//*[@class]');   // 5
```

### <a name="exist"></a> Существование данных

Проверка существования узла.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->exist();     // true
$nodes->exist('p');             // true
$nodes->exist('//*[@class]');   // true
$nodes->exist('hr');            // false
```

### <a name="notExist"></a> Отсутствие данных

Проверка отстутствия узла.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->notExist();      // false
$nodes->notExist('p');              // false
$nodes->notExist('//*[@class]');    // false
$nodes->notExist('hr');             // true
```

### <a name="isElem"></a> Элемент

Проверка что количестов элементов равно 1.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->isElem();  // true
$nodes->find('p')->isElem();    // false
```

### <a name="isList"></a> Список

Проверка что количестов элементов более 1.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->isList();  // false
$nodes->find('p')->isList();    // true
```

### <a name="isDomComment"></a> DomComment

Проверка что элемент является DOMComment. Только для одного элемента, парсинг по умолчанию игнорирует DomComment.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->isDomComment();  // false
$nodes->find('p')->isDomComment();    // false
```

### <a name="isDomElement"></a> DomElement

Проверка что элемент является DomElement. Только для одного элемента.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->isDomElement();        // true
$nodes->find('p')->isDomElement();          // false
$nodes->find('p')->first()->isDomElement(); // true
```

### <a name="isDomText"></a> DomText

Проверка что элемент является DomText. Только для одного элемента, парсинг по умолчанию игнорирует DomText.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->isDomText();  // false
$nodes->find('p')->isDomText();    // false
```

### <a name="type"></a> Тип узла

Возвращает тип узла. Парсинг по умолчанию игнорирует типы отличные от 1.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->type();  // 1
$nodes->find('p')->type();    // 1\n1\n1\n1
```

### <a name="text"></a> Текст

Получение текста элемента.

Получение текста текущего элемента:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('//h1/span')->text();              // Header
$nodes->find('h1')->text();                     // Header-subheader
$nodes->find('//*[@class="content"]')->text();  // Header-subheaderFirst textLast text
```

Получение текста списка:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->text();
```

Результат:
```text
First text
Last text
First description
Last description
```

### <a name="addText"></a> Добавление текста

Добавляет текст в конец узла.

Добавление текста в пустой элемент:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('//h1/i')->addText('add text');
```

Результат:
```html
<i class="icon">add text</i>
```

Добавление текста в конец элемента:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->addText('add text');
```

Результат:
```html
<h1><i class="icon"/><span>Header</span>-subheaderadd text</h1>
```

Добавление текста в список:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->addText('add text');
```

Результат:
```html
<p><span class="text">First text</span>add text</p>
<p>Last textadd text</p>
<p>First descriptionadd text</p>
<p><span>Last description</span>add text</p>
```

### <a name="replaceText"></a> Замена текста

Замена текста в узле.

Добавление текста в пустой элемент:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('//h1/i')->replaceText('change text');
```

Результат:
```html
<i class="icon">add text</i>
```

Замена текста в узле:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->replaceText('change text');
```

Результат:
```html
<h1><i class="icon"/><span>Header</span>change text</h1>
```

Замена текста в списке:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->replaceText('change text');
```

Результат:
```html
<p><span class="text">First text</span>change text</p>
<p>change text</p>
<p>change text</p>
<p><span>Last description</span>change text</p>
```

### <a name="removeText"></a> Удаление текста

Удаление текста в узле.

Удаление текста в узле:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->removeText();
```

Результат:
```html
<h1><i class="icon"/><span>Header</span></h1>
```

Удаление текста в списке:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->replaceText('change text');
```

Результат:
```html
<p><span class="text">First text</span></p>
<p></p>
<p></p>
<p><span>Last description</span></p>
```

### <a name="attr"></a> Атрибут

Возвращает значение атирбута.

Список значений:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->attr('class');
```

Результат:
```text
content
description
```

Единственное значение:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->attr('role');
```

Результат:
```text
contentinfo
```

Значение по умолчанию:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->attr('role', 'default');
```

Результат:
```text
default
default
contentinfo
```

### <a name="hasAttr"></a> Проверка атрибута

Проверка наличия атрибута.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('img')->hasAttr('src');        // true
$nodes->find('i')->hasAttr('class');        // true
$nodes->find('p')->hasAttr('class');        // false
$nodes->find('div')->hasAttr('class');      // false
```

### <a name="setAttr"></a> Установка значения атрибута

Установка значения атрибута.

Работа с элементом:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$elem = $nodes->find('i');
$elem->setAttr('class', 'value');               // <i class="value"/>
$elem->setAttr('data-value', 'edit');           // <i class="value" data-value="edit"/>
$elem->setAttr('class', 'icon value');          // <i class="icon value" data-value="edit"/>
```

Работа со списком:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$elem = $nodes->find('p')->setAttr('class', 'text');
```

Результат:
```html
<p class="text"><span class="text">First text</span></p>
<p class="text">Last text</p>
<p class="text">First description</p>
<p class="text"><span>Last description</span></p>
```

### <a name="removeAttr"></a> Удаление атрибутов

Удаление атрибута.

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$elem = $nodes->find('span')->removeAttr('class');
```

Результат:
```html
<span>Header</span>
<span>First text</span>
<span>Last description</span>
```

### <a name="appendChild"></a> Добавление дочернего элемента

Добавление нового дочернего элемента.

Добавление в пустой элемент:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('i')->appendChild('<section><div>Header</div>Content</section>');
```

Результат:
```html
<i class="icon"><section><div>Header</div>Content</section></i>
```

Добавление в список:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->appendChild('<section><div>Header</div>Content</section>');
```

Результат:
```html
<p><span class="text">First text</span><section><div>Header</div>Content</section></p>
<p>Last text<section><div>Header</div>Content</section></p>
<p>First description<section><div>Header</div>Content</section></p>
<p><span>Last description</span><section><div>Header</div>Content</section></p>
```

Поиск и добавление:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->appendChild('<section><div>Header</div>Content</section>', 'p');
```

Результат:
```html
<p><span class="text">First text</span><section><div>Header</div>Content</section></p>
<p>Last text<section><div>Header</div>Content</section></p>
<p>First description<section><div>Header</div>Content</section></p>
<p><span>Last description</span><section><div>Header</div>Content</section></p>
```

### <a name="replaceChildes"></a> Замена дочернего элемента

Замена потомков.

Замена всех потомков:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->replaceChildes('<section><div>Header</div>Content</section>');
```

Результат:
```html
<h1><section><div>Header</div>Content</section><section><div>Header</div>Content</section>-subheader</h1>
```

Замена дочерних элементов по имени тега:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->replaceChildes('<section><div>Header</div>Content</section>', 'i');
```

Результат:
```html
<h1><section><div>Header</div>Content</section><span>Header</span>-subheader</h1>
```

### <a name="removeChildes"></a> Удаление дочерних элементов

Удаление потомков.

Удаление всех дочерни элементов:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->removeChildes();
```

Результат:
```html
<h1>-subheader</h1>
```

Удаление потомков по имени тега:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->removeChildes('i');
```

Результат:
```html
<h1><span>Header</span>-subheader</h1>
```

### <a name="toArray"></a> Список DOMNode элементов

Возвращает список DOMNode элементов.

Список элементов:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->toArray();
```

Результат:
```php
[
    class DOMElement {},
    class DOMElement {},
    class DOMElement {},
    class DOMElement {}
]
```

### <a name="toList"></a> Элемент NodeList

Возвращает NodeList.

NodeList:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('p')->toList();
```

Результат:
```php
class NodeList {}
```

### <a name="toString"></a> Контент

Возвращает разметку элемента, включая его текст.

Получение контента текущего элемента:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->find('h1')->toString();
```

Результат:
```html
<h1><i class="icon"/><span>Header</span>-subheader</h1>
```

Поиск и получение контента текущего элемента:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->toString('h1');
```

Результат:
```html
<h1><i class="icon"/><span>Header</span>-subheader</h1>
```

Поиск через XPath и получение контента текущего элемента:

```php
/** @var \cse\DOMManager\Nodes\Nodes $nodes */
$nodes->toString('//div/p');
```

Результат:
```html
<p><span class="text">First text</span></p>
<p>Last text</p>
<p>First description</p>
<p><span>Last description</span></p>a
```

### <a name="each"></a> Перебор элементов

Вызывает callback функцию для каждого элемента.

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

Результат:
```html
<main class="main" role="main"><div><div><h1><i class="icon"/><span>Header</span>-subheader</h1><img src="content_img.jpg" alt="content img"/><p><span class="text">First text</span></p>this div element</div><br/><p>Last text</p>this div element</div><div role="contentinfo"><p>First description</p><br/><em>Middle description</em><p><span>Last description</span></p>this div element</div></main>
```


## Тестирование и покрытие кода

PHPUnit используется для модульного тестирования. Данные тесты гарантируют, что методы класса выполняют свою задачу.

Подробную документацию по PHPUnit можно найти по адресу: https://phpunit.de/documentation.html.

Чтобы запустить тесты выполните:
```bash
phpunit PATH/TO/PROJECT/tests/
```

Чтобы сформировать отчет о покрытии тестами кода, необходимо выполнить следующую команду:
```bash
phpunit --coverage-html ./report PATH/TO/PROJECT/tests/
```

Чтобы использовать настройки по умолчанию, достаточно выполнить:
```bash
phpunit --configuration PATH/TO/PROJECT/phpunit.xml
```


## Помощь проекту

Огромная благодарность тем, кто готов помочь в развитии проекта. Вы можете помочь:
* Добавить сообщение об ошибке или предложение по улучшению.
* Поделиться улучшениями кода, послав Pull Request.
* Сделать перевод или оптимизировать его для вашей страны.
* Доработать документацию.
* Так же любая другая помощь.


## Лицензия

Эта PHP-библиотека с открытым исходным кодом распространяемая по лицензии MIT. Для получения более подробной информации, пожалуйста, ознакомьтесь с [лицензионным файлом](https://github.com/cs-eliseev/dom-manager/blob/master/LICENSE.md).

***

> GitHub [@cs-eliseev](https://github.com/cs-eliseev)