
1
2
3
4
5
6
7
8
9
10
11
12
13
14
15
16
17
18
19
20
21
22
23
24
25
26
27
28
29
30
31
32
33
34
35
36
37
38
39
40
41
42
43
44
45
46
47
<?php

function cube($n){
    return $n * $n * $n;
}

class MyClass {
    private $data;

    public function __construct(){
        $this->data = array(1,3,5,7,9);
    }

    public function filteredDataByClosure(){
        return array_map(function($cell) {return $cell * $cell; }, $this->data);
    }

    public function filteredDataByGlobalFunction(){
        return array_map('cube', $this->data);
    }

    public function filteredDataByStaticMethod(){
        return array_map(array('MyClass', 'minusOne'), $this->data);
    }

    public function filteredDataByMethod(){
        return array_map(array($this, 'plusOne'), $this->data);
    }

    public static function minusOne($n){
        return --$n;
    }

    public function plusOne($n){
        return ++$n;
    }
}

$mc = new MyClass();
var_dump($mc->filteredDataByClosure());
echo "<br />";
var_dump($mc->filteredDataByGlobalFunction());
echo "<br />";
var_dump($mc->filteredDataByStaticMethod());
echo "<br />";
var_dump($mc->filteredDataByMethod());
echo "<br />";