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
        Schema::table('patients', function (Blueprint $table) {
            // Nuevos campos médicos
            $table->text('current_medications')->nullable()->after('observations');
            $table->text('habits')->nullable()->after('current_medications');
            $table->string('blood_pressure')->nullable()->after('habits');
            $table->string('heart_rate')->nullable()->after('blood_pressure');
            $table->string('respiratory_rate')->nullable()->after('heart_rate');
            $table->string('temperature')->nullable()->after('respiratory_rate');

            // Contactos de emergencia adicionales
            $table->string('emergency_contact_name2')->nullable()->after('emergency_contact_relationship');
            $table->string('emergency_contact_phone2')->nullable()->after('emergency_contact_name2');
            $table->string('emergency_contact_relationship2')->nullable()->after('emergency_contact_phone2');

            $table->string('emergency_contact_name3')->nullable()->after('emergency_contact_relationship2');
            $table->string('emergency_contact_phone3')->nullable()->after('emergency_contact_name3');
            $table->string('emergency_contact_relationship3')->nullable()->after('emergency_contact_phone3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn([
                'current_medications',
                'habits',
                'blood_pressure',
                'heart_rate',
                'respiratory_rate',
                'temperature',
                'emergency_contact_name2',
                'emergency_contact_phone2',
                'emergency_contact_relationship2',
                'emergency_contact_name3',
                'emergency_contact_phone3',
                'emergency_contact_relationship3',
            ]);
        });
    }
};
