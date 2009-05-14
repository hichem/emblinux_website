<?php
	session_start();
	include('globals.php');
?>
<SCRIPT language="JavaScript">
	function swap_gmp_mpfr()
	{
		if(document.form1.chk_gmp_mpfr.checked)
		{
			document.form1.cmb_gmp.disabled="";
			document.form1.cmb_mpfr.disabled="";
		}
		else
		{
			document.form1.cmb_gmp.disabled="disabled";
			document.form1.cmb_mpfr.disabled="disabled";
		}
	}
	function send_request(data, page, method, id)
	{
		//alert('ok');
		if (window.ActiveXObject)
		{
			//Internet Explorer
			var XhrObj = new ActiveXObject("Microsoft.XMLHTTP") ;
		}
		else
		{
			var XhrObj = new XMLHttpRequest();
		}
		
		//définition de l'endroit d'affichage:
		var content = document.getElementById(id);
		
		//Ouverture du fichier en methode POST
		XhrObj.open(method, page);
		
		//Ok pour la page cible
		XhrObj.onreadystatechange = function()
		{
			if (XhrObj.readyState == 4 && XhrObj.status == 200)
				content.innerHTML = XhrObj.responseText;
		}
		
		XhrObj.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		XhrObj.send(data);
	}
	function req_os(){
	send_request('cmb_os='+document.form1.cmb_os.value,'toolchain_deps.php', 'post', 'async_os');
	}
	function req_clib(){
		send_request('cmb_clib='+document.form1.cmb_clib.value,'toolchain_deps.php', 'post', 'async_libc_version');
	}
	function req_variant(){
		send_request('cmb_arch='+document.form1.cmb_arch.value,'async_variant.php', 'post', 'async_variant');
	}
	window.onload = function(){
		req_os();
		req_clib();
	}
