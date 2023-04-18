<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->mediumText('title');
            $table->unsignedTinyInteger('no_of_vacancy')->nullable()->comment('null means not applicable');
            $table->mediumText('job_context')->nullable();
            $table->longText('responsibilities')->nullable();
            $table->double('salary_min')->nullable();
            $table->double('salary_max')->nullable();
            $table->boolean('is_negotiable')->nullable();
            $table->text('other_benefit')->nullable();
            $table->mediumText('special_instruction')->nullable();
            $table->date('deadline')->nullable();
            $table->json('resume_receiving_option')->nullable()->comment("{'apply_online',['email':{'address':test}, 'hard_copy: {instruction:please bring..}]");
            $table->boolean('is_profile_image')->nullable()->comment('Is image included in resume?');
            $table->unsignedTinyInteger('salary_type')->nullable()->comment('1=hourly, 2= daily, 3= monthly, 4= yearly');
            $table->boolean('is_display_salary')->nullable()->comment('Should display to employee? min max salary is required for filter');
            $table->mediumText('additional_salary_info')->nullable();
            $table->longText('additional_requirements')->nullable();
            $table->longText('other_qualification')->nullable();
            $table->boolean('is_experience_require')->default(0);
            $table->boolean('is_fresher_allowed')->default(0);
            $table->double('experience_min')->nullable();
            $table->double('experience_max')->nullable();
            $table->double('age_min')->nullable();
            $table->double('age_max')->nullable();
            $table->boolean('is_disability_allowed')->default(0);
            $table->string('company_name')->nullable();
            $table->boolean('is_visible_company_name')->default(1);
            $table->boolean('is_visible_address')->default(1);
            $table->boolean('is_visible_logo')->default(1);
            $table->boolean('is_visible_about')->default(1);
            $table->foreignId('job_listing_type_id')->default(1);
            $table->unsignedInteger('total_view')->default(0);
            $table->unsignedInteger('contact_id')->nullable();
            $table->unsignedInteger('language')->default(1)->comment('1=en, 2=bn');
            $table->tinyInteger('status')->default(0)->comment('0=draft, 1=pending, 2=published, 3=archive');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
