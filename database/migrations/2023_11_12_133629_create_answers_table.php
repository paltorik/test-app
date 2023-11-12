<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->json('schema');

            $table->unsignedInteger('candidate_id')->index();
            $table->foreign('candidate_id')
                ->references('id')
                ->on('candidates')
                ->cascadeOnDelete();

            $table->unsignedInteger('questioner_id')->index();
            $table->foreign('questioner_id')
                ->references('id')
                ->on('questioners')
                ->cascadeOnDelete();

            $table->index(['candidate_id','questioner_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answers');
    }
};
