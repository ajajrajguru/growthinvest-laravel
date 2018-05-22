<?php

return [
	'disk_name' => 's3',
	'base_root_path' => '',
	'default_base_path' => 'other_files',
	'valid_image_formats' => ['jpg', 'png', 'jpeg', 'gif'],
	'valid_file_formats' => ['jpg', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'png', 'pdf', 'ppt', 'pptx', 'pps', 'ppsx','txt'],
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
		'thumb_2_58x1' => [
			'width' => 150,
			'height' => 58,
				],
		'medium_2_58x1' => [
			'width' => 300,
			'height' => 116,
				],
		'large_2_58x1' => [
			'width' => 1024,
			'height' => 396,
				],

	],
	'model' => [
		'App\User' => [
			'base_path' => 'user',
			'slug_column' => 'gi_code',
			'sizes' => 
				[
					'profile_picture' =>['thumb_1x1','medium_1x1','large_1x1'],
					'company_logo' =>['thumb_1x1','medium_1x1','large_1x1'],
				]
		],
		'App\Firm' => [
			'base_path' => 'firm',
			'slug_column' => 'gi_code',
			'sizes' => [
					'firm_logo' =>['thumb_1x1','medium_1x1','large_1x1'],
					'background_image' =>['thumb_2_58x1','medium_2_58x1','large_2_58x1'],
				]
		],
		'App\TransferAsset' => [
			'base_path' => 'transferasset',
			'slug_column' => 'id',
			
		],
		'App\BusinessListing' => [
			'base_path' => 'business',
			'slug_column' => 'gi_code',
			'sizes' => 
			[
				'team_member_picture' =>['thumb_1x1','medium_1x1','large_1x1'],
				'business_logo' =>['thumb_1x1','medium_1x1','large_1x1'],
				'business_background_image' =>['thumb_2_58x1','medium_2_58x1','large_2_58x1'],
			]
			
		],
	],
];