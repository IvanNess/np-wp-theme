<?php
/**
 * The Template for displaying all single quizs
 *
 */
get_header();
?>

<?php
//create full width template
kleo_switch_layout('no');
add_filter('kleo_main_container_class', 'kleo_ret_full_container');
get_template_part('page-parts/general-title-section');
?>
<div class="page_test_top">
    <?php
    $sub_title = get_field('sub_title');
    if (!empty($sub_title)) {
        echo '<h2>' . $sub_title . '</h2>';
    } else {
        echo '<h2> </h2>';
    }
    ?>
    <div class="page_test_sub_title">
        <div class="page_test_sub_title_box">
            <h4>Today about:</h4>
            <h3><?php echo the_title(); ?></h3>
        </div>
    </div>
</div>
<style>
    .article-meta {
        display: none;
    }
    .article-media img {
        visibility: hidden;
        height: 1px;
    }
    h1 {display: none;}
</style>
<div class="page_test_content">
    <?php
    get_template_part('page-parts/general-before-wrap');
    while (have_posts()) : the_post();
        if (false) {
            echo '<h5>Choose the correct answer to the question:</h5>';
            get_template_part('content', get_post_format());
        } else {
            ?>
            <div class="wq_questionsCtr">
                <div id="quiz">
                    <div id="quiz-header">
                        <!--<h1>jQuery Quiz Plugin</h1>-->
                        <p class="faded">Choose the correct answer to the question:</p>
                    </div>
                    <div id="quiz-start-screen">
                        <p><a href="#" id="quiz-start-btn" class="quiz-button btn letter-spacing-2px btn-highlight text-uppercase">Start</a></p>
                    </div>
                </div>
                <div id="quiz-results_btn" class="quiz-container">
                    <?php
                    echo get_field('quiz_result');
                    $quiz_dop_link = get_field('quiz_dop_link');
                    if (!empty($quiz_dop_link)) {
                        echo '<p>Learn more</p>';
                        echo '<p>Follow the <a href="' . $quiz_dop_link . '" class="btn btn-highlight">link</a></p>';
                    }
                    ?>
                </div>
            </div>
            <script>
                (function ($) {
                    "use strict";
                    $(document).ready(function () {
                        $('#quiz').quiz({
                            // allows incorrect options
                            allowIncorrect: true,
                            // counter settings
                            counter: true,
                            //  counterFormat: '%current/%total',
                            // default selectors & format
                            //  startScreen: '#quiz-start-screen',
                            //  startButton: '#quiz-start-btn',
                            //  homeButton: '#quiz-home-btn',
                            //  resultsScreen: '#quiz-results-screen',
                            resultsFormat: 'You answered correctly %score of %total correct!',
                            gameOverScreen: '#quiz-gameover-screen',
                            // button text
                            nextButtonText: 'Further',
                            finishButtonText: 'Finish',
                            restartButtonText: 'Restart',
                            counterFormat: 'Question %current of %total',
                            finishCallback: function () {
                                $('#quiz-results_btn').fadeIn();
                            },
                            questions: [
        <?php
        $question_and_answer = get_field('question_and_answer');
        if ($question_and_answer) {
            foreach ($question_and_answer as $qa) {
                echo '{"q": "' . $qa['question'] . '",';
                echo '"options": [';
                $i = 0;
                foreach ($qa['answers'] as $a) {
                    $i++;
                    if (!empty($a['answer_true']) && $a['answer_true'] == 1) {
                        $correct = $i;
                    }
                    echo '"' . $a['answer'] . '",';
                }
                echo '],';
                echo '"correctIndex": ' . $correct . ',
"correctResponse": "Right!",
"incorrectResponse": "Wrong!"},';
            }
        }
        ?>
                            ]
                        });
                        $('#quiz-restart-btn').click(function () {
                            $('#quiz-results_btn').fadeOut();
                        });
                    });
                })(jQuery);
            </script> 
            <?php
        }
    endwhile;
    ?>
</div>
<?php
//echo do_shortcode('[kleo_social_share]');
get_template_part('page-parts/general-after-wrap');
get_footer();
