<?php

use App\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$permissions = [
			[
				'name' => 'crm-setting',
				'display_name' => 'CRM Setting',
				'description' => 'CRM Setting Details',
			],
			[
				'name' => 'role',
				'display_name' => 'Role Setting',
				'description' => 'Role Setting Details',
			],
			[
				'name' => 'our-team',
				'display_name' => 'Our Team',
				'description' => 'Our Team',
			],
			[
				'name' => 'manage-team',
				'display_name' => 'Manage team',
				'description' => 'Manage team',
			],
			[
				'name' => 'manage-clients',
				'display_name' => 'Manage clients',
				'description' => 'Manage clients',
			],
			[
				'name' => 'manage-references',
				'display_name' => 'Manage references',
				'description' => 'Manage references',
			],
			[
				'name' => 'jobs',
				'display_name' => 'Jobs',
				'description' => 'Jobs',
			],
			[
				'name' => 'manage-jobs',
				'display_name' => 'Manage jobs',
				'description' => 'Manage jobs',
			],
			[
				'name' => 'my-jobs',
				'display_name' => 'My jobs',
				'description' => 'My jobs',
			],
			[
				'name' => 'report',
				'display_name' => 'Report',
				'description' => 'Report',
			],
			[
				'name' => 'account-report',
				'display_name' => 'Account Report',
				'description' => 'Account Report',
			],
			[
				'name' => 'job-report',
				'display_name' => 'Job Report',
				'description' => 'Job Report',
			],
			[
				'name' => 'task-report',
				'display_name' => 'Task Report',
				'description' => 'Task Report',
			],
			[
				'name' => 'file-upload',
				'display_name' => 'File Upload',
				'description' => 'File Upload',
			],
			[
				'name' => 'bill',
				'display_name' => 'Bill',
				'description' => 'Bill',
			],
			[
				'name' => 'sms',
				'display_name' => 'SMS',
				'description' => 'SMS',
			],
			[
				'name' => 'appointment',
				'display_name' => 'Manage Appointment',
				'description' => 'Manage Appointment',
			],
		];

		foreach ($permissions as $key => $value) {
			Permission::create($value);
		}
	}
}
