@php
echo '<?php';
@endphp

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{$tableName}}', function (Blueprint $table) {
@foreach ($fields as $field)
    // $table->{{$field->migrationType->value}}({{$field->fieldName}});
@endforeach
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('{{$tableName}}');
    }
};
