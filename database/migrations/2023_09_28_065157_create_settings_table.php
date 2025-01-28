<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_logo')->nullable();
            $table->string('site_favicon')->nullable();
            $table->string('email')->nullable();
            $table->string('site_tagline')->nullable();
            $table->string('site_url')->nullable();
            $table->string('site_title')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('location')->nullable();
            $table->longText('content')->nullable();
            $table->longText('footer_text')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('insta_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('linked_url')->nullable();
            $table->longText('map')->nullable();
            $table->longText('copyright')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};