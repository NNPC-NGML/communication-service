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
        Schema::create('email_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('receiver')->comment("customer name eg Dangoto Industry!");
            $table->longText('message_body')->comment("email message body");
            $table->string('subject')->comment("email message subject");
            $table->string('email')->comment("email address to be sent a mail");
            $table->string('link')->nullable()->comment("Email clickable link if any");
            $table->boolean('status')->default(true)->comment("Email delivery status (true when delivered and false when failed)");
            $table->longText('error_message')->nullable()->comment("error message from failed email");
            $table->longText('error_stack_trace')->nullable()->comment("error trace from failed email");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_notifications');
    }
};
