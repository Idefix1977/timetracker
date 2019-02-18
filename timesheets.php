<?php
// +----------------------------------------------------------------------+
// | Anuko Time Tracker
// +----------------------------------------------------------------------+
// | Copyright (c) Anuko International Ltd. (https://www.anuko.com)
// +----------------------------------------------------------------------+
// | LIBERAL FREEWARE LICENSE: This source code document may be used
// | by anyone for any purpose, and freely redistributed alone or in
// | combination with other software, provided that the license is obeyed.
// |
// | There are only two ways to violate the license:
// |
// | 1. To redistribute this code in source form, with the copyright
// |    notice or license removed or altered. (Distributing in compiled
// |    forms without embedded copyright notices is permitted).
// |
// | 2. To redistribute modified versions of this code in *any* form
// |    that bears insufficient indications that the modifications are
// |    not the work of the original author(s).
// |
// | This license applies to this document only, not any other software
// | that it may be combined with.
// |
// +----------------------------------------------------------------------+
// | Contributors:
// | https://www.anuko.com/time_tracker/credits.htm
// +----------------------------------------------------------------------+

require_once('initialize.php');
import('form.Form');
import('ttTimesheetHelper');

// Access checks.
if (!(ttAccessAllowed('view_own_timesheets') ||
  ttAccessAllowed('manage_own_timesheets') ||
  ttAccessAllowed('view_timesheets') ||
  ttAccessAllowed('manage_timesheets') ||
  ttAccessAllowed('approve_timesheets'))) {
  header('Location: access_denied.php');
  exit();
}

if (!$user->isPluginEnabled('ts')) {
  header('Location: feature_disabled.php');
  exit();
}
// End of access checks.

// TODO: determine user properly, using a dropdown.
$user_id = $user->getUser();

// TODO: fix this for client access.
$active_timesheets = ttTimesheetHelper::getActiveTimesheets($user_id);
$inactive_timesheets = ttTimesheetHelper::getInactiveTimesheets($user_id);
$show_client = $user->isPluginEnabled('cl') && !$user->isClient();

$smarty->assign('active_timesheets', $active_timesheets);
$smarty->assign('inactive_timesheets', $inactive_timesheets);
$smarty->assign('show_client', $show_client);
$smarty->assign('show_submit_status', !$user->isClient());
$smarty->assign('show_approval_status', !$user->isClient());

$smarty->assign('title', $i18n->get('title.timesheets'));
$smarty->assign('content_page_name', 'timesheets.tpl');
$smarty->display('index.tpl');