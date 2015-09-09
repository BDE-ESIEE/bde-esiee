Site web du BDE ESIEE Paris
===========================

#####How to fix on Windows :

[Symfony\Component\Config\Exception\FileLoaderLoadException]

[WARNING 1549] failed to load external entity "in_memory_buffer" (in n/a - line 0, column 0)

[WARNING 3084] Element '{http://www.w3.org/2001/XMLSchema} import': Failed to locate a schema at location 'in_memory_buffer'. Skipping the import. (in in_memory_buffer - line 9, column 0)

======

Because shitty Windows doesn't use "/" as directory separator in file path like Linux, you need to use a php function called str_replace() in order to replace backslashes by slashes. schemaValidateSource() expects "/" but realpath() function uses "\" on Windows, that is why you need to replace backslashes by slashes after the use of realpath() function. I also corrected an error for the path of the file `routing-1.0.xsd`.

1) Go to `\path-to-www\bde-esiee\vendor\friendsofsymfony\rest-bundle\FOS\RestBundle\Routing\Loader` and open `RestXmlCollectionLoader.php`

2) Search the block (near line 179)
```
$restRoutinglocation = realpath(__DIR__.'/../../Resources/config/schema/routing/rest_routing-1.0.xsd');
$routinglocation = realpath(__DIR__.'/../../Resources/config/schema/routing/routing-1.0.xsd');
```

3) Replace the previous block by this one :
```
$restRoutinglocation = realpath(__DIR__.'/../../Resources/config/schema/routing/rest_routing-1.0.xsd');
$restRoutinglocation = str_replace('\\', '/', $restRoutinglocation);
$routinglocation = realpath(__DIR__.'/../../Resources/config/schema/routing-1.0.xsd');
$routinglocation = str_replace('\\', '/', $routinglocation);
```

4) Don't forget the clear the cache :
`php app/console cache:clear --env=dev`


[License](http://www.wtfpl.net)
[Installation](http://symfony.com/doc/current/book/installation.html)
