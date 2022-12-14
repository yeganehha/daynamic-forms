<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Yeganehha\DynamicForm\DefineProperty;

class CreateDynamicFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config(DefineProperty::$configFile.'.database.table_name.form'), function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('model')->nullable();
            $table->boolean('external_table')->default(0);
            $table->timestamps();
        });
        Schema::create(config(DefineProperty::$configFile.'.database.table_name.field'), function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id');
            $table->foreign('form_id')->on(config(DefineProperty::$configFile.'.database.table_name.form'))->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->text('label')->nullable();
            $table->text('description')->nullable();
            $table->string('font_icon')->nullable();
            $table->text('value')->nullable();
            $table->json('validate')->nullable();
            $table->string('type_variable')->default(\Yeganehha\DynamicForm\Fields\TextField::class);
            $table->enum('status',['show','hidden','required'])->default('show');
            $table->integer('order_number')->default(2147483647);
            $table->string('class')->nullable();
            $table->string('style')->nullable();
            $table->json('field_attributes')->nullable();
            $table->json('additional_data')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->on(config(DefineProperty::$configFile.'.database.table_name.field'))->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create(config(DefineProperty::$configFile.'.database.table_name.value'), function (Blueprint $table) {
            $table->unsignedBigInteger('field_id');
            $table->foreign('field_id')->on(config(DefineProperty::$configFile.'.database.table_name.field'))->references('id')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('fieldable_id');
            $table->string('fieldable_type');
            $table->text('value')->nullable();
            $table->primary(['field_id', 'fieldable_id' , 'fieldable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config(DefineProperty::$configFile.'.database.table_name.value'));
        Schema::dropIfExists(config(DefineProperty::$configFile.'.database.table_name.field'));
        Schema::dropIfExists(config(DefineProperty::$configFile.'.database.table_name.form'));
    }
}
