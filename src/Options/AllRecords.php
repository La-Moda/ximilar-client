<?php
namespace Lamoda\Ximilar\Options;

class AllRecords
{
    /**
     * @var array fields_to_return with default value ["_id"]
     */
    public $fields_to_return = ['_id'];

    /**
     * @var array output_file_name name of the output (temporary) file, default: all-records-<temp_value>.json
     */
    public $output_file_name = null;

    /**
     * @var array records_to_answer if true, then the records are returned as a standard listing answer, default: true
     */
    public $records_to_answer = true;

    /**
     * @var array delete_file_after if true then the output file is deleted after the processing, default: true
     */
    public $delete_file_after = true;

    /**
     * @var array filter if the filter is set, not all records are returned but only those matching the filter
     */
    public $filter = null;
}
