<?php
/*
 |  Snicker     A small Comment System 4 Bludit
 |  @file       ./admin/index-config.php
 |  @author     SamBrishes <sam@pytes.net>
 |  @version    0.1.0 [0.1.0] - Alpha
 |
 |  @website    https://github.com/pytesNET/snicker
 |  @license    X11 / MIT License
 |  @copyright  Copyright © 2018 - 2019 SamBrishes, pytesNET <info@pytes.net>
 */
    if(!defined("BLUDIT")){ die("Go directly to Jail. Do not pass Go. Do not collect 200 Cookies!"); }

    global $L, $login, $pages, $security, $Snicker, $SnickerPlugin;

    // Get Static Pages
    $static = $pages->getStaticDB(false);

?>
<div id="snicker-configure" class="tab-pane">
    <form method="post" action="<?php echo HTML_PATH_ADMIN_ROOT; ?>snicker#configure">
        <div class="card shadow-sm" style="margin: 1.5rem 0;">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <input type="hidden" id="tokenUser" name="tokenUser" value="<?php echo $login->username(); ?>" />
                        <input type="hidden" id="tokenCSRF" name="tokenCSRF" value="<?php echo $security->getTokenCSRF(); ?>" />
                        <input type="hidden" id="sn-action" name="action" value="snicker" />
                        <button class="btn btn-primary" name="snicker" value="configure"><?php sn_e("Save Settings"); ?></button>
                    </div>

                    <div class="col-sm-6">

                    </div>
                </div>
            </div>
        </div>

        <div class="accordion shadow-sm" id="accordion-settings">
            <div class="card">
                <div class="card-header text-uppercase pt-3 pb-3 pl-4 pr-4" data-toggle="collapse" data-target="#accordion-general"><?php sn_e("General Settings"); ?></div>
                <div id="accordion-general" class="collapse show" data-parent="#accordion-settings">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="sn-moderation" class="col-sm-3 col-form-label"><?php sn_e("Comment Moderation"); ?></label>
                            <div class="col-sm-9">
                                <select id="sn-moderation" name="moderation" class="custom-select custom-select-sm w-auto">
                                    <option value="true" <?php sn_selected("moderation", true); ?>><?php sn_e("Moderate"); ?></option>
                                    <option value="false" <?php sn_selected("moderation", false); ?>><?php sn_e("Pass"); ?></option>
                                </select>
                                <label for="sn-moderation" class="col-form-label-sm ml-2 align-top"><?php sn_e("each Comment") ?></label>

                                <div class="custom-control custom-checkbox pl-5 mt-1">
                                    <input type="checkbox" id="sn-moderation-loggedin" name="moderation_loggedin" value="true"
                                        class="custom-control-input" <?php sn_checked("moderation_loggedin"); ?> />
                                    <label class="custom-control-label" for="sn-moderation-loggedin"><?php sn_e("Unless the user is logged in"); ?></label>
                                </div>
                                <div class="custom-control custom-checkbox pl-5">
                                    <input type="checkbox" value="true" class="custom-control-input" checked="checked" disabled="disabled" />
                                    <label class="custom-control-label"><?php sn_e("Unless the user is admin or the content author"); ?></label>
                                </div>
                                <div class="custom-control custom-checkbox pl-5 mb-2">
                                    <input type="checkbox" id="sn-moderation-approved" name="moderation_approved" value="true"
                                        class="custom-control-input" <?php sn_checked("moderation_approved"); ?> />
                                    <label class="custom-control-label" for="sn-moderation-approved"><?php sn_e("Unless the user has an already approved comment"); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sn-comment-title" class="col-sm-3 col-form-label"><?php sn_e("Allow Comments"); ?></label>
                            <div class="col-sm-9">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="sn-comment-on-public" name="comment_on_public" value="true"
                                        class="custom-control-input" <?php sn_checked("comment_on_public"); ?> />
                                    <label class="custom-control-label" for="sn-comment-on-public"><?php sn_e("... on Public Pages"); ?></label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="sn-comment-on-sticky" name="comment_on_sticky" value="true"
                                        class="custom-control-input" <?php sn_checked("comment_on_sticky"); ?> />
                                    <label class="custom-control-label" for="sn-comment-on-sticky"><?php sn_e("... on Sticky Pages"); ?></label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="sn-comment-on-static" name="comment_on_static" value="true"
                                        class="custom-control-input" <?php sn_checked("comment_on_static"); ?> />
                                    <label class="custom-control-label" for="sn-comment-on-static"><?php sn_e("... on Static Pages"); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sn-comment-title" class="col-sm-3 col-form-label"><?php sn_e("Comment Title"); ?></label>
                            <div class="col-sm-9">
                                <select id="sn-comment-title" name="comment_title" class="form-control custom-select">
                                    <option value="optional" <?php sn_selected("comment_title", "optional"); ?>><?php sn_e("Enable (Optional)"); ?></option>
                                    <option value="required" <?php sn_selected("comment_title", "required"); ?>><?php sn_e("Enable (Required)"); ?></option>
                                    <option value="disabled" <?php sn_selected("comment_title", "disabled"); ?>><?php sn_e("Disable"); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sn-comment-limit" class="col-sm-3 col-form-label"><?php sn_e("Comment Limit"); ?></label>
                            <div class="col-sm-9">
                                <input type="number" id="sn-comment-limit" name="comment_limit" value="<?php echo sn_config("comment_limit"); ?>"
                                    class="form-control" min="0" placeholder="<?php sn_e("Use '0' to disable any limit!"); ?>" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sn-comment-depth" class="col-sm-3 col-form-label"><?php sn_e("Comment Depth"); ?></label>
                            <div class="col-sm-9">
                                <input type="number" id="sn-comment-depth" name="comment_depth" value="<?php echo sn_config("comment_depth"); ?>"
                                    class="form-control" min="0" placeholder="<?php sn_e("Use '0' to disable any limit!"); ?>" />
                                <small class="form-text text-muted"><?php sn_e("Use '0' to disable any limit!"); ?></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php sn_e("Comment Markup"); ?></label>
                            <div class="col-sm-9">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="sn-markup-html" name="comment_markup_html" value="true"
                                        class="custom-control-input" <?php sn_checked("comment_markup_html"); ?> />
                                    <label class="custom-control-label" for="sn-markup-html"><?php sn_e("Allow Basic HTML"); ?></label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="sn-markup-markdown" name="comment_markup_markdown" value="true"
                                        class="custom-control-input" <?php sn_checked("comment_markup_markdown"); ?> />
                                    <label class="custom-control-label" for="sn-markup-markdown"><?php sn_e("Allow Markdown"); ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><?php sn_e("Comment Voting"); ?></label>
                            <div class="col-sm-9">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="sn-like" name="comment_enable_like" value="true"
                                        class="custom-control-input" <?php sn_checked("comment_enable_like"); ?> />
                                    <label class="custom-control-label" for="sn-like"><?php sn_e("Allow to %s comments", array("<b>".sn__("Like")."</b>")); ?></label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" id="sn-dislike" name="comment_enable_dislike" value="true"
                                        class="custom-control-input" <?php sn_checked("comment_enable_dislike"); ?>/>
                                    <label class="custom-control-label" for="sn-dislike"><?php sn_e("Allow to %s comments", array("<b>".sn__("Dislike")."</b>")); ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header text-uppercase pt-3 pb-3 pl-4 pr-4" data-toggle="collapse" data-target="#accordion-frontend"><?php sn_e("Frontend Settings"); ?></div>
                <div id="accordion-frontend" class="collapse" data-parent="#accordion-settings">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="sn-filter" class="col-sm-3 col-form-label"><?php sn_e("Page Filter"); ?></label>
                            <div class="col-sm-9">
                                <select id="sn-filter" name="frontend_filter" class="form-control custom-select">
                                    <option value="disabled" <?php sn_selected("frontend_filter", "disabled"); ?>><?php sn_e("Disable Page Filter"); ?></option>
                                    <option value="pageBegin" <?php sn_selected("frontend_filter", "pageBegin"); ?>><?php sn_e("Use 'pageBegin'"); ?></option>
                                    <option value="pageEnd" <?php sn_selected("frontend_filter", "pageEnd"); ?>><?php sn_e("Use 'pageEnd'"); ?></option>
                                    <option value="siteBodyBegin" <?php sn_selected("frontend_filter", "siteBodyBegin"); ?>><?php sn_e("Use 'siteBodyBegin'"); ?></option>
                                    <option value="siteBodyEnd" <?php sn_selected("frontend_filter", "siteBodyEnd"); ?>><?php sn_e("Use 'siteBodyEnd'"); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sn-template" class="col-sm-3 col-form-label"><?php sn_e("Comment Template"); ?></label>
                            <div class="col-sm-9">
                                <select id="sn-template" name="frontend_template" class="form-control custom-select">
                                    <?php
                                        
                                        foreach($Snicker->themes AS $key => $theme){
                                            ?>
                                                <option value="<?php echo $key; ?>" <?php sn_selected("frontend_template", $key); ?>><?php echo $theme::SNICKER_NAME;  ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sn-order" class="col-sm-3 col-form-label"><?php sn_e("Comment Order"); ?></label>
                            <div class="col-sm-9">
                                <select id="sn-order" name="frontend_order" class="form-control custom-select">
                                    <option value="date_desc" <?php sn_selected("frontend_order", "date_desc"); ?>><?php sn_e("Newest Comments First"); ?></option>
                                    <option value="date_asc" <?php sn_selected("frontend_order", "date_asc"); ?>><?php sn_e("Oldest Comments First"); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sn-per-page" class="col-sm-3 col-form-label"><?php sn_e("Comments Per Page"); ?></label>
                            <div class="col-sm-9">
                                <input type="number" id="sn-per-page" name="frontend_per_page" value="<?php echo sn_config("frontend_per_page"); ?>"
                                    class="form-control" min="0" step="1" placheolder="<?php sn_e("Use '0' to show all available comments!"); ?>" />
                                <small class="form-text text-muted"><?php sn_e("Use '0' to show all available comments!"); ?></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sn-terms" class="col-sm-3 col-form-label"><?php sn_e("Terms of Use Checkbox"); ?></label>
                            <div class="col-sm-9">
                                <select id="sn-terms" name="frontend_terms" class="form-control custom-select">
                                    <option value="disabled" <?php sn_selected("frontend_terms", "disabled"); ?>><?php sn_e("Disable this field"); ?></option>
                                    <option value="default" <?php sn_selected("frontend_terms", "default"); ?>><?php sn_e("Show default Message"); ?></option>

                                    <?php foreach($static AS $key => $value){ ?>
                                        <option value="<?php echo $key; ?>" <?php sn_selected("frontend_terms", $key); ?>><?php sn_e("Page"); ?>: <?php echo $value["title"]; ?></option>
                                    <?php } ?>
                                </select>
                                <small class="form-text text-muted"><?php sn_e("Show the default GDPR Text or Select your own static 'Terms of Use' page!"); ?></small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sn-ajax" class="col-sm-3 col-form-label"><?php sn_e("AJAX Script"); ?></label>
                            <div class="col-sm-9">
                                <select id="sn-ajax" name="frontend_ajax" class="form-control custom-select">
                                    <option value="true" <?php sn_selected("frontend_ajax", true); ?>><?php sn_e("Embed AJAX Script"); ?></option>
                                    <option value="false" <?php sn_selected("frontend_ajax", false); ?>><?php sn_e("Don't use AJAX"); ?></option>
                                </select>
                                <small class="form-text text-muted"><?php sn_e("The AJAX Script hands over the request (comment, like, dislike) directly without reloading the page!"); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header text-uppercase pt-3 pb-3 pl-4 pr-4" data-toggle="collapse" data-target="#accordion-subscripton"><?php sn_e("Subscription Settings"); ?></div>
                <div id="accordion-subscripton" class="collapse" data-parent="#accordion-settings">
                    <div class="card-body">
                        <div class="alert alert-info"><?php sn_e("The Subscription system isn't available yet!"); ?> :(</div>
                        <div class="form-group row">
                            <label for="sn-subscription" class="col-sm-3 col-form-label text-muted"><?php sn_e("eMail Subscription"); ?></label>
                            <div class="col-sm-9">
                                <select id="sn-subscription" name="subscription" class="form-control custom-select" disabled="disabled">
                                    <option value="true" <?php sn_selected("subscription", true); ?> disabled="disabled"><?php sn_e("Enable"); ?></option>
                                    <option value="false" <?php sn_selected("subscription", false); ?>><?php sn_e("Disable"); ?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sn-subscription-from" class="col-sm-3 col-form-label text-muted"><?php sn_e("eMail 'From' Address"); ?></label>
                            <div class="col-sm-9">
                                <input type="text" id="sn-subscription-from" name="subscription_from" value="<?php echo sn_config("subscription_from"); ?>"
                                    class="form-control" placeholder="<?php sn_e("eMail 'From' Address"); ?>" disabled="disabled" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sn-subscription-reply" class="col-sm-3 col-form-label text-muted"><?php sn_e("eMail 'ReplyTo' Address"); ?></label>
                            <div class="col-sm-9">
                                <input type="text" id="sn-subscription-reply" name="subscription_reply" value="<?php echo sn_config("subscription_reply"); ?>"
                                    class="form-control" placeholder="<?php sn_e("eMail 'ReplyTo' Address"); ?>" disabled="disabled" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sn-subscription-optin" class="col-sm-3 col-form-label text-muted"><?php sn_e("eMail Body (Opt-In)"); ?></label>
                            <div class="col-sm-9">
                                <select id="sn-subscription-optin" name="subscription_optin" class="form-control custom-select" disabled="disabled">
                                    <option value="default" <?php sn_selected("subscription_optin", "default"); ?>><?php sn_e("Use default Subscription eMail"); ?></option>
                                    <?php foreach($static AS $key => $value){ ?>
                                        <option value="<?php echo $key; ?>" <?php sn_selected("subscription_optin", $key); ?>><?php sn_e("Page"); ?>: <?php echo $value["title"]; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sn-subscription-ticker" class="col-sm-3 col-form-label text-muted"><?php sn_e("eMail Body (Notification)"); ?></label>
                            <div class="col-sm-9">
                                <select id="sn-subscription-ticker" name="subscription_ticker" class="form-control custom-select" disabled="disabled">
                                    <option value="default" <?php sn_selected("subscription_ticker", "default"); ?>><?php sn_e("Use default Notification eMail"); ?></option>
                                    <?php foreach($static AS $key => $value){ ?>
                                        <option value="<?php echo $key; ?>" <?php sn_selected("subscription_ticker", $key); ?>><?php sn_e("Page"); ?>: <?php echo $value["title"]; ?></option>
                                    <?php } ?>
                                </select>
                                <small class="form-text text-muted"><?php sn_e("Read more about a custom Notification eMails %s!", array('<a href="#" target="_blank">'.sn__("here").'</a>')); ?></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header text-uppercase pt-3 pb-3 pl-4 pr-4" data-toggle="collapse" data-target="#accordion-strings"><?php sn_e("Strings"); ?></div>
                <div id="accordion-strings" class="collapse" data-parent="#accordion-settings">
                    <div class="card-body">
                    <div class="form-group row">
                        <label for="sn-success-1" class="col-sm-3 col-form-label"><?php sn_e("Default Thanks Message"); ?></label>
                        <div class="col-sm-9">
                            <input type="text" id="sn-success-1" name="string_success_1" value="<?php echo sn_config("string_success_1"); ?>"
                                class="form-control" placeholder="<?php echo $SnickerPlugin->dbFields["string_success_1"]; ?>" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sn-success-2" class="col-sm-3 col-form-label"><?php sn_e("Thanks Message with Subscription"); ?></label>
                        <div class="col-sm-9">
                            <input type="text" id="sn-success-2" name="string_success_2" value="<?php echo sn_config("string_success_2"); ?>"
                                class="form-control" placeholder="<?php echo $SnickerPlugin->dbFields["string_success_2"]; ?>" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sn-success-3" class="col-sm-3 col-form-label"><?php sn_e("Thanks Message for Voting"); ?></label>
                        <div class="col-sm-9">
                            <input type="text" id="sn-success-3" name="string_success_3" value="<?php echo sn_config("string_success_3"); ?>"
                                class="form-control" placeholder="<?php echo $SnickerPlugin->dbFields["string_success_3"]; ?>" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sn-error-1" class="col-sm-3 col-form-label"><?php sn_e("Error: Unknown Error, Try again"); ?></label>
                        <div class="col-sm-9">
                            <input type="text" id="sn-error-1" name="string_error_1" value="<?php echo sn_config("string_error_1"); ?>"
                                class="form-control" placeholder="<?php echo $SnickerPlugin->dbFields["string_error_1"]; ?>" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sn-error-2" class="col-sm-3 col-form-label"><?php sn_e("Error: Username or eMail is missing"); ?></label>
                        <div class="col-sm-9">
                            <input type="text" id="sn-error-2" name="string_error_2" value="<?php echo sn_config("string_error_2"); ?>"
                                class="form-control" placeholder="<?php echo $SnickerPlugin->dbFields["string_error_2"]; ?>" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sn-error-3" class="col-sm-3 col-form-label"><?php sn_e("Error: Comment Text is missing"); ?></label>
                        <div class="col-sm-9">
                            <input type="text" id="sn-error-3" name="string_error_3" value="<?php echo sn_config("string_error_3"); ?>"
                                class="form-control" placeholder="<?php echo $SnickerPlugin->dbFields["string_error_3"]; ?>" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sn-error-4" class="col-sm-3 col-form-label"><?php sn_e("Error: Comment Title is missing"); ?></label>
                        <div class="col-sm-9">
                            <input type="text" id="sn-error-4" name="string_error_4" value="<?php echo sn_config("string_error_4"); ?>"
                                class="form-control" placeholder="<?php echo $SnickerPlugin->dbFields["string_error_4"]; ?>" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sn-error-5" class="col-sm-3 col-form-label"><?php sn_e("Error: Terms not accepted"); ?></label>
                        <div class="col-sm-9">
                            <input type="text" id="sn-error-5" name="string_error_5" value="<?php echo sn_config("string_error_5"); ?>"
                                class="form-control" placeholder="<?php echo $SnickerPlugin->dbFields["string_error_5"]; ?>" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sn-error-6" class="col-sm-3 col-form-label"><?php sn_e("Error: Marked as SPAM"); ?></label>
                        <div class="col-sm-9">
                            <input type="text" id="sn-error-6" name="string_error_6" value="<?php echo sn_config("string_error_6"); ?>"
                                class="form-control" placeholder="<?php echo $SnickerPlugin->dbFields["string_error_6"]; ?>" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="sn-error-7" class="col-sm-3 col-form-label"><?php sn_e("Error: Already Voted"); ?></label>
                        <div class="col-sm-9">
                            <input type="text" id="sn-error-7" name="string_error_7" value="<?php echo sn_config("string_error_7"); ?>"
                                class="form-control" placeholder="<?php echo $SnickerPlugin->dbFields["string_error_7"]; ?>" />
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-4 mb-4">
            <div class="card-body">
                <button class="btn btn-primary" name="snicker" value="configure"><?php sn_e("Save Settings"); ?></button>
            </div>
        </div>
    </form>
</div>
