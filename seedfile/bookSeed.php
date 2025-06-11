
<?php

include("../vendor/autoload.php");

use Libs\Database\MySQL;
use Libs\Database\BooksTable;
use Faker\Factory as Faker;

$faker = Faker::create();
$table = new BooksTable(new MySQL);

echo "Data seeding started..<br>";
for($i=0; $i<15; $i++) {
    $table->insertBook([
        "title" => $faker->sentence(mt_rand(3, 7)),
        "publisher" => $faker->name,
        "description" => $faker->realText(mt_rand(50, 100)),
        "photo" => "book.png",
        "file" => "See_You_at_the_Top.pdf",
    ]);
}

echo "Data seeding completed.";