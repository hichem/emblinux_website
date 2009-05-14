<?php
	include("/usr/share/pear/XML/Unserializer.php");
	include('globals.php');
	
	$rtsolution = htmlspecialchars($_POST['cmb_rtsolution']);
	$kernel_version = htmlspecialchars($_POST['cmb_kernel_version']);
	$arch = htmlspecialchars($_POST['arch']);
	
	$preempt_rt_path = "$work_dir/tarballs";
	
	function get_prevsibling($node)
	{
		$x=$node->previousSibling;
		while ($x->nodeType!=1)
		{
			$x=$x->previousSibling;
		}
		return $x;
	}
		
	function get_nextsibling($node)
	{
		$x=$node->nextSibling;
		while ($x->nodeType!=1)
		{
			$x=$x->nextSibling;
		}
		return $x;
	}
	
	$patch_list = Array();
	//$rtsolution='xenomai';
	
	if($rtsolution == 'none')
	{
		return;
	}
	elseif($rtsolution == 'xenomai')
	{
		$xml = new DomDocument;
		$xml->load("$work_dir/xenomai-patches.xml");
		
		$i = 0;
		foreach($xml->getElementsByTagName('kernel') as $node)
		{
			$prev = get_prevsibling($node);
			if(($node->nodeValue == $kernel_version) && ($prev->nodeValue == $arch))
			{
				$patch_list[$i] = get_prevsibling($prev)->nodeValue;
				$i = $i + 1;
			}
		}
	}
	elseif($rtsolution == 'rtai')
	{
		$xml = new DomDocument;
		$xml->load("$work_dir/rtai-patches.xml");
		$i = 0;
		foreach($xml->getElementsByTagName('kernel') as $node)
		{
			$prev = get_prevsibling($node);
			if(($node->nodeValue == $kernel_version) && ($prev->nodeValue == $arch))
			{
				$patch_list[$i] = get_prevsibling($prev)->nodeValue;
				$i = $i + 1;
			}
		}
	}
	elseif($rtsolution == 'preempt-rt')
	{
		if($handle = opendir($preempt_rt_path))
		{
			$i = 0;
			while(($file = readdir($handle)) != false)
			{
				if(preg_match("/^patch-(\d+\.\d+\.\d+).*-rt.*/", $file, $matches))
				{
					if($matches[1] == $kernel_version)
					{
						$patch_list[$i] = $matches[0];
						$i = $i + 1;
					}
				}
			}
			closedir($handle);
		}
	}
	else
	{
		echo '<BR /><BR /><font size="+3">This RT patch does not match</font>';
		return;
	}
	
	if(count($patch_list) == 0)
	{
		echo 'Il n\'existe aucun patch qui correspond à cette version du noyau';
	}
	else
	{
		echo "<LABEL>Vous pouvez choisir parmi l'un des patches suivants.</LABEL><BR />";
		echo "<SELECT name=\"cmb_rtpatch\">";
		foreach($patch_list as $patch)
		{
		echo "<OPTION value=\"".$patch."\">".preg_replace('/(.*)(\/.+){4}\/(.*).patch/','$1-$3',$patch)."</OPTION>";
		}
		echo "</SELECT>";
	}
?>