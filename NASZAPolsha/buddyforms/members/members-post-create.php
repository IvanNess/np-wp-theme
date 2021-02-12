
<div id="item-body">
    <?php
    global $bp, $buddyforms, $buddyforms_member_tabs;

    $post_id = 0;
    $post_parent_id = 0;
    $revision_id = '';
    $current_component = $bp->current_component;

    $form_slug = $buddyforms_member_tabs[$bp->current_component][$bp->current_action];
    if($form_slug == 'add-classified'){
        echo '<p>Ads for available vacancies are placed exclusively in the section "<a href="https://dev.nashapolsha.pl/my-jobs/add-job">Work in Poland</a>"
    <br>Oferty pracy są ogłaszane wyłącznie w sekcji „<a href="https://dev.nashapolsha.pl/my-jobs/add-job">Praca w Polsce</a>”.</p>';
    }
    if (bp_current_action() == $form_slug . '-create') {
        if (isset($bp->action_variables[0])) {
            $post_parent_id = $bp->action_variables[0];
        }
    }
    if (bp_current_action() == $form_slug . '-edit') {
        if (isset($bp->action_variables[0])) {
            $post_id = $bp->action_variables[0];
        }
    }
    if (bp_current_action() == $form_slug . '-revision') {
        if (isset($bp->action_variables[1])) {
            $revision_id = $bp->action_variables[1];
        }
    }

    $args = array(
        'form_slug' => $form_slug,
        'post_id' => $post_id,
        'post_parent' => $post_parent_id,
        'post_type' => $post_type,
        'revision_id' => $revision_id
    );

    if ($post_id != 0 || $post_id != 'post_id') {
        if ($form_slug != 'add-classified') {
            $preview_type = 'job';
        } else {
            $preview_type = 'classifieds';
        }
        echo '<p>You can preview the ad <a href="https://dev.nashapolsha.pl/?post_type=' . $preview_type . '&p=' . $post_id . '" target="_blank" class="red_btn">here</a></p>';
    }
    buddyforms_create_edit_form($args);
    if ($form_slug != 'add-classified') {
        ?>
        <style>.bf_field_group.elem-post_status{display: none;}</style>
        <script>
            (function ($) {
                "use strict";
                var _job_package_val = $("#_job_package").val();
                var redirect_to = $("#redirect_to").val();
                var billing_job = <?php echo (!empty($post_id) || $post_id != 0) ? $post_id : '$("#post_id").val()'; ?>;
                function change_job_package(val) {
                    if (val == "2921") {
                        $("#redirect_to").val(redirect_to);
                    } else {
                        if (billing_job != 0 || !billing_job) {
                            $("#redirect_to").val('https://dev.nashapolsha.pl/checkout/?add-to-cart=' + val + '&billing_job=' + billing_job);
                        }
                    }
    //                    console.log('https://dev.nashapolsha.pl/checkout/?add-to-cart=' + val + '&billing_job=' + billing_job);
                }

                if (billing_job != 0 || billing_job != 'post_id') {
                    change_job_package(_job_package_val);
                    $("#_job_package").change(function () {
                        console.log($(this).val());
                        change_job_package($(this).val());
                    });
                }
                $('#post_status').val('pending');
                $('#save_as_draft').click(function (e) {
                    e.preventDefault();
                    $("#redirect_to").val(redirect_to);
                    $('.bf-submit').addClass('save_as_pending');
                    $('#post_status').val('draft');
                    $('.bf-submit').click();
                });
                $('.save_as_pending.bf-submit, .bf-submit, :not(#save_as_draft)').click(function () {
    //                    $('#post_status').val('pending');
                    if ($('#_job_package').val() == "2921") {
//                        $("#redirect_to").val(redirect_to.split('add-job-create/')[0]);
                        $('#post_status').val('publish');
                    } else {
                        $('#post_status').val('pending');
                        $("#redirect_to").val('https://dev.nashapolsha.pl/checkout/?add-to-cart=' + val + '&billing_job=' + billing_job);
                    }
                });
            })(jQuery);
        </script>
    <?php } else { ?>
        <script>
            (function ($) {
                "use strict";
                $('#post_status').val('publish');
                $('#save_as_draft').click(function (e) {
                    e.preventDefault();
                    $('.bf-submit').addClass('save_as_publish');
                    $('#post_status').val('draft');
                    $('.bf-submit').click();
                });
                $('.save_as_publish.bf-submit').click(function () {
                    $('#post_status').val('publish');
                });
            })(jQuery);
        </script>
    <?php } ?>
</div><!-- #item-body -->
