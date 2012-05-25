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

/**
 * Check if email already monitors the issue
 * @param int Bug ID
 * @param string Email address to be checked
 * @return bool True if email is already monitoring the issue
 */
function EmailMonitor_Exists($t_bug_id, $t_email)
{
    $t_email_table = plugin_table('email', 'EmailMonitor');
    $t_query = "SELECT id FROM $t_email_table WHERE bug_id=".db_param()." AND email=".db_param();

    $t_results = db_query_bound($t_query, array($t_bug_id, $t_email));

    return db_num_rows($t_results) > 0;
}

/**
 * Adds email to issue monitor list
 * @param int Bug ID
 * @param string Email address to be added to the issue monitor list
 * @return int The ID of the database record added
 */
function EmailMonitor_Add($t_bug_id, $t_email)
{
    $t_email_table = plugin_table('email', 'EmailMonitor');
    $t_query = "INSERT INTO $t_email_table VALUES (".db_param().", ".db_param().")";

    db_query_bound($t_query, array($t_bug_id, $t_email));

    return db_insert_id($t_email_table);
}

/**
 * Deletes email from the issue monitor list
 * @param int EmailMonitor ID
 */
function EmailMonitor_Delete($t_id)
{
    $t_email_table = plugin_table('email', 'EmailMonitor');
    $t_query = "DELETE FROM $t_email_table WHERE id = $t_id";

    db_query_bound($t_query);
}
?>