<?php
    class ExamplePlugin extends MantisPlugin {
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
    }
?>

<table class="width100" cellspacing="1">
<tr>
    <td class="form-title">
        Emails monitoring this case
    </td>
</tr>
</table>