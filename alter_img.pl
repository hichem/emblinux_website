#!/usr/bin/perl


## Howto
##
##	
##
#########


if($#ARGV < 0)
{
	die 'Wrong parameters';
}

foreach $file (@ARGV)
{
	$absfile = `readlink -f $file`;

	my $sed = "sed -i '";

	$sed = "$sed" . "s,session_start();," .
						"session_start();\\n" .
						"include(\"\\.\\./globals.php\");\\n" . 
						"\$user_name=\$_SESSION[\"login\"];\\n" .
						"if(\$user_name == \"\")\\n" . 
						"{\\techo \"You must login to view this content\";\\n\\treturn;\\n}\\n" . 
						"\$project_name = \$_GET[\"project\"];,;";
	$sed = "$sed" . "s,\\(include (\"\\)\\(.*jpgraph\\.php\\)\");,\\1\\.\\./\\2\");,;";
	$sed = "$sed" . "s,\\(include (\"\\)\\(.*jpgraph_bar\\.php\\)\");,\\1\\.\\./\\2\");,;";
	$sed = "$sed" . "s,\\(include (\"\\)\\(.*jpgraph_mgraph\\.php\\)\");,\\1\\.\\./\\2\");,;";
	$sed = "$sed" . "s,\$myvar= \$_SESSION.*;,,;";
	$sed = "$sed" . "s,\$rep = \$myvar.\"/\".\$_SESSION.*;,\$rep=\"\$home/\$user_name/projects/\$project_name\";,;";

	$sed = "$sed" . "s,\\(\$url.\$i.=\\)\\(.*xml\"\\);,if(file_exists(\\2))\\n" . 
									"\\t\\t\\t{\\n\\t\\t\\t\\1\\2;,;";
	$sed = "$sed" . "s,\$i=\$i+1;,\$i=\$i+1;},;";
	$sed = "$sed" . "s,fond\\.png,\\.\\./fond\\.png,";
	
	$sed = "$sed" . "' $absfile";
	
	#print "$sed\n";

	system($sed);
}
