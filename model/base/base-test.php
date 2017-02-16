<?php


$meta = meta(); // get meta


// insert/create a meta.
test( $meta->getTable() == 'meta', 'base::setTable()');
$re = $meta->insert(['model'=>'testBase', 'model_idx'=>1, 'code'=>'testCode', 'data'=>'testData']);
$idx = &$re;
test( $re > 0, "base::create() - meta data create: idx=$re, " . error_string( $re ));



// count test.
$cond = " model='testBase' AND model_idx=1 AND code='testCode' ";
$count = $meta->count( $cond );
test( $count > 0, "base::count() - $count");
test( $meta->countAll() >= $count, "base::countAll()");


// load
$record = $meta->load( $idx );
test ( $record, "Loading a meta. idx: $idx");
test ( $record['data'] == 'testData', "meta data check" );

// update
$meta->update( ['data' => 'new data'] );
$updated = $meta->reload();
test( $record['idx'] == $updated['idx'], "meta updated" );
test( $updated['data'] == 'new data', "data updated" );


// delete
$meta->destroy();

// load again,
$record = $meta->load( $record['idx'] );

test( empty($record), "meta data destroyed");


