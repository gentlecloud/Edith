<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('edith_attachment_uses', function (Blueprint $table) {
            $table->id();
            $table->string('attchment_id');
            $table->string('model');
            $table->string('model_id');
            $table->unique(['attchment_id', 'model', 'model_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edith_attachment_uses');
    }
};
