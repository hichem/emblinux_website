<?php
	session_start();
	include('globals.php');
	
	$user_name = $_SESSION['login'];
	if($user_name == '')
	{
		echo '<BR /><BR /><font size="+3">You must login to build toolchains</font>';
		return;
	}
	
	$toolchains_dir = "$work_dir/config-toolchains";
	$user_toolchains_dir = "$work_dir/user_toolchains";
	$toolchain_name = $_GET['toolchain'];	
	
	if( file_exists("$toolchains_dir/$toolchain_name.xml") )
	{
		$toolchain_name = "$toolchains_dir/$toolchain_name.xml";
	}
	elseif(file_exists("$user_toolchains_dir/$toolchain_name.xml"))
	{
		$toolchain_name = "$user_toolchains_dir/$toolchain_name.xml";
	}
	else
	{
		echo '<BR /><BR /><font size="+3">This page does not exist</font>';
		return;
	}
	
	/*Header("content-type: application/xml");
	$file = "arm-unknown-bare-metal-none.xml";
	$fp = fopen($file, "r");
	$return = fread($fp, filesize($file));
	fclose($fp);
	echo $return;*/
	
	$xmlfilename = $toolchain_name;
	$xsltfilename = "config.xsl";
	
	$xml = new DomDocument;
	$xml->load($xmlfilename);
		
	## Tag renaming
	$mapping = Array ('target_options' => 'Target Options', 'target_arch' => 'Target Architecture', 'target_variant' => 'Target Variant', 'abi' => 'ABI', 'float' => 'FPU', 'endiannes' => 'Endianness', 'toolchain_options' => 'Toolchain Options', 'build_shared_lib' => 'Build Shared Libraries', 'manufacturer' => 'Manufacturer', 'sysroot' => 'Sysroot', 'os' => 'Operating System', 'target_os' => 'Type', 'kernel_version' => 'Kernel Version', 'gmp_mpfr' => 'GMP-MPFR', 'use_gmp_mpfr' => 'Build GMP-MPFR', 'gmp_version' => 'GMP Version', 'mpfr_version' => 'MPFR Version', 'debug' => 'Debugging', 'gdb' => 'GDB', 'duma' => 'Duma', 'dmalloc' => 'Dmalloc', 'ltrace' => 'Ltrace', 'strace' => 'Strace', 'clib' => 'C Library', 'libc' => 'LIBC', 'clib_version' => 'Version', 'threading_lib' => 'Thread Model', 'cc' => 'C Compiler', 'gcc_version' => 'GCC Version', 'cpp' => 'CPP', 'fortran' => 'FORTRAN', 'java' => 'JAVA', 'binutils' => 'Binutils', 'libbfd' => 'Libbfd', 'libiberty' => 'Libiberty', 'binutils_version' => 'Version', 'tools' => 'Tools', 'libelf' => 'Libelf', 'sstrip' => 'Sstrip');
	
	foreach($mapping as $key => $value)
	{
		foreach($xml->getElementsByTagName($key) as $node)
		{
			$node->setAttribute("name", $value);
		}
	}
	
	$xsl = new DomDocument;
	$xsl->load($xsltfilename);
	
	$proc = new xsltprocessor;
	$proc->importStyleSheet($xsl);
	$result = $proc->transformToXML($xml); 
	?>
	<DIV>
		<H2>Configuration de la chaîne :<BR /><?php echo $_GET['toolchain'];?></H2>
	<?php
	print "$result";
	return;
?>
	</DIV>