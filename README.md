##PHPUtils##

This class provides utility functions necessary for almost every web applications, All the functions are very easy to use,

##Function List##
<ol>
<li>PHP_isset</li>
<li>PHP_not_empty</li>
<li>onSetAndEmptyCheckHandler</li>
<li>PHP_person_tag_check</li>
<li>isEmailId</li>
<li>createPasswordHash</li>
<li>getUniqueId</li>
<li>isRegexComp</li>
<li>removeEmpty</li>
<li>getRealIP</li>
<li>GeoCodeIP</li>
<li>getInfoByIp</li>
<li>checkSameOriginEmail</li>
<li>downloadFile</li>
<li>get_file_size</li>
<li>equateSize</li>
<li>normalizeURL</li>
</ol>

##Function Explanation and examples##

<h4>onSetAndEmptyCheckHandler</h4>
<hr>

function compares the array passed with another array to see if the all the elements present in the second array is set and is not empty
on the second array. It can be used to check if a few parameters are present in $_POST and $_GET array.
```php

include 'src/PHPUtils.php';

function onSuccessHandler(){
//When Everything is in the way it is specified
}

function onEmptyHandler($array){
//If some elements are empty
}

function onNotSethandler($array){
//If some Elements are not set
}

PHPUtils::onSetAndEmptyCheckHandler( $_POST, //aray to be checked
                                     array("param1", "param2"), //Check if these params are set in the source array
                                     array("param1"), // Check if the params in this array are not empty in the source array
                                     "onSuccessHandler", //Function to be called if everything is set and not empty
                                     "onEmptyHandler", //If an element required is empty
                                     "onNotSetHandler", //If an element required is not set
                                     true //If a string with just spaces should be considered
                                     );

```

<h4>isRegexComp</h4>
<hr>
Compares a Regular expression to a string to check if the string matches the Regular Expression exactly.

```php
include 'src/PHPUtils.php';

bool isRegexComp(RegEx, String);
```

<h4>getInfoByIp</h4>
<hr>
```php
$infoArray = PHPUtils::getInfoByIp("183.1.34.2");
//The IP parameter is optional, if its not provided then host IP is taken
/*
*  Info Array Structure
*  ------------------------------------
*                  "city"
                   "region"
                   "area_code"
                   "dma_code"
                   "country_code"
                   "country_name"
                   "continent_code"
                   "latitude"
                   "longitude"
                   "region_code"
                   "region_name"
                   "currency_code"

*/
```

<hr>
<br>
Most of other functions are self explanatory, Please look into the Source code to see the parameter list and Return values.