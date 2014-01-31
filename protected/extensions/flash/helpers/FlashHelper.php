<?php

class FlashHelper
{
	function convertVideoToFlv($srcFile, $destFile = null, $srcWidth = null, $srcHeight = null)
	{
		// Set our source file
		$ffmpegPath = "ffmpeg";
		$flvtool2Path = "flvtool2";
		if($destFile === null)
			$destFile = $srcFile;
		$destFile = substr($destFile, 0, strpos($destFile, '.')).'.flv';
		// Create our FFMPEG-PHP class
		$ffmpegObj = new ffmpeg_movie($srcFile);
		// Save our needed variables
		if(!$srcWidth)
			$srcWidth = self::makeMultipleTwo($ffmpegObj->getFrameWidth());
		if(!$srcHeight)
			$srcHeight = self::makeMultipleTwo($ffmpegObj->getFrameHeight());
		$srcFPS = $ffmpegObj->getFrameRate();
		$srcAB = intval($ffmpegObj->getAudioBitRate()/1000);
		if(!$srcAB)
			$srcAB = 32;
		//var_dump($srcAB);
		//exit;
		//$srcAR = $ffmpegObj->getAudioSampleRate();
		if(!$srcAR)
			$srcAR = 44100;
		// Call our convert using exec()
		$command = $ffmpegPath . " -i " . $srcFile . " -ar " . $srcAR . " -ab " . $srcAB . " -f flv -s " . $srcWidth . "x" . $srcHeight . " " . $destFile;/*. " | " . $flvtool2Path . " -U stdin " . $destFile;*/
		shell_exec($command);
		return is_file($destFile)? $destFile : false;
		///
		/*$outfile = "";
		$size = $width."x".$height;
		$outfile = substr($filePath, 0, strpos($filePath, '.')).'.'.$extension;
		$ffmpegcmd1 = "/usr/local/bin/ffmpeg -i {$filePath} -ar {$samplingrate} -ab {$bitrate} -f {$extension} -s {$size} {$outputPath}/{$outfile}";
		$ret = shell_exec($ffmpegcmd1);
		return $ret;*/
	}
	
	function makeMultipleTwo($value)
	{
		$sType = gettype($value/2);
		if($sType == "integer")
		{
			return $value;
		} else {
			return ($value-1);
		}
	}
}