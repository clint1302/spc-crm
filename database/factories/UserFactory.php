<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
 */

$factory->define(App\User::class, function (Faker $faker) {
	static $password;

	return [
		'created_by' => 1,
		'name' => $faker->name,
		'email' => $faker->unique()->safeEmail,
		'password' => $password ?: $password = bcrypt('demo'),
		'present_address' => $faker->address,
		'permanent_address' => $faker->address,
		'contact_no_one' => $faker->phoneNumber,
		'web' => $faker->url,
		'gender' => $faker->randomElement(array('m', 'f')),
		'date_of_birth' => $faker->date($format = 'Y-m-d', $max = '2000-12-31'),
		/*'avatar' => $faker->image($dir = null, $width = 640, $height = 480, $category = null, $fullPath = true, $randomize = true, $word = null),*/
		'client_type_id' => $faker->numberBetween($min = 1, $max = 10),
		'designation_id' => $faker->numberBetween($min = 1, $max = 10),
		'access_label' => $faker->numberBetween($min = 1, $max = 5),
		'remember_token' => str_random(10),
	];
});

$factory->define(App\ClientType::class, function (Faker $faker) {

	return [
		'created_by' => 1,
		'client_type' => $faker->unique()->word,
		'client_type_description' => $faker->paragraph,
		'publication_status' => $faker->numberBetween($min = 0, $max = 1),
	];
});

$factory->define(App\JobType::class, function (Faker $faker) {

	return [
		'created_by' => 1,
		'job_type' => $faker->unique()->jobTitle,
		'job_type_description' => $faker->paragraph,
		'publication_status' => $faker->numberBetween($min = 0, $max = 1),
	];
});

$factory->define(App\Designation::class, function (Faker $faker) {

	return [
		'created_by' => 1,
		'designation' => $faker->unique()->company,
		'department_id' => $faker->numberBetween($min = 1, $max = 5),
		'designation_description' => $faker->text($maxNbChars = 500),
		'publication_status' => $faker->numberBetween($min = 0, $max = 1),
	];
});

$factory->define(App\Department::class, function (Faker $faker) {

	return [
		'created_by' => 1,
		'department' => $faker->unique()->company,
		'department_description' => $faker->text($maxNbChars = 500),
		'publication_status' => $faker->numberBetween($min = 0, $max = 1),
	];
});

$factory->define(App\Payable::class, function (Faker $faker) {

	return [
		'created_by' => 1,
		'job_id' => $faker->numberBetween($min = 1, $max = 10),
		'payable_amount' => $faker->numberBetween($min = 40000, $max = 60000),
		'short_note' => 'Short Note..',
		'tax' => 0,
		'tax_method' => 1,
		'tax_amount' => 0,
	];
});

$factory->define(App\Discount::class, function (Faker $faker) {

	return [
		'created_by' => 1,
		'job_id' => $faker->numberBetween($min = 1, $max = 10),
		'discount_amount' => $faker->numberBetween($min = 5000, $max = 10000),
		'short_note' => 'Short Note..',
	];
});

$factory->define(App\Installment::class, function (Faker $faker) {

	return [
		'created_by' => 1,
		'job_id' => $faker->numberBetween($min = 1, $max = 10),
		'installment_name' => 'Installment Name',
		'installment_amount' => $faker->numberBetween($min = 1000, $max = 3000),
		'installment_method' => $faker->numberBetween($min = 1, $max = 2),
		'short_note' => 'Short Note..',
	];
});

$factory->define(App\Job::class, function (Faker $faker) {

	return [
		'created_by' => 1,
		'name_of_account' => $faker->name,
		'job_type' => $faker->numberBetween($min = 0, $max = 10),
		'client' => $faker->numberBetween($min = 0, $max = 10),
		'reference_by' => $faker->numberBetween($min = 0, $max = 10),
		'assign_to' => $faker->numberBetween($min = 0, $max = 10),
		'receiving_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
		'description' => $faker->text($maxNbChars = 500),
		'publication_status' => $faker->numberBetween($min = 0, $max = 1),
		'job_status' => $faker->numberBetween($min = 0, $max = 1),
	];
});
