<?php
	session_start();
	
	function isAdmin()
	{
		if( $_SESSION['role'] === 'administrator' )
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function isSupervisor()
	{
		if( $_SESSION['role'] === 'supervisor' )
		{
			return true;
		}
		else
		{
			return isAdmin();
		}
	}
	
	function isGuarantor()
	{
		if( $_SESSION['role'] === 'guarantor' )
		{
			return true;
		}
		else
		{
			return isSupervisor();
		}
	}

	function isLector()
	{
		if( $_SESSION['role'] === 'lector' )
		{
			return true;
		}
		else
		{
			return isGuarantor();
		}
	}
	
	function isStudent()
	{
		if( $_SESSION['role'] === 'student' )
		{
			return true;
		}
		else
		{
			return isLector();
		}
	}
?>