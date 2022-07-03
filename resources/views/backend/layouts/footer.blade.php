 
   
  

<footer class="main-footer">
	<div class="pull-right hidden-xs">
	  <b>Version</b> {{\App\Models\SysConfig::set()['version']}}
	</div>
	<div class="no-print">
		<strong>Copyright &copy; {{ date('Y') }} {{{\App\Models\SysConfig::set()['system_description']}}}</strong> 
	   All rights reserved.</a>
	</div>
</footer>