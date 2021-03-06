<?php namespace Lasso\Adminsendmail\Updates;
use Schema;
use October\Rain\Database\Updates\Migration;
class UpdateEmailsAddAuthor extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('lasso_adminsendmail_emails', function ($table) {
            $table->integer('author_id')->unsigned()->index();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('lasso_adminsendmail_emails', function ($table) {
            $table->dropColumn("author_id");
        });
    }
}