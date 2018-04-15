<?php
/**
 * Class to create external iFrame of a popup
 *
 * This class allows a user to create the external iFrame for
 * Silver Hammer popups without having to write 20+ lines of
 * code per popup. This will also save time when creating a
 * lot of iFrames.
 *
 * Variable Meanings
 * $src = Source file for inner html of iFrame
 * $id = ID of the iFrame used for id, h2, div, and function names
 * $title = Title of the popup
 * $width = Width of iFrame (Include px)
 * $height = Height of iFrame (Include px)
 * $color = Color of iFrame usually red or green (Use 1 for green and 2 for red)
 * $draggable = Make iFrame draggable or not (Default is true)
 *
 * Example
 * $testPopup = new Popup('testiframe.html', 'TestPopup', 'Test Popup', '300px', '200px', 1);
 * $popUp = $testPopup->createHTML();
 * Put $popup variable inside $pageContent string
 * Call popup by onclick="$testPopup->getId();"
 */

  class Popup
  {
    private $src; // string
    private $id; // string
    private $title; // string
    private $width; // string
    private $height; // string
    private $color; // int
    private $draggable; // boolean
    private $htmlCode; // string

    function __construct($src, $id, $title, $width, $height, $color, $draggable = true)
    {
      $this->src = $src;
      $this->id = $id;
      $this->title = $title;
      $this->width = $width;
      $this->height = $height;
      $this->color = ($color == 1) ? "#228B22" : "#AD0000";
      $this->draggable = $draggable;
    }

    function createHTML()
    {
      $this->htmlCode = "
        <div id='div$this->id' style='border: 3px solid $this->color; border-radius: 10px; background-color: #fff; position: absolute; width: $this->width; height: $this->height; display: none; z-index: 1001;'>
          <h2 id='h2$this->id' style='background-color: $this->color; color: #fff; text-align: center; margin: 0px; padding: .25em; z-index: 1001;'>$this->title</h2>
          <iframe id='$this->id' src='' style='display: none; position: absolute; width: 98.5%; height: 87.5%; z-index: 1001; overflow: hidden; border-radius: 0px 0px 8px 8px;' scrolling='no'></iframe>
        </div>

        <script>
          // If draggable is set to true execute 
          if($this->draggable)
          {          
            dragElement(document.getElementById('div$this->id'));
            
            function dragElement(elmnt) 
            {
              var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
              
              if(document.getElementById(elmnt.id + 'header')) 
              {
                // if present, the header is where you move the DIV from
                document.getElementById(elmnt.id + 'header').onmousedown = dragMouseDown;
              } else {
                // otherwise, move the DIV from anywhere inside the DIV
                elmnt.onmousedown = dragMouseDown;
              }
            
              function dragMouseDown(e) 
              {
                e = e || window.event;
                // get the mouse cursor position at startup:
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                // call a function whenever the cursor moves:
                document.onmousemove = elementDrag;
              }
            
              function elementDrag(e) 
              {
                e = e || window.event;
                // calculate the new cursor position:
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                // set the element's new position:
                elmnt.style.top = (elmnt.offsetTop - pos2) + 'px';
                elmnt.style.left = (elmnt.offsetLeft - pos1) + 'px';
              }
            
              function closeDragElement() 
              {
                // stop moving when mouse button is released
                document.onmouseup = null;
                document.onmousemove = null;
              }
            }
          }
          
          function show$this->id()
          {
            var y = (window.pageYOffset !== undefined) ? window.pageYOffset + 70 : (document.documentElement || document.body.parentNode || document.body).scrollTop + 70;
            var w = (((window.innerWidth / 2) - ('$this->width'.replace('px', '') / 2)) / window.innerWidth) * 100;
            
            document.getElementById('div$this->id').style.left = w + '%';
            document.getElementById('div$this->id').style.top = y + 'px';
        
            document.getElementById('$this->id').src='$this->src';
            document.getElementById('$this->id').style.display='block';
            document.getElementById('div$this->id').style.display='block';
          }
          function hide$this->id()
          {
            document.getElementById('div$this->id').style.display='none';
            document.getElementById('$this->id').style.display='none';
            document.getElementById('$this->id').src='';
          }
        </script>
      ";
    }

    function getHtmlCode()
    {
      return $this->htmlCode;
    }

    function getShow()
    {
      return 'show'.$this->id.'();';
    }

    function getHide()
    {
      return 'hide'.$this->id.'();';
    }
  }

?>