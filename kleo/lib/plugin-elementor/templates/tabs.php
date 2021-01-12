<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class KleoElementorTabs extends Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve tabs widget name.
	 *
	 * @return string Widget name.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'kleo-tabs';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve tabs widget title.
	 *
	 * @return string Widget title.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_title() {
		return __( 'Tabs (Kleo)', 'kleo' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve tabs widget icon.
	 *
	 * @return string Widget icon.
	 * @since 1.0.0
	 * @access public
	 *
	 */
	public function get_icon() {
		return 'eicon-tabs';
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 * @since 2.1.0
	 * @access public
	 *
	 */
	public function get_keywords() {
		return [ 'tabs' ];
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the button widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @return array Widget categories.
	 * @since 2.0.0
	 * @access public
	 *
	 */
	public function get_categories() {
		return [ 'kleo-elements' ];
	}


	/**
	 * Register tabs widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_tabs',
			[
				'label' => __( 'Tabs', 'elementor' ),
			]
		);

		$this->add_control(
			'type',
			[
				'label' => __( 'Type', 'kleo' ),
				'type' => Controls_Manager::SELECT2,
				'options' => [
				        'tabs' => 'Tabs',
				        'pills' => 'Pills',
                ],
				'default'     => 'tabs',
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'kleo' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => 'Default',
					'square' => 'Square',
					'line' => 'Line',
					'text' => 'Text',
				],
				'default'     => 'default',
				'condition' => [
					'type' => 'tabs',
				],
			]
		);

		$this->add_control(
			'style_pills',
			[
				'label' => __( 'Style', 'kleo' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'square' => 'Square',
					'ghost' => 'Ghost',
				],
				'default'     => 'square',
				'condition' => [
					'type' => 'pills',
				],
			]
		);

		$this->add_control(
			'align',
			[
				'label' => __( 'Align', 'kleo' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => 'Left',
					'centered' => 'Centered',
				],
				'default'     => '',
			]
		);

		$this->add_control(
			'active_tab',
			[
				'label' => __( 'Active tab number', 'kleo' ),
				'type' => Controls_Manager::TEXT,
				'default'     => '1',
			]
		);

		$this->add_control(
			'no_tab_drop',
			[
				'label' => __( 'Disable tab drop', 'kleo' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off'    => esc_html__( 'Off', 'kleo' ),
				'label_on'     => esc_html__( 'On', 'kleo' ),
				'default'      => '',
				'return_value' => '1',
                'description' => 'Tab drop puts items that do not fit in the screen inside a drop-downn',
			]
		);

		$repeater = new Repeater();


		$repeater->add_control(
			'icon', [
				'label'       => __( 'Icon', 'seeko' ),
				'type'        => \Elementor\Controls_Manager::ICON,
				'default'     => '',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_title',
			[
				'label'       => __( 'Title & Content', 'elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => __( 'Tab Title', 'elementor' ),
				'placeholder' => __( 'Tab Title', 'elementor' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'tab_content',
			[
				'label'       => __( 'Content', 'elementor' ),
				'default'     => __( 'Tab Content', 'elementor' ),
				'placeholder' => __( 'Tab Content', 'elementor' ),
				'type'        => Controls_Manager::WYSIWYG,
				'show_label'  => false,
			]
		);

		$this->add_control(
			'tabs',
			[
				'label'       => __( 'Tabs Items', 'elementor' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[

						'tab_title'   => __( 'Tab #1', 'elementor' ),
						'tab_content' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor' ),
					],
					[

						'tab_title'   => __( 'Tab #2', 'elementor' ),
						'tab_content' => __( 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'elementor' ),
					],
				],
				'title_field' => '{{{ tab_title }}}',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render tabs widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$tabs     = $this->get_settings_for_display( 'tabs' );
		$settings = $this->get_settings();

		$id_int          = substr( $this->get_id_int(), 0, 3 );
		$wrapper_class   = [ 'nav' ];
		$wrapper_class[] = 'nav-' . $settings['type'];
		$wrapper_class[] = 'responsive-' . $settings['type'];
		$wrapper_class[] = $settings['type'] . '-style-' . $settings['style'];
		$wrapper_class[] = 'tabs-' . $settings['align'];

		if ( $settings['no_tab_drop'] ) {
			$wrapper_class[] = [ 'no-tabdrop' ];
		}

		$this->add_render_attribute( 'tab-wrapper', [
			'class' => $wrapper_class,
		] );

		$active_tab = (int) $settings['active_tab'] != 0 ? (int) $settings['active_tab'] : 1;

		?>
        <div class="kleo-elementor-tabs" role="tablist">
            <ul <?php $this->print_render_attribute_string( 'tab-wrapper' ); ?>>
				<?php
				foreach ( $tabs as $index => $item ) :
					$tab_count = $index + 1;

					$tab_title_setting_key = $this->get_repeater_setting_key( 'tab_title', 'tabs', $index );

					$this->add_render_attribute( $tab_title_setting_key, [
						'id'            => 'kleo-tab-' . $id_int . $tab_count,
						'class'         => [ 'kleo-tab-title' ],
						'href'          => '#tab-' . $id_int . $tab_count,
						'data-toggle'   => 'tab',
						'role'          => 'tab',
						'aria-controls' => 'tab-' . $id_int . $tab_count,
						'onclick'       => 'return false;',
					] );


					if ( $tab_count == $active_tab ) {
						$this->add_render_attribute( $tab_title_setting_key . '_li', [
							'class'         => [ 'active' ],
						] );
					}

					$this->add_render_attribute( $tab_title_setting_key . '_li', [
						'class'         => [ 'nav-item' ],
					] );

					$icon = '<i class="' . esc_attr( $item['icon'] ) . '"></i>';

					?>
                    <li <?php $this->print_render_attribute_string( $tab_title_setting_key . '_li' ); ?>>
                        <a <?php $this->print_render_attribute_string( $tab_title_setting_key ); ?>>
							<?php echo $icon; ?>
							<?php echo wp_kses_post( $item['tab_title'] ); ?>
                        </a>
                    </li>
				<?php endforeach; ?>
            </ul>

            <div class="tab-content">
				<?php
				foreach ( $tabs as $index => $item ) :
					$tab_count = $index + 1;

					$tab_content_setting_key = $this->get_repeater_setting_key( 'tab_content', 'tabs', $index );

					$this->add_render_attribute( $tab_content_setting_key . '_wrap', [
						'id'              => 'tab-' . $id_int . $tab_count,
						'class'           => [ 'tab-pane'/*, 'fade'*/ ],
						'role'            => 'tabpanel',
						'aria-labelledby' => 'kleo-tab-' . $id_int . $tab_count,
					] );

					if ( $tab_count === $active_tab ) {
						$this->add_render_attribute( $tab_content_setting_key . '_wrap', [
							'class' => [ 'active' ],
						] );
					}

					$this->add_inline_editing_attributes( $tab_content_setting_key, 'advanced' );
					?>
                    <div <?php $this->print_render_attribute_string( $tab_content_setting_key . '_wrap' ); ?>>

						<?php echo $this->parse_text_editor( $item['tab_content'] ); /* WPCS: XSS OK. */ ?>

                    </div>
				<?php endforeach; ?>
            </div>
        </div>
		<?php
	}
}