</SCRIPT>
<DIV id="toolchain_config" class="corps">
	<FORM name="form1" method="POST" action="index.php?page=build_toolchain">		
		<DIV id="arch">
			<H2>Configuration d'une chaine de compilation croisée</H2>
			<H3>Options de la cible</H3>
			<LABEL>Architecture : </LABEL>
			<SELECT name="cmb_arch" onchange="req_variant()">
				<OPTION selected="selected" value="arm">arm</OPTION>
				<OPTION value="alpha">alpha</OPTION>
				<OPTION value="mips">mips</OPTION>
				<OPTION value="powerpc">powerpc</OPTION>
				<OPTION value="x86">x86</OPTION>
				<OPTION value="x86_64">x86_64</OPTION>
			</SELECT><BR />
			<SPAN id="async_variant">
			</SPAN>
			<LABEL>Application Binary Interface</LABEL>
			<INPUT type="radio" name="rd_abi" value="none">None
			<INPUT type="radio" name="rd_abi" value="abi" checked>Abi
			<INPUT type="radio" name="rd_abi" value="eabi">Eabi<BR />
			<LABEL>Endiannes </LABEL>
			<SELECT name="cmb_endian">
				<OPTION selected="selected" value="none">none</OPTION>
				<OPTION value="big">big</OPTION>
				<OPTION value="little">little</OPTION>
			</SELECT>
			<BR>
			<LABEL>Virgule flottante</LABEL>
			<SELECT name="cmb_float">
				<OPTION selected="selected" value="software">software</OPTION>
				<OPTION value="hardware">hardware</OPTION>
			</SELECT>
	  	</DIV>
		<DIV id="os">
			<H3>Système d'exploitation</H2>
			<LABEL>Système d'exploitation de la cible</LABEL>
			<SELECT name="cmb_os" onchange="req_os();">
				<OPTION selected="selected" value="linux">linux</OPTION>
				<OPTION value="bare-metal">bare-metal</OPTION>
			</SELECT>
			<BR>
			<SPAN id="async_os">
			</SPAN>
		</SPAN>
		<DIV id="toolchain_options">
			<H3>Options de la chaine de compilation</H2>
			<INPUT type="checkbox" name="chk_sysroot" value="yes">Use sysroot'ed toolchain<BR />
			<INPUT type="checkbox" name="chk_build_shared_lib" value="yes">Build shared libraries<BR />			
		</DIV>
		<DIV id="gmp_mpfr">
			<H3>GMP/MPFR</H2>
			<INPUT type="checkbox" name="chk_gmp_mpfr" value="yes" checked="true" onclick="swap_gmp_mpfr();">Utiliser GMP/MPFR<BR />
			<LABEL>Version de GMP :</LABEL>
			<SELECT name="cmb_gmp">
				<OPTION selected="selected" value="4.2.4">4.2.4</OPTION>
				<OPTION value="4.2.2">4.2.2</OPTION>
			</SELECT>
      			<BR />
			<LABEL>Version de MPFR :</LABEL>
      			<SELECT name="cmb_mpfr">
				<OPTION selected="selected" value="2.3.2">2.3.2</OPTION>
				<OPTION value="2.3.1">2.3.1</OPTION>
			</SELECT>
      			<BR />
    		</DIV>
		<DIV id="binutils">
			<H3>Binutils</H2>
			<LABEL>Version de Binutils </LABEL>
			<SELECT name="cmb_binutils">
				<OPTION selected="selected" value="2.19">2.19</OPTION>
				<OPTION value="2.18">2.18</OPTION>
				<OPTION value="2.17">2.17</OPTION>
				<OPTION value="2.16.1">2.16.1</OPTION>
			</SELECT><BR />
			<INPUT type="checkbox" name="chk_libbfd" value="yes">libbfd<BR />
			<INPUT type="checkbox" name="chk_libiberty" value="yes">libiberty<BR />
		</DIV>
		<DIV id="cc">
			<H3>Compilateur C</H2>
			<LABEL>Version de gcc </LABEL>
			<SELECT name="cmb_cc">
				<OPTION selected="selected" value="4.3.2">4.3.2</OPTION>
				<OPTION value="4.3.1">4.3.1</OPTION>
				<OPTION value="4.2.4">4.2.4</OPTION>
				<OPTION value="4.2.3">4.2.3</OPTION>
				<OPTION value="4.2.2">4.2.2</OPTION>
				<OPTION value="4.2.1">4.2.1</OPTION>
				<OPTION value="4.2.0">4.2.0</OPTION>
				<OPTION value="4.1.2">4.1.2</OPTION>
				<OPTION value="4.0.4">4.0.4</OPTION>
			</SELECT><BR />
			<INPUT type="checkbox" name="chk_cpp" checked="true" value="yes">C++<BR />
			<INPUT type="checkbox" name="chk_fortran" checked="true" value="yes">Fortran<BR />
			<INPUT type="checkbox" name="chk_java" checked="true" value="yes">Java<BR />
		</DIV>
      		<DIV id="clib">
			<H3>Bibliothèque C</H2>
			<LABEL>Bibliothèque C à utiliser </LABEL>
			<SELECT id="sel_clib" name="cmb_clib" onchange="req_clib();">
				<OPTION selected="selected">glibc</OPTION>
				<OPTION>uClibc</OPTION>
				<OPTION>eglibc</OPTION>
				<OPTION>none</OPTION>
			</SELECT><BR />
			<SPAN id="async_libc_version">
			</SPAN><BR />
			<LABEL>Bibliothèque de Threads</LABEL><BR />
			<SELECT name="cmb_thread">
				<OPTION>none</OPTION>
				<OPTION>linuxthreads</OPTION>
				<OPTION>nptl</OPTION>
			</SELECT>
		</DIV>
		<DIV id="tools">
			<H3>Autres outils</H2>
			<INPUT type="checkbox" name="chk_libelf" checked="true" value="yes">libelf<BR />
			<INPUT type="checkbox" name="chk_sstrip" checked="true" value="yes">sstrip<BR />
		</DIV>
		<DIV id="debug">
			<H3>Déboggage</H2>
			<INPUT type="checkbox" name="chk_gdb" checked="true" value="yes">GDB<BR />
			<INPUT type="checkbox" name="chk_dmalloc" checked="true" value="yes">Dmalloc<BR />
			<INPUT type="checkbox" name="chk_duma" checked="true" value="yes">Duma<BR />
			<INPUT type="checkbox" name="chk_ltrace" checked="true" value="yes">ltrace<BR />
			<INPUT type="checkbox" name="chk_strace" checked="true" value="yes">strace<BR />
		</DIV>
		<BR />
		<INPUT type="submit" value="Valider">
		<INPUT type="reset" value="Annuler" onclick="window.location='index.php';">
	</FORM>
</DIV>

