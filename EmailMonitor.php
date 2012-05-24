<?php
    final class ExamplePlugin extends MantisPlugin {
        function register() {
            $this->name = 'EmailMonitor';
            $this->description = 'A plugin for that allows email subscription to the issue monitor feature.';
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
?>
            <table class="width100" cellspacing="1">
                <tr>
                    <td class="form-title">
                        <?php echo plugin_lang_get('email_list_title') ?>
                    </td>
                </tr>
                <tr>
                    <td>afortaleza@hotmail.com</td>
                </tr>
            </table>
<?php
        }
    }
?>