Yii2 AWS SDK v3 wrapper
===


Installation
------------

```php
'components' => [
	'aws' => [
		'class' => 'punjabistudios\aws\BaseAws',
		//required config
		'region' => 'your_region',
		//optional config
		'key' => 'your_key',
		'secret' => 'your_secret',
		'version' => 'latest',
		//additional config
		'options' => [
			'scheme' => 'http',
		],
		// optional config file
		//'configFile' => require_once('/path/to/aws.config.php'),
	]
]
```
See additional aws configuration [here](http://docs.aws.amazon.com/aws-sdk-php/v3/guide/guide/configuration.html)


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
/* @var $aws \punjabistudios\aws\AwsSdk */
$aws = \Yii::$app->aws;
$dynamoDbClient = $aws->createDynamoDb();
...
$s3Client = $aws->createS3();
$result = $s3Client->listObjects(['Bucket' => 'my-bucket'])->toArray();
//get the last object
$object = end($result['Contents']);
$key = $object['Key'];
$file = $s3Client->getObject([
  'Bucket' => 'my-bucket',
  'Key' => $key
]);

//download file
header('Content-Type: ' . $file['ContentType']);
echo $file['Body'];

```

