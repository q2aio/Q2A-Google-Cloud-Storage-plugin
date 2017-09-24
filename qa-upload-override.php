<?php
use Google\Cloud\Storage\StorageClient;

function qa_create_blob($content, $format, $sourcefilename=null, $userid=null, $cookieid=null, $ip=null)
/*
	Create a new blob (storing the content in the database or on disk as appropriate) with $content and $format, returning its blobid.
	Pass the original name of the file uploaded in $sourcefilename and the $userid, $cookieid and $ip of the user creating it
*/
	{
		require QA_PLUGIN_DIR.'q2a-google-cloud-storage-uploader-plugin/vendor/autoload.php';

		$blobid=get_just_a_file_name($sourcefilename) . '.' .$format;
				
		if(qa_opt('gcs_api_on')){
				putenv('GOOGLE_APPLICATION_CREDENTIALS='.qa_opt('gcs_api_key_location'));
				$storage = new StorageClient([
						'projectId' => qa_opt('gcs_project_id')
				]);
				$bucket = $storage->bucket(qa_opt('gcs_bucket_name'));
				$options = [
								'predefinedAcl' => 'publicRead',
						'name' => $blobid
					];
				$bucket->upload(
						$content,
						$options
				);
				return $blobid;
		}
		return qa_create_blob_base($content, $format, $sourcefilename, $userid, $cookieid, $ip);
  }
  
  function get_just_a_file_name($sourcefilename){
	$filename = $sourcefilename;
	$date = new DateTime();

	$filename = (explode(".",trim($sourcefilename))[0]).'-'.$date->getTimestamp();

	$filename = str_replace(" ","-",$filename);

	return $filename;
  }

  function qa_get_blob_url($blobid, $absolute=false)
  /*
    Return the URL which will output $blobid from the database when requested, $absolute or relative
  */
    {
     	if(qa_opt('gcs_api_on')){
				return 'https://storage.googleapis.com/'.qa_opt('gcs_bucket_name').'/'.$blobid;
		}
		return qa_get_blob_url_base($blobid, $absolute);
	}
  
