<?php
/**
* Index
*
* Copyright (c) 2018 Jefferson Arrubla H
*
* @copyright Copyright 2018 (c) Jefferson Arrubla H
* @link https://github.com/jeffarrubla/inflectedWord
* @version 0.1
*/
include('inflectedWord.php');

$inflectedWord = new inflectedWord();

echo $inflectedWord->check('cant','a','canta');
echo '<br>';
echo $inflectedWord->check('рек','ой','рекой');
echo '<br>';
echo $inflectedWord->check('com','o','como');
echo '<br>';
echo $inflectedWord->check('чита','ешь','читаешь');
echo '<br>';
echo $inflectedWord->check('take','s','takes');
echo '<br>';
echo $inflectedWord->check('красн','ому','красному');
echo '<br><br>';

echo $inflectedWord->check('танец','у','танцу');
echo '<br>';
echo $inflectedWord->check('cerr','o','cierro');
echo '<br>';
echo $inflectedWord->check('кошк','','кошек');
echo '<br>';
echo $inflectedWord->check('sent','ió','sintió');
echo '<br>';
echo $inflectedWord->check('mov','o','muevo');
echo '<br>';
echo $inflectedWord->check('cog','o','cojo');
echo '<br>';
echo $inflectedWord->check('run','ing','running');
echo '<br><br>';

echo $inflectedWord->check('ca','o','caigo');
echo '<br>';
echo $inflectedWord->check('мат','и','матери');
echo '<br>';
echo $inflectedWord->check('tak','ed','taken');
echo '<br>';
echo $inflectedWord->check('жи','ю','живу');