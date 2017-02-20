<?php

$table= 'forum_config';
db()
    ->dropTable( $table )
    ->createTable( $table )
    ->add('id', 'varchar', 64)
    ->add('name', 'varchar', 128)
    ->add('description', 'LONGTEXT')
    ->unique( 'id');





$table= 'forum_data';
db()
    ->dropTable( $table )
    ->createTable( $table )
    ->add('user_idx', 'INT UNSIGNED DEFAULT 0')
    ->add('config_idx', 'INT')
    ->add('title', 'varchar', 256)
    ->add('content', 'LONGTEXT')
    ->index( 'user_idx');


