<style type="text/css">
  .ss{
    display: block;
    position: relative;
    font-size: 16px;
    font-family: sans-serif;
    color: #eaeaea;
    text-decoration: none;
    margin-bottom: 5px;
    padding-bottom: 12px;
    border-bottom: 1px solid #eaeaea;
  }
  .ss:hover {
    color: #4caf50;
  }
</style>
<?php
$xmlDoc=new DOMDocument();
$xmlDoc->load("http://localhost/1Tag/users.php");

$x=$xmlDoc->getElementsByTagName('user');

//get the q parameter from URL
$q=$_GET["q"];
$hint="";
//lookup all links from the xml file if length of q>0
if (strlen($q)>0) {
  $hint="";
  for($i=0; $i<($x->length); $i++) {
    $y=$x->item($i)->getElementsByTagName('username');
    $z=$x->item($i)->getElementsByTagName('url');
    $len=strlen($q);
    if ($y->item(0)->nodeType==1) {
      if (stristr($q, substr($y->item(0)->nodeValue, 0, $len))) {
        if ($hint=="") {
          $hint="<a class='ss' href='" . 
          $z->item(0)->nodeValue . 
          "' target='_blank'>" . 
          $y->item(0)->nodeValue . "</a>";
        } else {
          $hint=$hint . "<br /><a class='ss' href='" . 
          $z->item(0)->nodeValue . 
          "' target='_blank'>" . 
          $y->item(0)->nodeValue . "</a>";
        }
      }
    }
  }
}

//output the response
echo $hint === "" ? "no suggestion" : $hint;
?>