<?php

# Copyright (c) 2012 Anderson Fortaleza
# Licensed under the MIT license

require_once($t_plugin_path.'EmailMonitor/EmailMonitor.API.php' );
form_security_validate('plugin_EmailMonitor_email_delete');

$t_bug_id = $_GET['bug_id'];
$t_email = $_GET['email'];

if (email_is_valid($t_email))
{
    if (EmailMonitor_Exists($t_bug_id, $t_email))
    {
        EmailMonitor_Delete($t_bug_id, $t_email);
    }
    else
    {
        trigger_error(plugin_lang_get('error_not_monitoring'), ERROR);
    }
}
else 
{
    trigger_error(ERROR_EMAIL_INVALID, ERROR);
}

form_security_purge('plugin_EmailMonitor_email_add');
print_successful_redirect_to_bug($t_bug_id);

?>