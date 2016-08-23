<?php
	$prefix = 'schools_';

	$meta_boxes[] = array(
		'id'         => 'standard',
		'title'      => esc_html__( 'Standard Fields', 'your-prefix' ),

		'post_types' => array( 'schools' ),
		'context'    => 'normal',
		'priority'   => 'high',
		'autosave'   => true,
		'fields'     => array(
			// TEXT
			array(
				// Field name - Will be used as label
				'name'  => esc_html__( 'Score Min', '{$prefix}' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}score_min",
				// Field description (optional)
				'desc'  => esc_html__( 'Score Minimum for seach purposes.', '{$prefix}' ),
				'type'  => 'text',
				// Default value (optional)
				'std'   => esc_html__( 'Default text value', 'your-prefix' ),
				// CLONES: Add to make the field cloneable (i.e. have multiple value)
				'clone' => false,
			),
			// TEXT
			array(
				// Field name - Will be used as label
				'name'  => esc_html__( 'Score Max', '{$prefix}' ),
				// Field ID, i.e. the meta key
				'id'    => "{$prefix}score_max",
				// Field description (optional)
				'desc'  => esc_html__( 'Score Maximum for seach purposes.', '{$prefix}' ),
				'type'  => 'text',
				// Default value (optional)
				'std'   => esc_html__( 'Default text value', 'your-prefix' ),
				// CLONES: Add to make the field cloneable (i.e. have multiple value)
				'clone' => false,
			),
		)
	);

	return $meta_boxes;