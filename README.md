UrlFriendlyListHelper
==========================
2015-11-04



Utility to handle pagination, sort and search in your html lists.


 
Features
-----------

- handling of multiple lists on the same page
- seo friendly: parameters are passed via the url 
- extensible: you can create your own plugins
- takes in account your application's routing logic




How to use?
-------------


UrlFriendlyListHelper can be installed as a [planet](https://github.com/lingtalfi/Observer/blob/master/article/article.planetReference.eng.md).



### Simplest example possible (and also almost useless)


```php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <!--<script src="http://localcdn/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <title>Html page</title>
</head>
<body>
<?php


use UrlFriendlyListHelper\Displayer\PuppyBaseDisplayer;
use UrlFriendlyListHelper\ItemGenerator\ArrayItemGenerator;
use UrlFriendlyListHelper\ListHelper\AuthorListHelper;
use UrlFriendlyListHelper\Router\AuthorListRouter;

require_once "bigbang.php";


$rows = [
    [
        'name' => 'peter',
        'age' => '37',
        'bank_account' => '37',
    ],
    [
        'name' => 'alice',
        'age' => '32',
        'bank_account' => '3500',
    ],
    [
        'name' => 'chloe',
        'age' => '34',
        'bank_account' => '135000000',
    ],
    [
        'name' => 'nathalie',
        'age' => '47',
        'bank_account' => '5000000',
    ],
    [
        'name' => 'gilberte',
        'age' => '78',
        'bank_account' => '20000',
    ],
    [
        'name' => 'laetitia',
        'age' => '48',
        'bank_account' => '640000',
    ],
    [
        'name' => 'hanter',
        'age' => '13',
        'bank_account' => '140',
    ],
    [
        'name' => 'esmeralda',
        'age' => '26',
        'bank_account' => '1000000000000000000',
    ],
    [
        'name' => 'jasmine',
        'age' => '27',
        'bank_account' => '100000000000000000000',
    ],
    [
        'name' => 'elisabeth',
        'age' => '20',
        'bank_account' => '304520',
    ],
    [
        'name' => 'pizza',
        'age' => '50',
        'bank_account' => '75000',
    ],
    [
        'name' => 'adeline',
        'age' => '32',
        'bank_account' => '65000078',
    ],
    [
        'name' => 'aeoliryu',
        'age' => '98',
        'bank_account' => '75085052664',
    ],
    [
        'name' => 'agathe',
        'age' => '7',
        'bank_account' => '980',
    ],
];
$itemGenerator = ArrayItemGenerator::create()->setRows($rows);


// ROUTER
//------------------------------------------------------------------------------/
$router = AuthorListRouter::create()
    ->setListParametersExtractor(function () {
        $listParams = $_GET;
        return $listParams;
    })
    ->setUrlGenerator(function (array $listParams) {
        $curParams = array_replace($_GET, $listParams);
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
        return $uri . '?' . http_build_query($curParams);
    })
    ->start();



// HELPER LIST 
//------------------------------------------------------------------------------/
$listHelper = AuthorListHelper::create()
    ->setItemGenerator($itemGenerator)
    ->setRouter($router);
    
$listHelper->start();




// ITEM GENERATION
//------------------------------------------------------------------------------/
$listRows = $itemGenerator->getItems();
echo PuppyBaseDisplayer::create()->renderHtml($listRows);


?>
</body>
</html>
```


### Using the pagination plugin 

```php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <!--<script src="http://localcdn/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <title>Html page</title>
</head>
<body>
<?php


use UrlFriendlyListHelper\Displayer\PuppyBaseDisplayer;
use UrlFriendlyListHelper\ItemGenerator\ArrayItemGenerator;
use UrlFriendlyListHelper\ItemGeneratorHelper\One\OnePaginationArrayItemGeneratorHelper;
use UrlFriendlyListHelper\ListHelper\AuthorListHelper;
use UrlFriendlyListHelper\Plugin\Pagination\MyHtmlPaginationPlugin;
use UrlFriendlyListHelper\Router\AuthorListRouter;

require_once "bigbang.php";


$rows = [
    [
        'name' => 'peter',
        'age' => '37',
        'bank_account' => '37',
    ],
    [
        'name' => 'alice',
        'age' => '32',
        'bank_account' => '3500',
    ],
    [
        'name' => 'chloe',
        'age' => '34',
        'bank_account' => '135000000',
    ],
    [
        'name' => 'nathalie',
        'age' => '47',
        'bank_account' => '5000000',
    ],
    [
        'name' => 'gilberte',
        'age' => '78',
        'bank_account' => '20000',
    ],
    [
        'name' => 'laetitia',
        'age' => '48',
        'bank_account' => '640000',
    ],
    [
        'name' => 'hanter',
        'age' => '13',
        'bank_account' => '140',
    ],
    [
        'name' => 'esmeralda',
        'age' => '26',
        'bank_account' => '1000000000000000000',
    ],
    [
        'name' => 'jasmine',
        'age' => '27',
        'bank_account' => '100000000000000000000',
    ],
    [
        'name' => 'elisabeth',
        'age' => '20',
        'bank_account' => '304520',
    ],
    [
        'name' => 'pizza',
        'age' => '50',
        'bank_account' => '75000',
    ],
    [
        'name' => 'adeline',
        'age' => '32',
        'bank_account' => '65000078',
    ],
    [
        'name' => 'aeoliryu',
        'age' => '98',
        'bank_account' => '75085052664',
    ],
    [
        'name' => 'agathe',
        'age' => '7',
        'bank_account' => '980',
    ],
];
$itemGenerator = ArrayItemGenerator::create()->setRows($rows);
?>
<style>
    .active {
        font-size: 20px;
    }
</style>
<?php


$nbItemsPerPage = 3;
$pagination = MyHtmlPaginationPlugin::create()
    ->setNbItemsPerPage($nbItemsPerPage)
    ->setGeneratorHelper(OnePaginationArrayItemGeneratorHelper::create());


// ROUTER
//------------------------------------------------------------------------------/
$router = AuthorListRouter::create()
    ->setListParametersExtractor(function () {
        $listParams = $_GET;
        return $listParams;
    })
    ->setUrlGenerator(function (array $listParams) {
        $curParams = array_replace($_GET, $listParams);
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
        return $uri . '?' . http_build_query($curParams);
    })
    ->start();



// HELPER LIST 
//------------------------------------------------------------------------------/
$listHelper = AuthorListHelper::create()
    ->setItemGenerator($itemGenerator)
    ->setRouter($router)
    ->registerPlugin($pagination);
    
$listHelper->start();




// ITEM GENERATION
//------------------------------------------------------------------------------/
$listRows = $itemGenerator->getItems();
echo PuppyBaseDisplayer::create()->renderHtml($listRows);
echo $pagination->renderHtml();


?>
</body>
</html>
```




### Multiple lists complete example

```php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <!--<script src="http://localcdn/ajax/libs/jquery/1.10.2/jquery.min.js"></script>-->
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
    <title>Html page</title>
</head>
<body>
<?php


use UrlFriendlyListHelper\ItemGenerator\ArrayItemGenerator;
use UrlFriendlyListHelper\ItemGeneratorHelper\One\OnePaginationArrayItemGeneratorHelper;
use UrlFriendlyListHelper\ItemGeneratorHelper\One\OneSearchArrayItemGeneratorHelper;
use UrlFriendlyListHelper\ItemGeneratorHelper\One\OneSortArrayItemGeneratorHelper;
use UrlFriendlyListHelper\ListHelper\AuthorListHelper;
use UrlFriendlyListHelper\Plugin\Pagination\MyHtmlPaginationPlugin;
use UrlFriendlyListHelper\Plugin\Search\MySearchPlugin;
use UrlFriendlyListHelper\Plugin\Sort\MySortPlugin;
use UrlFriendlyListHelper\Displayer\PuppyBaseDisplayer;
use UrlFriendlyListHelper\Router\AuthorListRouter;

require_once "bigbang.php";


$rows = [
    [
        'name' => 'peter',
        'age' => '37',
        'bank_account' => '37',
    ],
    [
        'name' => 'alice',
        'age' => '32',
        'bank_account' => '3500',
    ],
    [
        'name' => 'chloe',
        'age' => '34',
        'bank_account' => '135000000',
    ],
    [
        'name' => 'nathalie',
        'age' => '47',
        'bank_account' => '5000000',
    ],
    [
        'name' => 'gilberte',
        'age' => '78',
        'bank_account' => '20000',
    ],
    [
        'name' => 'laetitia',
        'age' => '48',
        'bank_account' => '640000',
    ],
    [
        'name' => 'hanter',
        'age' => '13',
        'bank_account' => '140',
    ],
    [
        'name' => 'esmeralda',
        'age' => '26',
        'bank_account' => '1000000000000000000',
    ],
    [
        'name' => 'jasmine',
        'age' => '27',
        'bank_account' => '100000000000000000000',
    ],
    [
        'name' => 'elisabeth',
        'age' => '20',
        'bank_account' => '304520',
    ],
    [
        'name' => 'pizza',
        'age' => '50',
        'bank_account' => '75000',
    ],
    [
        'name' => 'adeline',
        'age' => '32',
        'bank_account' => '65000078',
    ],
    [
        'name' => 'aeoliryu',
        'age' => '98',
        'bank_account' => '75085052664',
    ],
    [
        'name' => 'agathe',
        'age' => '7',
        'bank_account' => '980',
    ],
];
$itemGenerator = ArrayItemGenerator::create()->setRows($rows);
$rows2 = $rows;
array_walk($rows2, function (&$v) {
    $v['name'] = strrev($v['name']);
});
$itemGenerator2 = ArrayItemGenerator::create()->setRows($rows2);

?>
<style>
    .active {
        font-size: 20px;
    }
</style>
<?php

/**
 * Application
 */
$nbItemsPerPage = 3;


// ROUTER
//------------------------------------------------------------------------------/
$router = AuthorListRouter::create()
    ->setListParametersExtractor(function () {
        $listParams = $_GET;
        return $listParams;
    })
    ->setUrlGenerator(function (array $listParams) {
        $curParams = array_replace($_GET, $listParams);
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
        return $uri . '?' . http_build_query($curParams);
    })
    ->start();


// PLUGIN CONFIG
//------------------------------------------------------------------------------/
$pagination = MyHtmlPaginationPlugin::create()
    ->setNbItemsPerPage($nbItemsPerPage)
    ->setGeneratorHelper(OnePaginationArrayItemGeneratorHelper::create());
$sort = MySortPlugin::create()
    ->setSelectEntries([
        'name_asc' => ['name asc', 'name', 'asc'],
        'name_desc' => ['name desc', 'name', 'desc'],
        'age_asc' => ['age asc', 'age', 'asc'],
        'age_desc' => ['age desc', 'age', 'desc'],
        'bank_account_asc' => ['bank account asc', 'bank_account', 'asc'],
        'bank_account_desc' => ['bank account desc', 'bank_account', 'desc'],
    ])
    ->setGeneratorHelper(OneSortArrayItemGeneratorHelper::create())
    ->setDefaultSortId('name_asc');
$search = MySearchPlugin::create()->setGeneratorHelper(OneSearchArrayItemGeneratorHelper::create()->setSearchFields([
    'name',
]));

// HELPER LIST 
//------------------------------------------------------------------------------/
$listHelper = AuthorListHelper::create()
    ->setItemGenerator($itemGenerator)
    ->setRouter($router)
    ->registerPlugin($search)
    ->registerPlugin($sort)
    ->registerPlugin($pagination);
$listHelper->start();


// ITEM GENERATION
//------------------------------------------------------------------------------/
$listRows = $itemGenerator->getItems();


// RENDERING
//------------------------------------------------------------------------------/

/**
 * Template part, imagine that some html glues everything
 */
echo $search->renderHtml();
echo '<hr>';
echo $sort->renderHtml();
echo '<hr>';
echo PuppyBaseDisplayer::create()->renderHtml($listRows);


// use a plugin
echo $pagination->renderHtml();


?>

<hr>
<?php


//------------------------------------------------------------------------------/
// TESTING MULTIPLE LISTS ON THE SAME PAGE
//------------------------------------------------------------------------------/
$genHelper2 = OnePaginationArrayItemGeneratorHelper::create();
$pagination2 = MyHtmlPaginationPlugin::create()
    ->setNbItemsPerPage($nbItemsPerPage)
    ->setGeneratorHelper($genHelper2);
$sort2 = MySortPlugin::create()
    ->setSelectEntries([
        'name_asc' => ['name asc', 'name', 'asc'],
        'name_desc' => ['name desc', 'name', 'desc'],
        'age_asc' => ['age asc', 'age', 'asc'],
        'age_desc' => ['age desc', 'age', 'desc'],
        'bank_account_asc' => ['bank account asc', 'bank_account', 'asc'],
        'bank_account_desc' => ['bank account desc', 'bank_account', 'desc'],
    ])
    ->setGeneratorHelper(OneSortArrayItemGeneratorHelper::create())
    ->setDefaultSortId('name_asc');
$search2 = MySearchPlugin::create()->setGeneratorHelper(OneSearchArrayItemGeneratorHelper::create()->setSearchFields([
    'name',
]));

$listHelper2 = AuthorListHelper::create()
    ->setItemGenerator($itemGenerator2)
    ->setRouter($router)
    ->registerPlugin($search2)
    ->registerPlugin($sort2)
    ->registerPlugin($pagination2);
$listHelper2->start();
$listRows2 = $itemGenerator2->getItems();

echo $search2->renderHtml();
echo '<hr>';
echo $sort2->renderHtml();
echo '<hr>';
echo PuppyBaseDisplayer::create()->renderHtml($listRows2);
echo $pagination2->renderHtml();
?>

</body>
</html>
```


How does it work?
---------------------

![url friendly list helper overview](http://s19.postimg.org/wg2kw004j/url_Friendly_List_Helper_overview.jpg)


There are also my [brainstorm notes](https://github.com/lingtalfi/UrlFriendlyListHelper/blob/master/doc/brainstorm/brainstorm.urlFriendlyListHelper.md) that might help to understand the general guidelines.






Dependencies
------------------

- [lingtalfi/Bat 1.12](https://github.com/lingtalfi/Bat)
- [lingtalfi/JQuery 2.1.4](https://github.com/lingtalfi/JQuery)




History Log
------------------
    
- 1.0.0 -- 2015-11-04

    - initial commit
    
    