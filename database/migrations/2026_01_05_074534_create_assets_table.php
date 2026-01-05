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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_type'); // laptop, cpu, mac, monitor, keyboard, mouse, other
            $table->string('asset_id')->unique();
            $table->string('serial_number')->nullable();
            $table->string('model_name')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('cabinet_name')->nullable();
            $table->string('screen_size')->nullable();
            $table->string('resolution')->nullable();
            $table->string('hdmi_or_vga')->nullable();
            $table->string('ram')->nullable();
            $table->string('ram_model')->nullable();
            $table->string('ram_fsb')->nullable();
            $table->string('ssd')->nullable();
            $table->string('hard_disk')->nullable();
            $table->string('processor_company')->nullable();
            $table->string('processor')->nullable();
            $table->string('processor_generation')->nullable();
            $table->string('motherboard')->nullable();
            $table->string('motherboard_model')->nullable();
            $table->string('keyboard_type')->nullable(); // wired, bluetooth
            $table->string('mouse_type')->nullable(); // wired, bluetooth
            $table->string('title')->nullable(); // for other assets
            $table->date('purchase_date')->nullable();
            $table->string('vendor_name')->nullable();
            $table->string('purchase_type')->nullable();
            $table->string('emp_id')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
