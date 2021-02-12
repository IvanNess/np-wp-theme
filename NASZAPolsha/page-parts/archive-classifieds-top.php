<div class="archive-description"><strong>Ads for available vacancies are placed exclusively in the section "<a href="https://dev.nashapolsha.pl/my-jobs/add-job">Work in Poland</a>"
    <br>Oferty pracy są ogłaszane wyłącznie w sekcji „<a href="https://dev.nashapolsha.pl/my-jobs/add-job">Praca w Polsce</a>”.</strong></div>
<section id="classifieds_categories_widget" class="widget" style="margin-bottom: 20px">
    <div class="classifieds-row">
        <a class="btn letter-spacing-2px btn-highlight text-uppercase btn_add_classified" href="https://dev.nashapolsha.pl/my-classifieds/add-classified">+ Add an ad</a>
        <h2 class="classifieds-title">Advertisements</h2>
        <?php
//        $obj = get_queried_object();
        $query_id = get_queried_object_id();
        $cat_args = array(
//            'orderby' => 'term_id',
//            'orderby' => 'count',
//            'order' => 'DESC',
            'hide_empty' => true,
        );

        $terms = get_terms('classifiedcategory', $cat_args);
        echo '<div class="col-lg-6"><h4>Categories</h4><select class="dynamic_select"><option value="https://dev.nashapolsha.pl/classifieds/">All</option>';
        foreach ($terms as $taxonomy) {
            $term_slug = $taxonomy->slug;
            $term_link = get_term_link($taxonomy->term_id, 'classifiedcategory');
            $selected = ($taxonomy->term_id == $query_id) ? 'selected' : '';
            echo '<option value="' . $term_link . '" ' . $selected . '>' . $taxonomy->name . '</option>';
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
        $tag_args = array(
//            'orderby' => 'term_id',
//            'orderby' => 'count',
//            'order' => 'DESC',
            'hide_empty' => true,
        );

        $tags = get_terms('classified_tags', $tag_args);
        echo '<div class="col-lg-6"><h4>Міста</h4><select class="dynamic_select"><option value="https://dev.nashapolsha.pl/classifieds/">Усі</option>';
        foreach ($tags as $taxonomy) {
            $term_slug = $taxonomy->slug;
            $term_link = get_term_link($taxonomy->term_id, 'classified_tags');
            $selected = ($taxonomy->term_id == $query_id) ? 'selected' : '';
            echo '<option value="' . $term_link . '" ' . $selected . '>' . $taxonomy->name . '</option>';
        } echo '</select></div>';
        ?>
    </div>
</section>
<?php if (false) { ?>
    <section id="classified_tags_widget" class="widget widget_tag_cloud">
        <?php
        if (function_exists('wp_tag_cloud')) {
            echo '<h3 class="widget-title">Cities</h3><div class="tagcloud">';
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
                'taxonomy' => 'classified_tags',
                'echo' => true,
                'show_count' => true,
//	'topic_count_text_callback' => 'default_topic_count_text',
            ));
            echo '</div>';
        }
        ?>
    </section>
    <?php
}?>