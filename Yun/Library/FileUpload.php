<?php

/**
 * 文件上传类
 * ============================================================================
 * @author		jasoncai	2013-08-03	
 * @usage 		
		$fileUp = new fileUpload();
		$fileUp->filePath = 'YUN_ROOT';
		//$fileUp->FILES['image']['name'] = $newname.$fileUp->FILES['image']['ext'];
		$fileUp->uploadImg('image');
 * ============================================================================
 */
namespace Yun\Library;
Class FileUpload{
	public  $filePath;
	public  $imageType = array('image/gif','image/jpeg','image/pjpeg','image/png','image/bmp');
	public  $maxImageSize = 8388608;//8MB
	public  $maxFileSize = 2097152;//2MB
	public  $FILES = array();//已上传文件
	public function fileUpload($path=''){
		$this->filePath = $path;//上传路径
		//$this->maxImageSize = $this->maxFileSize = parsetobit(ini_get('upload_max_filesize'));//上传限制
		$this->FILES = $_FILES;
		foreach($this->FILES as $k=>$file){
			if(is_array($file&&!isset($file['name']))){
				//多个文件数组 TODO
			}else{
				$this->FILES[$k]['ext'] = '.'.$this->getExt($file['name']);
				$this->FILES[$k]['upResult'] = 0;
			}
		}
	}
	/**
	 * 获取扩展名 
	 *
	 * @param string Null
	 * @return string
	 */
	function getExt($filename){
		return end(explode('.', $filename));
	}
	/**
	 * 上传路径 
	 *
	 * @param string Null
	 * @return array
	 */
	function setRoot($path){
		$this->filePath = $path;
		
	}
	/**
	 * 上传限制 
	 *
	 * @param string Null
	 * @return array
	 */
	function setMaxFileSize($limit){
		$this->maxFileSize = $limit;
	}
	/**
	 * 图片上传限制 
	 *
	 * @param string Null
	 * @return array
	 */
	function setMaxImageSize($limit){
		$this->maxImageSize = $limit;
	}
	/**
	 * 图片上传 
	 *
	 * @param string Null
	 * @return array
	 */
	function uploadImg($filename){
		if(in_array($this->FILES[$filename]["type"],$this->imageType)){
			if($this->FILES[$filename]["size"] < $this->maxImageSize){
				return $this->upload($filename);
			}else{
				return false;
			}
		}else{
			return false;
		}

	}
	/**
	 * 文件上传 
	 *
	 * @param string Null
	 * @return array
	 */
	function upload($filename){
		if ($this->FILES[$filename]["error"] > 0)
		{
			return false;
		}
		else
		{	if(!file_exists($this->filePath)){
				if(mkdir($this->filePath,0777,true)==false){
					return false;
				}
			}
			if (file_exists($this->filePath . $this->FILES[$filename]["name"]))
			{
				@unlink($this->filePath . $this->FILES[$filename]["name"]);
			}
			$this->FILES[$filename]["upResult"]  =  move_uploaded_file($this->FILES[$filename]["tmp_name"],$this->filePath . $this->FILES[$filename]["name"]);
			return $this->FILES[$filename]["upResult"]; 
		}
	}
	/**
	 * 删除文件 
	 *
	 * @param string Null
	 * @return array
	 */
	function delete($filename){
		return @unlink($this->filePath . $filename);
	}
}