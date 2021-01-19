<?php 
header ("Access-Control-Allow-Origin: https://bestgiaitri.com"); 

require_once $_SERVER['DOCUMENT_ROOT'].'/cvv/ChineChess/api/php-jwt-master/src/BeforeValidException.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/cvv/ChineChess/api/php-jwt-master/src/ExpiredException.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/cvv/ChineChess/api/php-jwt-master/src/SignatureInvalidException.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/cvv/ChineChess/api/php-jwt-master/src/JWT.php';

use \Firebase\JWT\JWT;

$service_account_email = "best-giai-tri-9c837@appspot.gserviceaccount.com";
$privateKey = <<<EOD
-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQC4PfGqLbpNSKbw\nYEY5HjVEcIgXpTZnj6rAPlsPjej4+hMqPGj4KBnmlOPztqkTaGCI76UxjjOFHVVq\nS/iRbAR2nxYyN0v4hA2SRpw810Je2N/75ZlyTKuOjTaLr8vYjsf+QFOLilwOGrtU\nF2vpEre2r5CfwtUi3CYu4Ic94pNW+uqzvx8JhQ57V47KNU5u9gMlba9YDHnG5K21\niExemkTlqXbazeybVomGxDWcwFRm9HJQWckQrePEO7ajQrZ8Zz/llm5tqgSJhzEs\nPFD5T0xS3psTOq1GsWFl1tdny6k6Lad5zcix/wKC7k/RYgVlJ217Q/lH5WYxPzCj\nxZnyuUC7AgMBAAECggEAHIjqJ7TFsMLf/sUHwJXsoxPDXYIm2cWW/lz0poU7QBXJ\n0mtLyKS7/4naKjyv6q5qRnBzRyhifgCL4kGE7HpB0LYVQ87A/ervMn4BeazPKI3H\nVvtO7N8cskstrQHGUl0pcrfiGJpjuoLVC5JFvMc7hoL3emmRsBX6S0gBZN91eW1y\nGY2/oZAzkAZ4ZvV+lEZXYoyUSzTOOaVKllt6yLxOyJe7K6CPocuB5Q330I1P1Z/h\n761FyMxX8mS7+QAqY4FQfo+Fug97B+yuX2VjaEgzIQWuiy2BxNT/ET/SkpWvR8/J\nJYpARKjOv/fVq4W5TMAipAaGZD4suhp1FW0kUa6b8QKBgQDofG8PiLmMfhq1N6YJ\ndYz5DrzDDsdyPcrNndr2k5xe4sBkEMn8aZqE5M+Ei4LIYp05p3cABgBsICYn4rTa\neQhCeEA85GqiHU+qkHUcwcfmSPlEL6R8CWx8XDYcjEQQv8I+mf320RpMzWHiSJdh\nXGl9TMmKKBXuXBs+PjvvcTWkUQKBgQDK4F3DfsPA1bpOdUA96fbb1epX2QHfA75F\nI0GT8xMQFk82fk7UmPHaMBoj37+4jy625ibGP69trUGHsmfdy51FCI1XSCeaS16I\nCjt2Tg+3sOuGflSY7qTAKG4T1yoC5j9IK79Hjxcs9gDopaoHqsxwYI4aw9bkbrmP\nEeCaC4oNSwKBgH6AFr5RGwVDKK0qVoIXIFn0lulcBVI4JT20gwxgTVmj8COCryVV\nIOrmxbPNZaA7aGmSocG1gk1TQO+6/8VQzhm87Nc1QoBriom4iMDZADhhxKBBfDKx\nvgH8+sSV3gNvE/aUPAgsxy67ImPKM/SaIBw5yAAQx74nB/vaSSqEYzfBAoGAcSaC\nJS7mbv7FUk0C74U2MZY1hZl6+a9Ux6rKQIIp96b5tyLrRJepDFAXxDpe68iv/UKQ\nDbInXbxr+AsA8ytFI+OJMU0FCYFP0AAk+e6/xWvfcLu04zb2nFXwTxCKVeOlF9OO\nc5LTEjiCeT8sfeo869BucW8Yw38d7zXBVylobdECgYAO5sAAOQTZewG0HRYo91b+\nK5ndcC/l/iIlBH68xLaUEbFjJzoBWJ7RplZ7T0EiC3QdeIZx2URrhj/dFJqcZsdc\nQlcNvGeB4uMBk/rAcUXHaXyx1+iwuQfglVkkvVDiyJVbBLtMt4HWGQaO0CvVrEc3\nZmf6oUiAVAL16wEmhdKpEg==\n-----END PRIVATE KEY-----\n
EOD;

$publicKey = <<<EOD
-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQC8kGa1pSjbSYZVebtTRBLxBz5H
4i2p/llLCrEeQhta5kaQu/RnvuER4W8oDH3+3iuIYW4VQAzyqFpwuzjkDI+17t5t
0tyazyZ8JXw+KgXTxldMPEL95+qVhgXvwtihXC1c5oGbRlEDvDF6Sa53rcFVsYJ4
ehde/zUxo6UvS7UrBQIDAQAB
-----END PUBLIC KEY-----
EOD;

$now_seconds = time();
$payload = array(
    "iss" => $service_account_email,
    "sub" => $service_account_email,
    "aud" => "https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit",
    "iat" => $now_seconds,
    "exp" => $now_seconds+(60*60),  // Maximum expiration time is one hour
    "uid" => $_REQUEST['secret_key']
);
$jwt = JWT::encode($payload, $privateKey, 'RS256');
//if(isset($_REQUEST['_ga']))
//{
echo $jwt;
//}
?>