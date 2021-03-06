<?php

# Copyright (c) 2012 Anderson Fortaleza
# Licensed under the MIT license

final class EmailMonitorPlugin extends MantisPlugin {
    function register() {
        $this->name = 'Email Monitor';
        $this->description = 'Allows email subscriptions to the issue monitor feature.';
        $this->page = '';

        $this->version = '1.0';
        $this->requires = array(
            'MantisCore' => '1.2.0',
        );

        $this->author = 'Anderson Fortaleza';
        $this->contact = 'afortaleza@hotmail.com';
        $this->url = 'https://www.github.com/afortaleza';
    }

    function init()
    {
        require_once('EmailMonitor.API.php');
    }

    function hooks()
    {
        return array(
            'EVENT_VIEW_BUG_EXTRA' => 'display_emails',
            'EVENT_NOTIFY_USER_INCLUDE' => 'include_emails'
        );
    }

    function schema()
    {
        return array(
            array('CreateTableSQL', 
            	array(
            		plugin_table('email'), 
            		"
                	id			I		NOTNULL UNSIGNED AUTOINCREMENT PRIMARY,
                	bug_id		I		NOTNULL UNSIGNED,
                	email		C(128)	NOTNULL
                	"
        		)
    		),
        );
    }

    function install()
    {
        if (!user_get_id_by_name('plugin_EmailMonitor_user'))
        {
            $t_random_password = auth_generate_random_password('436173736961436172646f736f');
            $t_plain_password = auth_process_plain_password($t_random_password);

            // Create protected user with random password
            user_create('plugin_EmailMonitor_user', $t_plain_password, '', null, true);
        }

        return true;
    }

    function display_emails($p_event, $p_bug_id)
    {
        if ( access_has_bug_level( config_get( 'show_monitor_list_threshold' ), $p_bug_id ) ) 
        {

            $f_bug_id = gpc_get_int('id');
            $t_emails = EmailMonitor_List($f_bug_id);
            collapse_open('EmailMonitor');
?>
            <br/>
            <a name="changesets"/>
            <table class="width100" cellspacing="1">
                <tr>
                    <td class="form-title" colspan="2">
                        <?php collapse_icon( 'EmailMonitor' ); echo plugin_lang_get('email_list_title') ?>
                    </td>
                </tr>
                <tr class="row-1">
                    <td class="category" width="15%">
                        <?php echo plugin_lang_get('email_list') ?>
                    </td>
                    <td>
<?php
                        foreach ($t_emails as $email)
                        {
                            $s_delete_link = plugin_page('email_delete').'&bug_id='.$f_bug_id.'&email='.$email.form_security_param('plugin_EmailMonitor_email_delete');
?>
                            <a href="mailto:<?php echo $email ?>"><?php echo $email ?></a> 
                            [<a class="small" href="<?php echo $s_delete_link ?>"><?php echo plugin_lang_get('email_delete') ?></a>]
<?php                        
                        }
?>
                        <br/>
                        <br/>

                        <?php echo plugin_lang_get('email') ?>
                        <form action="<?php echo plugin_page('email_add') ?>" method="post">
                            <?php echo form_security_field('plugin_EmailMonitor_email_add') ?>
                            <input type="hidden" name="bug_id" value="<?php echo $f_bug_id ?>">
                            <input type="text" name="email" style="width: 180px;">
                            <input type="submit" class="button" value="<?php echo plugin_lang_get('email_add') ?>">
                        </form>
                    </td>
                </tr>
            </table>
<?php
            collapse_closed('EmailMonitor');
?>
            <br/>
            <table class="width100" cellspacing="1">
                <tr>
                    <td class="form-title">
                        <?php collapse_icon('EmailMonitor'); echo plugin_lang_get('email_list_title') ?>
                    </td>
                </tr>
            </table>
<?php
            collapse_end('EmailMonitor');
        }
    }

    function include_emails($t_notification_type, $t_bud_id)
    {
        $t_emails = EmailMonitor_List($t_bud_id);
        $t_return = array();
        $t_user_id = user_get_id_by_name('plugin_EmailMonitor_user');

        foreach ($t_emails as $t_current_email) {
            array_push($t_return, array( 'user_id' => $t_user_id, 'email' => $t_current_email ));
        }

        return $t_return;
    }
}

?>