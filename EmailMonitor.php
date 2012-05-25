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

    function init() {
        require_once( 'EmailMonitor.API.php' );
    }

    function hooks()
    {
        return array(
            'EVENT_VIEW_BUG_EXTRA' => 'display_emails',
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

    function display_emails($p_event, $p_bug_id)
    {
        $f_bug_id = gpc_get_int('id');
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
                    for ($i = 0; $i < 4; $i++)
                    {
                        $s_delete_link = plugin_page('email_delete').'&bug_id='.$f_bug_id.'&email=afortaleza'.$i.'@vivaimoveis.com.br'.form_security_param('plugin_EmailMonitor_email_delete');
?>
                        <a href="mailto:root@localhost">afortaleza<?php echo $i ?>@vivaimoveis.com.br</a> 
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

?>