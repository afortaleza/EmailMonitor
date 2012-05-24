<?php
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

        function hooks()
        {
            return array(
                'EVENT_VIEW_BUG_EXTRA' => 'display_emails',
            );
        }

        function display_emails($p_event, $p_bug_id)
        {
            collapse_open('EmailMonitor');
?>
            <br/>
            <a name="changesets"/>
            <table class="width100" cellspacing="1">
                <tr>
                    <td class="form-title">
                        <?php collapse_icon( 'EmailMonitor' ); echo plugin_lang_get('email_list_title') ?>
                    </td>
                </tr>
                <tr class="row-1">
                    <td class="category" width="15%">
                        <?= plugin_lang_get('email_list') ?>
                    </td>
                    <td>
<?php
                        for ($i = 0; $i < 4; $i++)
                        {
                            $s_delete_link = plugin_page('email_delete').'&bug_id='.$f_bug_id.'&email=afortaleza'.$i.'@vivaimoveis.com.br'.form_security_param('plugin_EmailMonitor_email_delete');
?>
                            <a href="mailto:root@localhost">afortaleza<?= echo $i ?>@vivaimoveis.com.br</a> 
                            [<a class="small" href="<?= $s_delete_link ?>">
                                    <?= plugin_lang_get('email_delete') ?>
                            </a>]
<?php
                        }
?>
                        <br/>
                        <br/>

                        <?php echo plugin_lang_get('email') ?>
                        <form action="<?= plugin_page('email_add') ?>" method="post">
                            <input type="hidden" name="bug_id" value="<?= $f_bug_id ?>">
                            <input type="text" name="email" style="width: 180px;">
                            <input type="submit" class="button" value="<?= plugin_lang_get('email_add') ?>">
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