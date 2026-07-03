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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            // Categories டேபிளுடன் இணைக்கும் ஃபாரின் கீ (Optional என்பதால் nullable செய்யப்பட்டுள்ளது)
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            
            $table->string('title');        // புத்தகத்தின் பெயர்
            $table->string('author');       // ஆசிரியர் பெயர்
            $table->text('description')->nullable(); // புத்தக விளக்கம்
            
            // விலை: 8 எண்கள் மற்றும் 2 தசம எண்கள் வரை அனுமதிக்கப்படும் (எ.கா: 999999.99)
            $table->decimal('price', 8, 2); 
            
            // இருப்பு நிலை: 1 = கையிருப்பில் உள்ளது (Available), 0 = இல்லை
            $table->boolean('is_available')->default(true); 
            
            $table->timestamps(); // created_at மற்றும் updated_at காலம்கள்
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};