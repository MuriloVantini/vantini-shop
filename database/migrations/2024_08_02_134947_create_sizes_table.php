<?php

use App\Models\Size;
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
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->char('name', 3);
            $table->timestamps();
        });
        Size::create(['name'=>'PP']);
        Size::create(['name'=>'P']);
        Size::create(['name'=>'M']);
        Size::create(['name'=>'G']);
        Size::create(['name'=>'GG']);
        Size::create(['name'=>'XG']);
        Size::create(['name'=>'XGG']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sizes');
    }
};
