<?php
require_once("support.php");
require_once("TwitterAPIExchange.php");

$settings = array(
  'oauth_access_token' => "724727885727162369-vIhVN0y0ObhPJ6Lpy2ZNXUeVUT7Hu7r",
  'oauth_access_token_secret' => "dbcCdrokULSmPkXNIx3fcgSk26Ozp7PtG51Q1dNAB11OG",
  'consumer_key' => "vQ1vJ7Seb46utEPp1r5LreIo7",
  'consumer_secret' => "mDUd9IJVo6MRPBnTlDjRA7U8xMslI5STh44FqUmK4irTuvi50u"
);

$url = "https://api.twitter.com/1.1/search/tweets.json";
$tweets = array();
$requestMethod = 'GET';
$getfield = '?q=from:';
$getfield .= $_POST['user'];
$twitter = new TwitterAPIExchange($settings);
$resultJSON = $twitter->setGetfield($getfield)
              ->buildOauth($url, $requestMethod)
              ->performRequest();

$result = json_decode($resultJSON);
foreach($result->statuses as $tweet) {
 //echo $tweet->text;
  $tweets[] = $tweet->text;
}
$page = <<<EOBODY
<h1> Result  </h1>
<div id = "resultDiv"> Result </div>
EOBODY;
echo $page;
?>
<script type = "text/javascript">  var stringArray = <?php echo  json_encode($tweets); ?>;
</script>

<script src = "bundle.js"> </script>
