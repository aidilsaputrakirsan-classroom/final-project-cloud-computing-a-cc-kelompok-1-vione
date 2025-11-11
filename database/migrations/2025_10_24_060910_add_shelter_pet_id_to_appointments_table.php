<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            // ✅ new column for shelter pets
            $table->unsignedBigInteger('shelter_pet_id')->nullable()->after('pet_id');

            // ✅ foreign key toward adoption_pets
           $table->foreign('shelter_pet_id')
      ->references('id')
      ->on('shelter_pets') // ✅ Corrected table name
      ->onDelete('set null');

        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['shelter_pet_id']);
            $table->dropColumn('shelter_pet_id');
        });
    }
};
