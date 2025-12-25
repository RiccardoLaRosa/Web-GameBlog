<?php

use App\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Category::create([
            'name'=>'Azione'
        ]);
        Category::create([
            'name'=>'Avventura'
        ]);
        Category::create([
            'name'=>'Giochi di Ruolo (RPG)'
        ]);
        Category::create([
            'name'=>'Sparatutto'
        ]);
        Category::create([
            'name'=>'Strategia'
        ]);
        Category::create([
            'name'=>'Simulazione'
        ]);
        Category::create([
            'name'=>'Sportivi'
        ]);
        Category::create([
            'name'=>'Corse'
        ]);
        Category::create([
            'name'=>'Horror'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{}
};