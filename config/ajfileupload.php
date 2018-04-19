<?php

return [
	'disk_name' => 's3',
	'base_root_path' => '',
	'default_base_path' => 'other_files',
	'valid_image_formats' => ['jpg', 'png', 'jpeg', 'gif'],
	'valid_file_formats' => ['jpg', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'png', 'pdf', 'ppt', 'pptx', 'pps', 'ppsx'],
	'sizes' => [
		'thumb_1x1' => [
			'width' => 150,
			'height' => 150,
				],
		'medium_1x1' => [
			'width' => 300,
			'height' => 300,
				],
		'large_1x1' => [
			'width' => 1024,
			'height' => 1024,
				],

	],
	'model' => [
		'App\User' => [
			'base_path' => 'user',
			'slug_column' => 'gi_code',
			'sizes' => ['thumb_1x1','medium_1x1','large_1x1']
		],
	],
];