<?php
	session_start();
	include('globals.php');
	include ($xml_serializer);
     	include ('ToolchainClasses.php');
	
  	$user_name = $_SESSION['login'];

	if($user_name == '')
	{
		echo '<BR /><BR /><font size="+3">You must login to build toolchains</font>';
		return;
	}
     
     	$serializer = new XML_Serializer();
     
     	$config = new ToolchainConfig;
	$chkboxes = Array('chk_sysroot', 'chk_build_shared_lib', 'chk_gmp_mpfr', 'chk_libbfd', 'chk_libiberty', 'chk_cpp', 'chk_fortran', 'chk_java', 'chk_libelf', 'chk_sstrip', 'chk_gdb', 'chk_dmalloc', 'chk_duma', 'chk_ltrace', 'chk_strace');
	
	for($i=0; $i< count($chkboxes);$i++)
	{
		if(! isset($_POST[$chkboxes[$i]]))
		{
			$_POST[$chkboxes[$i]]='no';
		}
	}
	
	if(! isset($_POST['cmb_variant']))
	{
		$_POST['cmb_variant'] = 'none';
	}
	
	if(! isset($_POST['cmb_kernel_version']))
	{
		$_POST['cmb_kernel_version'] = '';
	}
	
	if(! isset($_POST['cmb_clib_version']))
	{
		$_POST['cmb_clib_version'] = '';
	}
	
	$libc_version = $_POST['cmb_'.$_POST['cmb_clib'].'_version'];
     	$config->set_target_options($_POST['cmb_arch'], $_POST['cmb_variant'], $_POST['rd_abi'], $_POST['cmb_endian'], $_POST['cmb_float']);
     	$config->set_toolchain_options($_POST['chk_sysroot'], $_POST['chk_build_shared_lib'], 'unknown');
     	$config->set_os($_POST['cmb_os'], $_POST['cmb_kernel_version']);
     	$config->set_gmp_mpfr($_POST['chk_gmp_mpfr'], $_POST['cmb_gmp'], $_POST['cmb_mpfr']);
     	$config->set_binutils($_POST['cmb_binutils'], $_POST['chk_libbfd'], $_POST['chk_libiberty']);
     	$config->set_cc($_POST['cmb_cc'], $_POST['chk_cpp'], $_POST['chk_fortran'], $_POST['chk_java']);
     	$config->set_clib($_POST['cmb_clib'], $libc_version,$_POST['cmb_thread']);
     	$config->set_tools($_POST['chk_libelf'], $_POST['chk_sstrip']);
     	$config->set_debug($_POST['chk_gdb'], $_POST['chk_dmalloc'], $_POST['chk_duma'], $_POST['chk_ltrace'], $_POST['chk_strace']);

	// add XML declaration
     	//$serializer->setOption("addDecl", true);

	// indent elements
     	$serializer->setOption("indent", "    ");

	// set name for root element
     	$serializer->setOption("rootName", "ToolchainConfig"); 
	$serializer->setOption("classAsTagName", "true");
     	$serializer->serialize($config);
     	//print $serializer->getSerializedData();
     	
     	// Giving the toolchain configuration file name
	$manufacturer = 'unknown';
	$arch = $_POST['cmb_arch'];
	$variant = $_POST['cmb_variant'];
	$endianness = $_POST['cmb_endian'];
	$abi = $_POST['rd_abi'];
	$libc = $_POST['cmb_clib'];
	
	/////////////////////////////////////////////////////////////////////
	// The architecture part of the toolchain tuple
	if($arch == 'x86')
	{
		$arch = $variant;
		if($variant == 'winchip*')
		{
			$arch = 'i486';
		}
		elseif(($variant == 'pentium')||($variant == 'pentium-mmx')||($variant == 'c3*'))
		{
			$arch = 'i586';
		}
		elseif(($variant == 'pentiumpro')||($variant == 'pentium*')||($variant == 'athlon*'))
		{
			$arch = 'i686';
		}
	}
	elseif ($arch == 'arm')
	{
		if($endianness == 'big')
		{
			$arch = "$arch" . "eb";
		}
	}
	elseif($arch == 'alpha')
	{
		$arch = "$arch" . "$variant";
	}
	elseif($arch == 'mips')
	{
		if($endianness == 'little')
		{
			$arch = "$arch" . "el";
		}
	}
	elseif($arch == 'sh')
	{
		$arch = $variant;
		if($endianness == 'big')
		{
			$arch = "$arch" . "eb";
		}
	}
	
	///////////////////////////////////////////////////////////////////////
	// The kernel part of the toolchain tuple
	if($_POST['cmb_os']=='linux')
	{
		$kernel = 'linux';
	}
	else
	{
		$kernel = '';
	}
	
	////////////////////////////////////////////////////////////////////////
	// The OS part of the tuple
	if(($lib == 'glibc')||($lib == 'eglibc'))
	{
		$os = 'gnu';
	}
	elseif ($lib == 'uClibc')
	{
		$os='uclibc';
	}
	else
	{
		$os = 'elf';
	}
	
	if((preg_match('/arm.*/',$arch)&&($abi == 'eabi'))
	{
		if($libc == 'uClibc')
		{
			$os = "$os" . "gnueabi";
		}
		elseif($lib == 'none')
		{
			$os = "eabi";
		}
		else
		{
			$os = "$os" . "eabi";
		}
	}

	
	$config_dir = "$home/$user_name/mytoolchains/";
	if($kernel == '')
	{
		$filename = $config_dir.$arch.'-'.$manufacturer.'-'.$os.'.xml';
		$toolchain_name = $arch.'-'.$manufacturer.'-'.$os;
	}
	else
	{
		$filename = $config_dir.$arch.'-'.$manufacturer.'-'.$kernel.'-'.$os.'.xml';
		$toolchain_name = $arch.'-'.$manufacturer.'-'.$kernel.'-'.$os;
	}
	
     	if (!$handle = fopen($filename, 'w'))
     	{ 
     		print "Cannot open file ($filename)";
     		exit;
     	}
	
	// Adding the XML and XSL header
	$xml_header = "<?xml version='1.0'?>\n";
	/*$xsl_header = "<?xml-stylesheet type=\"text/xsl\" href=\"config.xsl\"?>\n";*/
	if (!fwrite($handle, $xml_header)) 
	{
		print "Cannot write to file ($filename)";
		exit;
	}
	
	// XSL no declared inside the XML file since it is associated with it when building a DOM Document
	/*if (!fwrite($handle, $xsl_header)) 
	{
		print "Cannot write to file ($filename)";
		exit;
	}*/
	
     	// write XML to file
     	if (!fwrite($handle, $serializer->getSerializedData())) 
	{
		print "Cannot write to file ($filename)";
		exit;
	}

	// close file    
	fclose($handle);
	
	// Envoi de la commande de génération de la chaine
	$task_pid = system("$ts $perl $work_dir/build_toolchain.pl $filename $user_name &");
	
	mysql_connect($mysql_server,$mysql_user,$mysql_passwd) or die(mysql_error());	
	mysql_select_db($mysql_db) or die(mysql_error());
	$usr_id = $_SESSION['usr_id'];
	mysql_query("insert into toolchain values ('','".$usr_id."','".$toolchain_name."','En attente','".date("d-m-y")."','','".$task_pid."')") or die (mysql_error());
	mysql_close() or die(mysql_error());
	
	echo 'Votre commande a été transmise. Vous serez notifié lorsque elle sera prete<BR />';
	echo 'Cliquez <A href="index.php?page=mytoolchains">ici</A> pour voir l\'état de vos commandes';
?>
