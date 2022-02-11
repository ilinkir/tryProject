<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTables extends Migration
{
    private $tables = [
        'News',
        'Images',
        'Categories',
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->tables as $table) {
            if (method_exists($this, $method = "up{$table}")) {
                $this->{$method}();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->tables as $table) {
            if (method_exists($this, $method = "down{$table}")) {
                $this->{$method}();
            }
        }
    }

    private function upNews()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 100);
            $table->string('code', 50)->unique();
            $table->string('preview_text', 255)->nullable();
            $table->text('text')->nullable();
            $table->uuid('image_id')->nullable();
            $table->uuid('category_id')->nullable();
            $table->boolean('is_active')->default('true');
            $table->smallInteger('sort')->default(500);
            $table->timestamps();
        });
    }

    private function downNews()
    {
        Schema::dropIfExists('news');
    }

    private function upImages()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('url', 255);
            $table->string('alt', 150)->nullable();
            $table->string('description', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    private function downImages()
    {
        Schema::dropIfExists('images');
    }

    private function upCategories()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 255);
            $table->string('description', 1000)->nullable();
            $table->string('code')->unique();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    private function downCategories()
    {
        Schema::dropIfExists('categories');
    }
}
