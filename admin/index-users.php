<?php
/*
 |  Snicker     A small Comment System 4 Bludit
 |  @file       ./admin/index-users.php
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.1.0 [0.1.0] - Alpha
 |
 |  @website    https://github.com/pytesNET/snicker
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
    if(!defined("BLUDIT")){ die("Go directly to Jail. Do not pass Go. Do not collect 200 Cookies!"); }

    global $SnickerUsers;

    $users = $SnickerUsers->db;

?>
<div id="snicker-users" class="tab-pane">
    <div class="card shadow-sm" style="margin: 1.5rem 0;">
        <div class="card-body">
            <div class="row">
                <form class="col-sm-6">
                    <div class="form-row align-items-center">
                        <div class="col-sm-8">
                            <input type="text" name="search" value="" class="form-control" placeholder="<?php sn_e("Username or eMail Address"); ?>" />
                        </div>
                        <div class="col-sm-4">
                            <button class="btn btn-primary" name="action" value="search"><?php sn_e("Search Users"); ?></button>
                        </div>
                    </div>
                </form>

                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </div>

    <?php if(count($users) === 0){ ?>
        <div class="row justify-content-md-center">
            <div class="col-sm-6">
                <div class="card w-100 shadow-sm bg-light">
                    <div class="card-body text-center p-4"><i><?php sn_e("No Comments available"); ?></i></div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <table class="table table-bordered table-hover-light shadow-sm mt-3">
            <?php foreach(array("thead", "tfoot") AS $tag){ ?>
                <<?php echo $tag; ?>>
                    <tr class="thead-light">
                        <th width="38%" class="border-0 p-3 text-uppercase text-muted"><?php sn_e("Username"); ?></th>
                        <th width="15%" class="border-0 p-3 text-uppercase text-muted"><?php sn_e("eMail Address"); ?></th>
                        <th width="22%" class="border-0 p-3 text-uppercase text-muted"><?php sn_e("Comments"); ?></th>
                        <th width="25%" class="border-0 p-3 text-uppercase text-muted text-center"><?php sn_e("Actions"); ?></th>
                    </tr>
                </<?php echo $tag; ?>>
            <?php } ?>
            
            <tbody class="shadow-sm-both">
                <?php foreach($users AS $user){ ?>
                    <tr>
                        <td class="p-3">
                            <?php echo $user["username"]; ?>
                        </td>
                        <td class="p-3">
                            <?php echo $user["email"]; ?>
                        </td>
                        <td class="text-center align-middle pt-2 pb-2 pl-1 pr-1">
                            0 Comments
                        </td>
                        <td class="text-center align-middle pt-2 pb-2 pl-1 pr-1">
                            <div class="btn-group">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <?php sn_e("Handle"); ?>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#"><?php sn_e("Delete"); ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#"><?php sn_e("Block"); ?></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } ?>
</div>
