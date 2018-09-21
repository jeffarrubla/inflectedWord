# inflectedWord


# Files

 - **index.php** call the class and show the information and give it the data
 - **inflectedWord.php** the class to do the task
 - **[finediff.php](https://github.com/gorhill/PHP-FineDiff)** class to manage the comparison between words

## [Documentation](https://docs.google.com/document/d/1kbUpnNUyjzTu2k_VJrOzYFT8nKFh9U2zTFXTTvbcGqw/edit)

# Documentation

## Introduction

There are languages that inflects. The form of words changes in order to show its grammatical function.

The inflected words are usually made adding an ending to the stem.

The inflected words that are formed adding an ending to the stem follows the language rules, so they are regular.

They are other inflected words that doesn’t follow the rule because they have some changes in the stem or because they are irregular.

## Task

Develop a class in PHP that checks if one conjugated word is regular or irregular.
The input for the class is:
 - One Stem
 - One Ending
 - One Inflected Word
There have to be a method called  __check__ that returns the inflected word marked with tags (see below), in lowercase.

**Regular Inflected Word**
An Inflected word is regular when it is formed adding the ending to the stem.

stem
ending
Inflected word
check return
cant
a
canta
cant<reg>a</reg>
рек
ой
рекой
рек<reg>ой</reg>
com
o
como
com<reg>o</reg>
чита
ешь
читаешь
чита<reg>ешь</reg>
take
s
takes
take<reg>s</reg>
красн
ому
красному
красн<reg>ому</reg>


Inflected Word with Changes
An inflected word only can have changes in the stem, the ending never can change.
There can be only one of these changes in the stem:
Disappears a letter
Appears a letter
A vowel changes to another vowel
A vowel changes to two vowels
A consonant changes to another consonant

stem
ending
Inflected word
check return
танец
у
танцу
танц<reg>у</reg>
cerr
o
cierro
c<change>i</change>err<reg>o</reg>
кошк


кошек
кош<change>е</change>к
sent
ió
sintió
s<change>i</change>nt<reg>ió</reg>
mov
o
muevo
m<change>ue</change>v<reg>o</reg>
cog
o
cojo
co<change>j</change><reg>o</reg>
run
ing
running
run<change>n</change><reg>ing</reg>



Irregular Inflected Word
An Inflected word is irregular when it is not Regular or is with Changes

stem
ending
Inflected word
check return
ca
o
caigo
<irreg>caigo</irreg>
мат
и
матери
<irreg>матери</irreg>
tak
ed
taken
<irreg>taken</irreg>
жи
ю
живу
<irreg>живу</irreg>



Latin alphabet
Vowels: aeiou
Consonants: bcdfghjklmnpqrstvwxyz

Cyrillic alphabet
Vowels:аиоуыэеёюя
Consonants: бвгджзйклмнпрстфхцчшщ
