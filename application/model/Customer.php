<?php 

/**
* 
*/
class Customer extends SORM
{
	
	public function isSalaryGT($value)
	{
		if($this->Salary > $value){
			return true;
		}
		return false;
	}
	
}