#### extract

extract — 从数组中将变量导入到当前的符号表

本函数用来将变量从数组中导入到当前的符号表中。

检查每个键名看是否可以作为一个合法的变量名，同时也检查和符号表中已有的变量名的冲突。

> **警告** 不要对不可信的数据使用 **extract()**，类似用户输入（例如 [$_GET](https://www.php.net/manual/zh/reserved.variables.get.php)、[$_FILES](https://www.php.net/manual/zh/reserved.variables.files.php)）。

```php

<?php

/* 假定 $var_array 是 wddx_deserialize 返回的数组*/

$size = "large";
$var_array = array("color" => "blue","size"  => "medium","shape" => "sphere");
extract($var_array, EXTR_PREFIX_SAME, "wddx");

echo "$color, $size, $shape, $wddx_size";

?>


```


