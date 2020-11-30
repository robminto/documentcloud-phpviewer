   
   <!--   
     Customized document viewer for use with DocumentCloud, at http://documentcloud.org
    This uses PHP rather than JQuery for the coding.
     This viewer is a replacement for the John Keefe one (http://johnkeefe.net/a-customized-viewer-for-documentcloud)
     Use at your own risk, please let us know if you use / improve etc
     Please see github for php and details
     URL: https://github.com/robminto/documentcloud-phpviewer
   -->

<?php 

// declare your own variables - ie customise for your organisation EDIT THIS BIT
$org_name = "Example"; // THE NAME OF YOUR ORGANISATION
$org_url = "https://www.example.uk"; // YOUR HOMEPAGE IS GOOD HERE
$org_DC_ID = "1234"; // YOU GET YOUR ORG ID FROM DOCUMENT CLOUD - needed to stop people trying your viewer with other documents that aren't yours
$org_logo = "file_path_to/your/logo.jpg";  // your logo URL, file path from public_html


// YOU SHOULDN'T HAVE TO EDIT BELOW THIS - UNLESS YOU WANT TO MAKE IT WORK DIFFERENTLY, OF COURSE
// get the dcid from the URL
$dcid = $_GET["dcid"];
// if there is a DCID read the file
if ($dcid !== "")  {

// build the document cloud URL and get the json file
$json_url = "https://api.beta.documentcloud.org/api/documents/".$dcid."/?format=json";
$json = @file_get_contents($json_url);

// read the json
$fileContents = json_decode($json, TRUE);

// create the variables from the array
$canonical_url = $fileContents["canonical_url"];
$related_article = $fileContents["related_article"];
$source = $fileContents["source"];
$title = $fileContents["title"];
$org = $fileContents["organization"];
// you can pull other attributes from the array here, it's your call. 

}
else {
// if there's no DCID in the URL, stop
  echo "<pre>You have found a broken link - <a href=\"$org_url\">please return to $org_name</a>. Thanks.</pre>";
  exit;
}
// stop the script if it's not part of your organisation
if ($org != $org_DC_ID ) {
  echo "<pre>Sorry, that's not going to work - you have tried to load a document that is not part of $org_name.</pre> ";
  exit;
}

?>  

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
    "http://www.w3.org/TR/html4/loose.dtd"> 
<html> 
<head><title id="maintitle">Document Cloud viewer via <? echo $org_name; ?></title> 
    <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="docviewer.css" media="all" rel="stylesheet" type="text/css"> 
</head> 
<body> 
<div id="header">  
  <!-- use a logo 60 pixels tall -->  
  <a rel="external" href="<? echo $org_url;?>"><img id="banner-logo" src="<? echo $org_logo;?>" alt="<? echo $org_name;?> Logo"></a> 
	<h1 id='title'><div id='titletext'><? echo $title; ?></div></h1> 
	<p id="document-source"><? echo $source; ?></p> 
	<p id='back'><div id='article-link'><a href="<? echo $related_article; ?>">Back to <? echo $org_name;?></a></div></p> 
</div>

<!-- The document on Document Cloud is loaded into the iframe -->
<iframe src="<? echo $canonical_url; ?>">
</iframe>
 

</body> 
</html>
