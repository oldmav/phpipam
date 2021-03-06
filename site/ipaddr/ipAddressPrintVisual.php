<?php

# get array of IP addresses
$ipVisual = getIpAddressesForVisual($subnetId);

# if empty
if(sizeof($ipVisual) == '0')	{ $ipVisual = array("a"); }

# show squares to display free/used subnet
if(sizeof($slaves) == 0 && $type == 0 && $SubnetDetails['mask']!="31" && $SubnetDetails['mask']!='32') {

	print "<br><h4>"._('Visual subnet display')." <i class='icon-gray icon-info-sign' rel='tooltip' data-html='true' title='"._('Click on IP address box<br>to manage IP address')."!'></i></h4><hr>";
	print "<div class='ip_vis'>";
	# get max hosts
	$max = MaxHosts($SubnetDetails['mask'], $type);
	$max = $SubnetDetails['subnet'] + $max;
	# set start
	$start = gmp_strval(gmp_add($SubnetDetails['subnet'],1));
	
	for($m=$start; $m<=$max; $m=gmp_strval(gmp_add($m,1))) {
		# already exists
		if (array_key_exists((string)$m, $ipVisual)) {
		
			# fix for empty states - if state is disabled, set to active
			if(strlen($ipVisual[$m]['state'])==0) { $ipVisual[$m]['state'] = 1; }
		
			$class = $ipVisual[$m]['state'];
			$id = (int)$ipVisual[$m]['id'];
			$action = 'all-edit';
    	}
    	else {
    		# print add
    		$class = 9;
    		$id = $m;
    		$action = 'all-add';
    	}
   		# permissions
		$permission = checkSubnetPermission ($subnetId);
		
		# print box
		if($permission > 1) {
			print "<span class='ip-$class modIPaddr'  data-action='$action' data-subnetId='".$subnetId."' data-id='$id'>.".substr(strrchr(transform2long($m), "."), 1)."</span>";	
		}	
		else {
			print "<span class='ip-$class '  data-action='$action' data-subnetId='".$subnetId."' data-id='$id'>.".substr(strrchr(transform2long($m), "."), 1)."</span>";				
		}
	}
	print "</div>";
	print "<div style='clear:both;padding-bottom:20px;'></div>";	# clear float
}
?>