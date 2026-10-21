<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('
            UPDATE schoolchat m
            JOIN (
            WITH RECURSIVE topic_messages AS (
                    SELECT id AS root_id, id AS child_id
                    FROM schoolchat
                    WHERE reply_to IS NULL
                
                    UNION ALL
                
                    SELECT a.root_id, m.id
                    FROM topic_messages a
                    JOIN schoolchat m ON m.reply_to = a.child_id
            )
            SELECT * FROM topic_messages WHERE root_id <> child_id
            ) t ON t.child_id = m.id
            SET m.reply_to = t.root_id;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
