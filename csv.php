<?php
class CSV{
	 const read=1;
	 const write=2;
	 const append=4;
	 var $file_data=null;
	 var $mode=1;
	 function __construct($fname,$mode=1){
	 	switch($mode){
	 		case CSV::read:{
	 			 $this->file_data=fopen($fname,"r");
	 			 break;
	 		}
	 		 case CSV::write:{
	 			 $this->file_data=fopen($fname,"w");
	 		$this->mode=CSV::write;	
	 			 break;
	 		}
	 		 case CSV::append:{
	 			 $this->file_data=fopen($fname,"a");
	 			 $this->mode=CSV::append;
	 		}
			case CSV::write|CSV::read:{
				 $this->file_data=fopen($fname,"r+");
				 $this->mode=CSV::write|CSV::read;
				 break;
			}
			case CSV::append|CSV::read:{
				$this->file_data=fopen($fname,"a+");
				$this->mode=CSV::append|CSV::read;
				break;
			}
	 	}
	 	}
	 	function is_open(){
	 		return is_resource($this->file_data);
	 	}
	function read(){
		if($this->mode!=CSV::read&&$this->mode!=(CSV::write|CSV::read)&&$this->mode!=(CSV::append|CSV::read)) throw new BadFunctionCallException("File not open for reading");
		$data=array();
		while(! feof($this->file_data)){
			$val=fgetcsv($this->file_data);
			if($val)
				$data[]=$val;
		}
		return $data;
	}
	 	 function read_line(){
	 		if($this->mode!=CSV::read&&$this->mode!=(CSV::write|CSV::read)&&$this->mode!=(CSV::append|CSV::read)) throw new BadFunctionCallException("File not open for reading");
			if(! feof($this->file_data)){
				return fgetcsv($this->file_data);
			}
	 	else return null;
	 	}
	 	function write_line(array $data){
	 		 if($this->mode!=CSV::write&&$this->mode!=(CSV::write|CSV::read)&&$this->mode!=CSV::append&&$this->mode!=(CSV::append|CSV::read)) throw new BadFunctionCallException("File not open for Writing");
	 		 if(!empty($data))
	 		 fputcsv ( $this->file_data , $data );
	 	}
	 	 function write(array $data){
	 		 if($this->mode!=CSV::write&&$this->mode!=(CSV::write|CSV::read)&&$this->mode!=CSV::append&&$this->mode!=(CSV::append|CSV::read)) throw new BadFunctionCallException("File not open for Writing");
	 		 foreach($data as $value)
	 		 fputcsv ( $this->file_data , $data );
	 	}
	 	 function append_line(array $data){
	 		 if($this->mode!=CSV::append&&$this->mode!=(CSV::append|CSV::read)) 
				 throw new Exception("File not open for Appending");
	 		 if(!empty($data))
	 		 fputcsv ( $this->file_data , $data );
	 	}
	 	 function append(array $data){
	 		 if($this->mode!=CSV::append&&$this->mode!=(CSV::append|CSV::read)) 
				 throw new Exception("File not open for Appending");
	 		 foreach($data as $value)
			 if(is_array($value))
				fputcsv ( $this->file_data , $value );
			else throw new Exception("Expecting Multidimensional array");
	 	}
		function get_file(){
			return $this->file_data;
		}
		function get_pos(){
			return ftell($this->file_data);
		}
		function set_pos($pos){
			fseek($this->file_data,$pos);
		}
		function start(){
			fseek( $this->file_data, 0 ,SEEK_SET);
		}
		function end(){
			fseek( $this->file_data, 0 ,SEEK_END);
		}
	 	function close(){
	 		if( !is_resource($this->file_data ))
	 		fclose($this->file_data);
	 	}
		function __destruct(){
			$this->close();
		}
	 	
}
?>