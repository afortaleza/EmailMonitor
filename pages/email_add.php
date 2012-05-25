<?php

# Copyright (c) 2012 Anderson Fortaleza
# Licensed under the MIT license

form_security_validate('plugin_EmailMonitor_email_add');
require_once(config_get('plugin_path').'EmailMonitor/EmailMonitor.API.php');

$t_bug_id = $_POST['bug_id'];
$t_email = $_POST['email'];

if (email_is_valid($t_email))
{
	if (EmailMonitor_Exists($t_bug_id, $t_email))
	{
		trigger_error(ERROR_EMAIL_ALREADY_MONITORING, ERROR);
	}
	else
	{
		EmailMonitor_Add($t_bug_id, $t_email);
	}
}
else 
{
	trigger_error(ERROR_EMAIL_INVALID, ERROR);
}

form_security_purge('plugin_EmailMonitor_email_add');
print_successful_redirect_to_bug($t_bug_id);

?>