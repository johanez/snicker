<?php
/*
 |  Snicker     A small Comment System 4 Bludit
 |  @file       ./admin/index-comments.php
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.1.0 [0.1.0] - Alpha
 |
 |  @website    https://github.com/pytesNET/snicker
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
    if(!defined("BLUDIT")){ die("Go directly to Jail. Do not pass Go. Do not collect 200 Cookies!"); }

    global $pages, $security, $Snicker, $SnickerIndex, $SnickerPlugin, $SnickerUsers;

    // Get Data
    $limits = $SnickerPlugin->getValue("frontend_per_page");
    $current = isset($_GET["tab"])? $_GET["tab"]: "pending";

    // Render Comemnts Tab
    foreach(array("pending", "approved", "rejected", "spam") AS $status){
        if(isset($_GET["tab"]) && $_GET["tab"] === $status){
            $page = max((isset($_GET["page"])? (int) $_GET["page"]: 1), 1);
        } else {
            $page = 1;
        }

        // Get Page Comments
        $total = $SnickerIndex->count($status);
        $comments = $SnickerIndex->getList($status, $page, $limits);

        // Render Tab Content
        $link = DOMAIN_ADMIN . "snicker?page=%d&tab={$status}#{$status}";
        ?>
            <div id="snicker-<?php echo $status; ?>" class="tab-pane <?php echo($current === $status)? "active": ""; ?>">
                <div class="card shadow-sm" style="margin: 1.5rem 0;">
                    <div class="card-body">
                        <div class="row">
                            <form class="col-sm-6">
                                <div class="form-row align-items-center">
                                    <div class="col-sm-8">
                                        <input type="text" name="search" value="" class="form-control" placeholder="<?php sn_e("Comment Title or Username"); ?>" />
                                    </div>
                                    <div class="col-sm-4">
                                        <button class="btn btn-primary" name="action" value="search"><?php sn_e("Search Comments"); ?></button>
                                    </div>
                                </div>
                            </form>

                            <div class="col-sm-6 text-right">
                                <?php if($total > $limits){ ?>
                                    <div class="btn-group btn-group-pagination">
                                        <?php if($page <= 1){ ?>
                                            <span class="btn btn-secondary disabled">&laquo;</span>
                                            <span class="btn btn-secondary disabled">&lsaquo;</span>
                                        <?php } else { ?>
                                            <a href="<?php printf($link, 1); ?>" class="btn btn-secondary">&laquo;</a>
                                            <a href="<?php printf($link, $page-1); ?>" class="btn btn-secondary">&lsaquo;</a>
                                        <?php } ?>
                                        <?php if(($page * $limits) < $total){ ?>
                                            <a href="<?php printf($link, $page+1); ?>" class="btn btn-secondary">&rsaquo;</a>
                                            <a href="<?php printf($link, ceil($total / $limits)); ?>" class="btn btn-secondary">&raquo;</a>
                                        <?php } else { ?>
                                            <span class="btn btn-secondary disabled">&rsaquo;</span>
                                            <span class="btn btn-secondary disabled">&raquo;</span>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php /* No Comments available */ ?>
                <?php if(count($comments) < 1){ ?>
                        <div class="row justify-content-md-center">
                            <div class="col-sm-6">
                                <div class="card w-100 shadow-sm bg-light">
                                    <div class="card-body text-center p-4"><i><?php sn_e("No Comments available"); ?></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php continue; ?>
                <?php } ?>

                <?php /* Comments Table */ ?>
                <?php $link = DOMAIN_ADMIN . "snicker?action=snicker&snicker=%s&uid=%s&status=%s&tokenCSRF=" . $security->getTokenCSRF(); ?>
                <table class="table table-bordered table-hover-light shadow-sm mt-3">
                    <?php foreach(array("thead", "tfoot") AS $tag){ ?>
                        <<?php echo $tag; ?>>
                            <tr class="thead-light">
                                <th width="38%" class="border-0 p-3 text-uppercase text-muted"><?php sn_e("Comment"); ?></th>
                                <th width="15%" class="border-0 p-3 text-uppercase text-muted"><?php sn_e("Page"); ?></th>
                                <th width="22%" class="border-0 p-3 text-uppercase text-muted"><?php sn_e("Author"); ?></th>
                                <th width="25%" class="border-0 p-3 text-uppercase text-muted text-center"><?php sn_e("Actions"); ?></th>
                            </tr>
                        </<?php echo $tag; ?>>
                    <?php } ?>
                    <tbody class="shadow-sm-both">
                        <?php foreach($comments AS $uid){ ?>
                            <?php
                                $data = $SnickerIndex->getComment($uid, $status);
                                if(!(isset($data["page_uuid"]) && is_string($data["page_uuid"]))){
                                    continue;
                                }
                                $user = $SnickerUsers->getByString($data["author"]);
                            ?>
                            <tr>
                                <td class="pt-2 pb-2 pl-3 pr-3">
                                    <?php
                                        if($SnickerPlugin->getValue("comment_title") !== "disabled"){
                                            if(empty($data["title"])){
                                                echo '<i class="d-inline-block mb-1">'.sn__("No Comment Title available").'</i>';
                                            } else {
                                                echo '<b class="d-inline-block mb-1">' . $data["title"] . '</b>';
                                            }
                                        }
                                        echo '<p class="m-0 text-muted" style="font-size:12px;">' . (isset($data["excerpt"])? $data["excerpt"]: "") . '</p>';
                                    ?>
                                </td>
                                <td class="text-center align-middle pt-2 pb-2 pl-1 pr-1">
                                    <?php $page = new Page($pages->getByUUID($data["page_uuid"])); ?>
                                    <a href="<?php echo $page->permalink(); ?>" class="btn btn-sm btn-primary"><?php sn_e("View Page"); ?></a>
                                </td>
                                <td class="pt-2 pb-2 pl-3 pr-3">
                                    <span class="d-inline-block mb-1"><?php echo $user["username"]; ?></span>
                                    <small class='d-block'><?php echo $user["email"]; ?></small>
                                </td>
                                <td class="text-center align-middle pt-2 pb-2 pl-1 pr-1">
                                    <div class="btn-group">
                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                                            <?php sn_e("Change"); ?>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <?php if($status !== "approved"){ ?>
                                                <a class="dropdown-item" href="<?php printf($link, "moderate", $uid, "approved"); ?>"><?php sn_e("Approve Comment"); ?></a>
                                            <?php } ?>

                                            <?php if($status !== "rejected"){ ?>
                                                <a class="dropdown-item" href="<?php printf($link, "moderate", $uid, "rejected"); ?>"><?php sn_e("Reject Comment"); ?></a>
                                            <?php } ?>

                                            <?php if($status !== "spam"){ ?>
                                                <a class="dropdown-item" href="<?php printf($link, "moderate", $uid, "spam"); ?>"><?php sn_e("Mark as Spam"); ?></a>
                                            <?php } ?>

                                            <?php if($status !== "pending"){ ?>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="<?php printf($link, "moderate", $uid, "pending"); ?>"><?php sn_e("Back to Pending"); ?></a>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <a href="<?php echo DOMAIN_ADMIN . "snicker/edit/?uid=" . $uid; ?>" class="btn btn-outline-primary btn-sm"><?php sn_e("Edit"); ?></a>
                                    <a href="<?php printf($link, "delete", $uid, "delete"); ?>" class="btn btn-outline-danger btn-sm"><?php sn_e("Delete"); ?></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        <?php
    }
