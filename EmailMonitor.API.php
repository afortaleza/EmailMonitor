<?php

# Copyright (c) 2012 Anderson Fortaleza
# Licensed under the MIT license

/**
 * Retrieves a list of emails given the bug_id
 * @param int Bug ID
 * @return array Emails associated to the bug
 */
function EmailMonitor_List($t_bug_id)
{
    $t_emails = array();
    $t_email_table = plugin_table('email', 'EmailMonitor');
    $t_query = "SELECT email FROM $t_email_table WHERE bug_id = $t_bug_id";

    $t_result = db_query($t_query);

    while($t_row = db_fetch_array($t_result))
    {
        array_push($t_emails, $t_row['email']);
    }

    return $t_emails;
}

function EmailMonitor_Exits($t_bug_id, $t_email)
{
    $t_email_table = plugin_table('email', 'EmailMonitor');
    $t_query = "SELECT id FROM $t_email_table WHERE bug_id=".db_param()." AND $t_email=".db_param();

    db_query_bound($t_query, array($t_bug_id, $t_email));

    return db_num_rows($t_query) > 0;
}

function EmailMonitor_Add($t_bug_id, $t_email)
{
    $t_email_table = plugin_table('email', 'EmailMonitor');
    $t_query = "INSERT INTO $t_email_table VALUES (".db_param().", ".db_param().")";

    db_query_bound($t_query, array($t_bug_id, $t_email));

    return db_insert_id($t_email_table);
}

function EmailMonitor_Delete($t_id)
{
    $t_email_table = plugin_table('email', 'EmailMonitor');
    $t_query = "DELETE FROM $t_email_table WHERE id = $t_id";

    db_query_bound($t_query);
}

?>