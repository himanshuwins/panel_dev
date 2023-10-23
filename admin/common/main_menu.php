<div id="mainmenu_f">
  <div id="panel_name_user">LOGGED IN : <?PHP echo($_SESSION['log_username']);?></div>
  <table style="width:100%;text-align:center;color:#EEE;max-height:55px;" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="left" style="width:10px;background-color:#FFF;"><img src="images/logo.png" style="padding:0 20px;" height="52px" /></td>
      <td style="width:1px;background-image:url(../images/menubg_invert.png);"></td>
      <td><a href="index.php"><div class="menuitem"<?php echo($top_dashboard);?>>HOME</div></a></td>
      <td style="width:1px;background-image:url(../images/menubg_invert.png);"></td>
      <td>
      <div class="menuitem" id="session"<?php echo($top_session);?>>SESSIONS
        <div class="dropdown" id="session_d" style="min-width:250px;width:100%;">
          <a href="close_session.php"><div class="drop_menuitem">Close Session</div></a>
        </div>
      </div>
      </td>
      <td style="width:1px;background-image:url(../images/menubg_invert.png);"></td>
      <td>
      <div class="menuitem" id="personal_details"<?php echo($top_personal_details);?>>USER DETAILS
        <div class="dropdown" id="personal_details_d" style="min-width:250px;width:100%;">
          <a href="change_profile_id.php"><div class="drop_menuitem">View / Edit Profile</div></a>
          <a href="change_password_id.php"><div class="drop_menuitem">Change User Password</div></a>
          <a href="activate_deactivate_id.php"><div class="drop_menuitem">Activate / Deactivate</div></a>
          <a href="view_user_chart.php"><div class="drop_menuitem">View User Chart</div></a>
          <a href="view_user_sales_report.php"><div class="drop_menuitem">View User Sales Report</div></a>
          <a href="view_user_sales_report.php"><div class="drop_menuitem">View User Income Details</div></a>
          <a href="view_user_domain.php"><div class="drop_menuitem">View User Domain Details</div></a>
        </div>
      </div>
      </td>
      <td style="width:1px;background-image:url(../images/menubg_invert.png);"></td>
      <td>
      <div class="menuitem" id="genealogy"<?php echo($top_genealogy);?>>ADMIN
        <div class="dropdown" id="genealogy_d" style="min-width:250px;width:100%;">
          <a href="downline_chart.php"><div class="drop_menuitem">Downline Chart</div></a>
          <a href="pending_linked_list.php"><div class="drop_menuitem">Pending Linked List</div></a>
          <a href="active_list.php"><div class="drop_menuitem">Active List</div></a>
          <a href="about_to_expire_list.php"><div class="drop_menuitem">About to Expire List</div></a>
          <a href="deactive_terminated_list.php"><div class="drop_menuitem">Deactive Terminated List</div></a>
          <a href="deactive_expired_list.php"><div class="drop_menuitem">Deactive Expired List</div></a>
          <a href="deactive_payment_not_received_list.php"><div class="drop_menuitem">Deactive Payment Not Received List</div></a>
          <a href="current_tag_holders.php"><div class="drop_menuitem">All Tag Holders</div></a>
          <a href="upgraded_tags.php"><div class="drop_menuitem">Tags Upgraded in Last Session</div></a>
        </div>
      </div>
      </td>
      <td style="width:1px;background-image:url(../images/menubg_invert.png);"></td>
      <td><div class="menuitem"></div></td>
      <td>
      <div class="menuitem" id="epin"<?php echo($top_epin);?>>E-PIN MANAGER
        <div class="dropdown" id="epin_d" style="min-width:250px;width:100%;">
          <a href="epin_requests_received.php"><div class="drop_menuitem">E-Pin Requests Received</div></a>
          <a href="issued_epins.php"><div class="drop_menuitem">Issued E-Pins</div></a>
          <a href="used_epins.php"><div class="drop_menuitem">Used E-Pins</div></a>
          <a href="change_epin_status_1.php"><div class="drop_menuitem">Activate/Deactivate Epin</div></a>
        </div>
      </div>
      </td>
      <td style="width:1px;background-image:url(../images/menubg_invert.png);"></td>
      <td>
      <div class="menuitem" id="reports"<?php echo($top_reports);?>>INCOME REPORTS
        <div class="dropdown" id="reports_d" style="min-width:250px;width:100%;">
          <a href="all_incomes.php"><div class="drop_menuitem">All Incomes List</div></a>
          <a href="pending_income_list.php"><div class="drop_menuitem">Pending Income List</div></a>
          <a href="transferred_income_list.php"><div class="drop_menuitem">Transferred Income List</div></a>
          <a href="stopped_income_list.php"><div class="drop_menuitem">Stopped Income List</div></a>
        </div>
      </div>
      </td>
      <td style="width:1px;background-image:url(../images/menubg_invert.png);"></td>
      <td>
      <div class="menuitem" id="support_center"<?php echo($top_support_center);?>>SUPPORT CENTER
        <div class="dropdown" id="support_center_d" style="min-width:250px;width:100%;">
          <a href="compose_message.php"><div class="drop_menuitem">Compose Message</div></a>
          <a href="inbox_not_answered.php"><div class="drop_menuitem">Inbox Not Answered</div></a>
          <a href="inbox_answered.php"><div class="drop_menuitem">Inbox Answered</div></a>
          <a href="outbox.php"><div class="drop_menuitem">Outbox</div></a>
        </div>
      </div></td>
      <td style="width:1px;background-image:url(../images/menubg_invert.png);"></td>
      <td>
      <div class="menuitem" id="domain"<?php echo($top_domain);?>>DOMAIN
        <div class="dropdown" id="domain_d" style="min-width:250px;width:100%;">
          <a href="domains_to_be_linked.php"><div class="drop_menuitem">Domains to be Linked</div></a>
          <a href="domains_already_linked.php"><div class="drop_menuitem">Domains Already Linked</div></a>
          <a href="users_without_domain.php"><div class="drop_menuitem">Users without Domain</div></a>
        </div>
      </div></td>
      <td style="width:1px;background-image:url(../images/menubg_invert.png);"></td>
      <td align="right"><a href="../php_scripts_wb/logout.php"><img src="../images/logout.png" height="30px" style="border:none;margin-right:20px;cursor:pointer;" onmouseover="this.src='../images/logout_h.png'" onmouseout="this.src='../images/logout.png'" title="Logout" /></a></td>
    </tr>
  </table>
</div>