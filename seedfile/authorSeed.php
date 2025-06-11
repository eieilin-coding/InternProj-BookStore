<?php

include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\AuthorsTable;
use Faker\Factory as Faker;

$faker = Faker::create();
$table = new AuthorsTable(new MySQL);

echo "Data seeding started..<br>";
for($i=0; $i<15; $i++) {
    $table->insertAuthor([
        "name" => $faker->name,
        "email" => $faker->email,
        "phone" => $faker->phoneNumber,
        "address" => $faker->address,
    ]);
}

echo "Data seeding completed.";