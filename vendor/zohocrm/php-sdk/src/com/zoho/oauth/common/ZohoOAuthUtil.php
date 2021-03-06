<?php
require_once 'OAuthLogger.php';
class ZohoOAuthUtil
{
	public static function getFileContentAsMap($fileHandler, $env = false)
	{
		$reponseMap=array();
		if($env){
				$reponseMap = config('laravelzohocrm');
				return $reponseMap;
		}

		try{
			while(!feof($fileHandler))
			{
				$line=fgets($fileHandler);
				$lineAfterSplit=explode("=",$line);
				if(strpos($lineAfterSplit[0],"#")===false)
				{
					$reponseMap[trim($lineAfterSplit[0])]=trim($lineAfterSplit[1]);

				}
			}

			fclose($fileHandler);
		}
		catch (Exception $ex)
		{
			OAuthLogger::warn("Exception occured while converting file content as map (file::ZohoOAuthUtil.php)");
		}

		return $reponseMap;
	}
}
?>
