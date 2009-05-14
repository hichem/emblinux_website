<?php
     class TargetOptions
     {
	var $target_arch = '';
	var $target_variant = '';
	var $abi = '';
	var $endiannes = '';
	var $float = '';
     }
     
     class ToolchainOptions
     {
	var $sysroot = '';
	var $build_shared_lib = '';
	var $manufacturer = '';
     }
     
     class OS
     {
	var $target_os = '';
	var $kernel_version = '';	
     }
     
     class GMP_MPFR
     {
	var $use_gmp_mpfr = '';
	var $gmp_version = '';
	var $mpfr_version = '';
     }
     
     class Binutils
     {
	var $binutils_version = '';
	var $libiberty = '';
	var $libbfd = '';
     }
     
     class CC
     {
	var $gcc_version = '';
	var $cpp = '';
	var $fortran = '';
	var $java = '';
     }
     
     class Clib
     {
	var $libc = '';
	var $clib_version = '';
	var $threading_lib = '';
     }
     
     class Tools
     {
	var $libelf = '';
	var $sstrip = '';
     }
     
     class Debug
     {
	var $gdb = '';
	var $dmalloc = '';
	var $duma = '';
	var $ltrace = '';
	var $strace = '';
     }
     
     class ToolchainConfig
     {
	var $target_options;
	var $toolchain_options;
	var $os;
	var $gmp_mpfr;
	var $binutils;
	var $cc;
	var $clib;
	var $tools;
	var $debug;
     
	public function __construct() 
	{
		$target_options = new TargetOptions;
		$toolchain_options = new ToolchainOptions;
		$os = new OS;
		$gmp_mpfr = new GMP_MPFR;
		$binutils = new Binutils;
		$cc = new CC;
		$clib = new Clib;
		$tools = new Tools;
		$debug = new Debug;
	} 
     
	function set_target_options($target_arch, $target_variant, $abi, $endiannes, $float)
	{
		$this->target_options->target_arch = $target_arch;
		$this->target_options->target_variant = $target_variant;
		$this->target_options->abi = $abi;
		$this->target_options->endiannes = $endiannes;
		$this->target_options->float = $float;
	}
	
	function set_toolchain_options($sysroot, $build_shared_lib, $manufacturer)
	{
		$this->toolchain_options->sysroot = $sysroot;
		$this->toolchain_options->build_shared_lib = $build_shared_lib;
		$this->toolchain_options->manufacturer = $manufacturer;
	}
	
	function set_os ($target_os, $kernel_version)
	{
		$this->os->target_os = $target_os;
		$this->os->kernel_version = $kernel_version;
	}
	
	function set_gmp_mpfr($use_gmp_mpfr, $gmp_version, $mpfr_version)
	{
		$this->gmp_mpfr->use_gmp_mpfr = $use_gmp_mpfr;
		$this->gmp_mpfr->gmp_version = $gmp_version;
		$this->gmp_mpfr->mpfr_version = $mpfr_version;
	}
	
	function set_binutils($version, $libbfd, $libiberty)
	{
		$this->binutils->binutils_version = $version;
		$this->binutils->libbfd = $libbfd;
		$this->binutils->libiberty = $libiberty;
	}
	
	function set_cc($gcc_version, $cpp, $fortran, $java)
	{
		$this->cc->gcc_version = $gcc_version;
		$this->cc->cpp = $cpp;
		$this->cc->fortran = $fortran;
		$this->cc->java = $java;
	}
	
	function set_clib($clib, $clib_version, $threading_lib)
	{
		$this->clib->libc = $clib;
		$this->clib->clib_version = $clib_version;
		$this->clib->threading_lib = $threading_lib;
	}
	
	function set_tools($libelf, $sstrip)
	{
		$this->tools->libelf = $libelf;
		$this->tools->sstrip = $sstrip;
	}

	function set_debug($gdb, $dmalloc, $duma, $ltrace, $strace)
	{
		$this->debug->gdb = $gdb;
		$this->debug->dmalloc = $dmalloc;
		$this->debug->duma = $duma;
		$this->debug->ltrace = $ltrace;
		$this->debug->strace = $strace;
	}
}
?>