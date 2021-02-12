
<section id="classifieds_categories_widget" class="widget" style="margin-bottom: 20px;">
    <div class="classifieds-row">
        <a class="btn letter-spacing-2px btn-highlight text-uppercase btn_add_classified" href="https://dev.nashapolsha.pl/my-jobs/add-job">+ Add a vacancy / Dodaj ogłoszenie</a>
        <h2 class="classifieds-title">Praca / Work in Poland</h2>
        <?php
//        $obj = get_queried_object();
        $query_id = get_queried_object_id();
        $cat_args = array(
//            'orderby' => 'term_id',
//            'orderby' => 'count',
//            'order' => 'DESC',
            'hide_empty' => true,
        );

        $terms = get_terms('job_category', $cat_args);
        echo '<div class="col-lg-6"><h4>Categories</h4><select class="dynamic_select"><option value="https://dev.nashapolsha.pl/job/">All</option>';
        foreach ($terms as $taxonomy) {
            $term_slug = $taxonomy->slug;
            $term_link = get_term_link($taxonomy->term_id, 'job_category');
            $selected = ($taxonomy->term_id == $query_id)?'selected':'';
            echo '<option value="' . $term_link . '" '.$selected.'>' . $taxonomy->name . '</option>';
            if (false) {
                ?>
                <ul class="classifieds-ul">
                    <li class="classifieds-li">
                        <h3 class="classifieds-cat">
                            <a href="<?php echo $term_link; ?>" title="<?php echo $taxonomy->name; ?>"><?php echo $taxonomy->name; ?> <span class="classifieds-count">(<?php echo $taxonomy->count; ?>)</span></a>
                        </h3>
                    </li>
                </ul>
                <?php
            }
        } echo '</select></div>';
        ?>
        <?php
        $type_args = array(
//            'orderby' => 'term_id',
//            'orderby' => 'count',
//            'order' => 'DESC',
            'hide_empty' => true,
        );

        $types = get_terms('job_type', $type_args);
        echo '<div class="col-lg-6"><h4>Types of employment</h4><select class="dynamic_select"><option value="https://dev.nashapolsha.pl/job/">All</option>';
        foreach ($types as $taxonomy) {
            $term_slug = $taxonomy->slug;
            $term_link = get_term_link($taxonomy->term_id, 'job_type');
            $selected = ($taxonomy->term_id == $query_id)?'selected':'';
            echo '<option value="' . $term_link . '" '.$selected.'>' . $taxonomy->name . '</option>';
        } echo '</select></div>';
        ?>
    </div>
</section>
<?php if (false) { ?>
    <section id="classified_tags_widget" class="widget widget_tag_cloud">
        <?php
        if (function_exists('wp_tag_cloud')) {
            echo '<h3 class="widget-title">Types of employment</h3><div class="tagcloud">';
            wp_tag_cloud(array(
                'smallest' => 8,
                'largest' => 8,
                'unit' => 'pt',
                'number' => 45,
                'format' => 'flat',
                'separator' => "\n",
                'orderby' => 'count',
                'order' => 'DESC',
                'exclude' => null,
                'include' => null,
                'link' => 'view',
                'taxonomy' => 'job_type',
                'echo' => true,
                'show_count' => true,
//	'topic_count_text_callback' => 'default_topic_count_text',
            ));
            echo '</div>';
        }
        ?>
    </section>
<?php } ?>