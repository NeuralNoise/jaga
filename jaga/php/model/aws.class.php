<?php

class AWS {
	
	private $sharedConfig;

	public function __construct() {
		
		$this->sharedConfig = [
			'region'  => 'us-west-2',
			'version' => 'latest',
			'credentials' => [
				'key'    => Config::read('aws.key'),
				'secret' => Config::read('aws.secret'),
			]
		];

	}
	
	public function uploadImageToS3($bucket,$key,$sourceFile,$contentType,$imageObject,$imageObjectID) {

		$sdk = new Aws\Sdk($this->sharedConfig);
		$s3 = $sdk->createS3();
		$result = $s3->putObject(array(
			'Bucket'       => $bucket,
			'Key'          => $key,
			'SourceFile'   => $sourceFile,
			'ContentType'  => $contentType,
			'ACL'          => 'public-read',
			'Metadata'     => array(    
				'channel-id' => $_SESSION['channelID'],
				'channel-key' => $_SESSION['channelKey'],
				'userID' => $_SESSION['userID'],
				'image-object' => $imageObject,
				'image-object-id' => $imageObjectID,
				'datetime' => date('Y-m-d H:i:s'),
			)
		));
		
		return $result['ObjectURL'];

	}
	
	
}


?>