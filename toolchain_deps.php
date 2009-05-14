<?php
	if(isset($_POST['cmb_os']) && ($_POST['cmb_os'] == 'linux'))
	{
		echo "<LABEL>Version du noyau Linux</LABEL>
		<SELECT name=\"cmb_kernel_version\">
		<OPTION selected\"selected\">2.6.26.8</OPTION>
		<OPTION>2.6.26</OPTION>
		<OPTION>2.6.26.1</OPTION>
		<OPTION>2.6.26.2</OPTION>
		<OPTION>2.6.26.3</OPTION>
		<OPTION>2.6.26.4</OPTION>
		<OPTION>2.6.26.5</OPTION>
		<OPTION>2.6.26.6</OPTION>
		<OPTION>2.6.26.7</OPTION>
		<OPTION>2.6.26.8</OPTION>
		<OPTION>2.6.27</OPTION>
		<OPTION>2.6.27.1</OPTION>
		<OPTION>2.6.27.2</OPTION>
		<OPTION>2.6.27.3</OPTION>
		<OPTION>2.6.27.4</OPTION>
		<OPTION>2.6.27.5</OPTION>
		<OPTION>2.6.27.6</OPTION>
		</SELECT>";
		return;
	}
	elseif(isset($_POST['cmb_clib']))
	{
		$libc = $_POST['cmb_clib'];
		if($libc == 'glibc')
		{
			echo "
			<LABEL>Version :</LABEL>
			<SELECT name=\"cmb_glibc_version\">
			<OPTION selected=\"selected\">2.7</OPTION>
			<OPTION>2.6.1</OPTION>
			<OPTION>2.6</OPTION>
			<OPTION>2.5.1</OPTION>
			<OPTION>2.5</OPTION>
			</SELECT><BR />";
			return;
		}
		elseif($libc == 'uClibc')
		{
			echo "
			<LABEL>Version :</LABEL>
			<SELECT name=\"cmb_uclibc_version\">
			<OPTION selected=\"selected\">0.9.28.3</OPTION>
			<OPTION>0.9.29</OPTION>
			<OPTION>0.9.30</OPTION>
			</SELECT><BR />";
		}
		elseif($libc == 'eglibc')
		{
			echo "
			<LABEL>Version :</LABEL>
			";
		}
		elseif($libc == 'none')
		{
		}
	}
?>