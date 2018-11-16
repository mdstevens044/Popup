# Popup
### Class to create a popup

At my job we create a lot of popup's to send messages to users and get input from them. I created this class to cut down on the amount of code we would have to write per popup. This takes the code required to create a popup from 26 lines to 3 lines. 

To use:
```php
<?php
$testPopup = new Popup('testiframe.html', 'TestPopup', 'Test Popup', '300px', '200px', 1);
$popUp = $testPopup->createHTML();
// Put $popup variable inside $pageContent string
//Call popup by 
onclick="$testPopup->getId();"
```
