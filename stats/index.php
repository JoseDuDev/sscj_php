<?php
$user = 'scj';
$pass = 'darlan@@libes';
$domain = 'santuarioscj.com.br';

$config_domain = '';
$dynamic_images = false;
$image_directory = './awstats_images/';
$spam_words = array('mortgage', 'sex', 'porn', 'cock', 'slut', 'facial', 'loving', 'gay', '.ro');

function get_file($fileQuery)
{
  global $user, $pass, $domain;
  return file_get_contents("http://$user:$pass@$domain:2082/".$fileQuery."&lang=pt");
}

$requesting_image = (strpos($_SERVER['QUERY_STRING'],'.png')===false)?false:true;

if($requesting_image) //it's a .png file...
{
  if(!$dynamic_images && !is_dir($image_directory))
  {
    exit;
  }
  $fileQuery = $_SERVER['QUERY_STRING'];
}
elseif(empty($_SERVER['QUERY_STRING']))//probably first time to access page...
{
    if(empty($config_domain))
    {
        $config_domain = $domain;
    }
  $fileQuery = "awstats.pl?config=$config_domain";
}
else //otherwise, all other accesses
{
  $fileQuery = 'awstats.pl?'.$_SERVER['QUERY_STRING'];
}

$file = get_file($fileQuery);

//check again to see if it was a .png file
//if it's not, replace the links
if(!$requesting_image)
{
  $file = str_replace('awstats.pl', basename($_SERVER['PHP_SELF']), $file);

  if($dynamic_images)
  {
    $imgsrc_search = '="/images';
    $imgsrc_replace = '="'.basename($_SERVER['PHP_SELF']).'?images';
  }
  else
  {
    $imgsrc_search = 'src="/images/awstats/';
    $imgsrc_replace = 'src="'.$image_directory;
  }

  $file = str_replace($imgsrc_search, $imgsrc_replace, $file);
  $file = str_replace($spam_words, 'SPAM', $file);
}
else //if it is a png, output appropriate header
{
  header("Content-type: image/png");
}

echo $file;
?> 