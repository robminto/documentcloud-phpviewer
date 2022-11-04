<?php 

// declare your own variables - ie customise for your organisation EDIT THIS BIT
$org_name = "Example"; // THE NAME OF YOUR ORGANISATION
$org_url = "https://www.example.uk"; // YOUR HOMEPAGE IS GOOD HERE
$org_DC_ID = "1234"; // YOU GET YOUR ORG ID FROM DOCUMENT CLOUD - needed to stop people trying your viewer with other documents that aren't yours
$org_logo = "file_path_to/your/logo.jpg";  // your logo URL, file path from public_html


// YOU SHOULDN'T HAVE TO EDIT BELOW THIS - except for the logo
// get the dcid from the URL

if(isset($_GET['dcid']))
{
  $dcid = $_GET["dcid"];
    // build the document cloud URL and get the json file
    $json_url = "https://api.www.documentcloud.org/api/documents/".$dcid."/?format=json";
    $json = @file_get_contents($json_url);
  // at this point it's better to do an authenticated CURL script to access the API. You can get authentication token via muckrock API. Details are here: https://www.documentcloud.org/help/api#authentication

    // read the json
    $fileContents = json_decode($json, TRUE);
 
  // kill if the API result is a 'detail' result
  if (isset($fileContents['detail'])) {
  echo "There's been an error, usually one of the following:
  <ul>
  <li>the document ID doesn't exist</li>
  <li>the document has been deleted</li>
  </ul>";
  exit;
}

    // create the variables from the array
    $canonical_url = $fileContents["canonical_url"];

    if (isset($_GET['page'])) {
      $page = $_GET["page"];
      $canonical_url = $canonical_url."#document/p$page";
    }
    $title = $fileContents["title"];
    $description = $fileContents["description"];
    $related_article = $fileContents["related_article"];
    $source = $fileContents["source"];
    $org = $fileContents["organization"];

  if ($org != $org_DC_ID ) {
  echo "<pre>You have tried to load a document that is not part of $org_name.</pre> ";
  exit;
  }


}
else {
// if there's no DCID in the URL, stop
  echo "<pre>You have found a broken link - <a href=\"$org_url\">please return to $org_name</a>. Thanks.</pre>";
  exit;
}

?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
   
   <!--   
     Customized document viewer for use with DocumentCloud, at http://documentcloud.org
    This uses PHP rather than JQuery for the coding.
     This viewer is a replacement for the John Keefe one (http://johnkeefe.net/a-customized-viewer-for-documentcloud)
     Use at your own risk, please let us know if you use / improve etc
     Please see github for php and details
     URL: https://github.com/robminto/documentcloud-phpviewer
   -->

<head><title id="maintitle">Document Cloud viewer via <? echo $org_name; ?></title> 
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="css/docviewer.css?v=0.2" media="all" rel="stylesheet" type="text/css"> 
</head> 
<body> 
<div id="header">  
  <!-- use a logo 60 pixels tall -->  
<a rel="external" href="<? echo $org_url;?>"><img id="banner-logo" src="<? echo $org_logo;?>" alt="<? echo $org_name;?> Logo"></a> 
<div class='dcv-title'><h1><? echo $title; ?></h1></div> 
<div class='dcv-description'><? echo $description; ?></div> 
<div class='dcv-source'>Source: <? echo $source; ?></div>
<?
if (strlen($related_article) > 0) {
  ?>
  <div class='dcv-article-link'><a href="<? echo $related_article; ?>">Back to <? echo $org_name;?></a></div>
<?
} else { ?>
  <div class='dcv-article-link'><a href="<? echo $org_url; ?>">Back to <? echo $org_name;?></a></div>
<?
}
?>
</div>

<!-- The document on Document Cloud is loaded into the iframe -->
<iframe src="<? echo $canonical_url; ?>">
</iframe>
 

</body> 
</html>
