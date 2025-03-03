<?php

use App\Models\Attendee;
use App\Models\Event;
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
        Schema::create('attendee_event', function (Blueprint $table) {
            // Lascio l'id, anche se volendo è superfluo, potremmo usare come primary key l'accoppiata evnto-partecipante id
            $table->id();

            $table->foreignIdFor(Attendee::class);
            $table->foreignIdFor(Event::class);

            // Lascio i timestamps per tenere traccia di quando un utente si iscrive a un evento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendee_event');
    }
};
