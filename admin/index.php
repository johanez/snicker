<?php
/*
 |  Snicker     A small Comment System 4 Bludit
 |  @file       ./admin/index.php
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.1.0 [0.1.0] - Alpha
 |
 |  @website    https://github.com/pytesNET/snicker
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
    if(!defined("BLUDIT")){ die("Go directly to Jail. Do not pass Go. Do not collect 200 Cookies!"); }

    global $L, $Snicker;

    // Pending Counter
    $count = count($Snicker->getIndex("pending"));
    $count = ($count > 99)? "99+": $count;

    // Current Tab
    $current = isset($_GET["tab"])? $_GET["tab"]: "pending";

?>
<h2 class="mt-0 mb-3">
    <span class="oi oi-comment-square" style="font-size: 0.7em;"></span> Snicker <?php sn_e("Comments"); ?>
</h2>

<ul class="nav nav-pills" data-handle="tabs">
    <?php foreach(array("pending", "approved", "rejected", "spam") AS $tab){ ?>
        <?php $class = "nav-link nav-{$tab}" . ($current === $tab? " active": ""); ?>
        <li class="nav-item">
            <a id="<?php echo $tab; ?>-tab" href="#snicker-<?php echo $tab; ?>" class="<?php echo $class; ?>" data-toggle="tab">
                <?php
                    sn_e(ucfirst($tab));
                    if($tab === "pending" && !empty($count)){
                        ?> <span class="badge badge-primary"><?php echo $count; ?></span><?php
                    }
                ?>
            </a>
        </li>
    <?php } ?>

    <li class="nav-item flex-grow-1"></li>

    <li class="nav-item mr-2">
        <a id="users-tab" href="#snicker-users" class="nav-link nav-config" data-toggle="tab">
            <span class="oi oi-people"></span> <?php sn_e("Users"); ?>
        </a>
    </li>
    <li class="nav-item">
        <a id="configure-tab" href="#snicker-configure" class="nav-link nav-config" data-toggle="tab">
            <span class="oi oi-cog"></span> <?php sn_e("Configuration"); ?>
        </a>
    </li>
</ul>

<div class="tab-content">
    <?php
        include "index-comments.php";
        include "index-users.php";
        include "index-config.php";
    ?>
</div>
