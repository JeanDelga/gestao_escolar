<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notas', function (Blueprint $table) {
            // Remover a foreign key
            $table->dropForeign(['curso_id']);

            // Agora pode remover a coluna
            $table->dropColumn('curso_id');
        });
    }

    public function down(): void
    {
        Schema::table('notas', function (Blueprint $table) {
            $table->unsignedBigInteger('curso_id')->nullable();

            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
        });
    }
};
