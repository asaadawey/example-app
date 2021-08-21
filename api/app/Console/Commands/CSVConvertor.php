<?php

namespace App\Console\Commands;

use App\Utils\XMLUtils;
use Illuminate\Console\Command;

class CSVConvertor extends Command
{
    protected $default_save_path ;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'csv:convertor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Takes a CSV file as an input and then exports a json';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->default_save_path =resource_path();
        echo $this->default_save_path;
    }

    /**
     * A function that creates , writes and closes a file
     * @param string $file_path
     * @param string $data The data to put it in the new file
     * @param string $extension The created file extension to show it in the info message
     */
    function write_file(string $file_path,string $data,string $extension)
    {
        $f = fopen($file_path,"w");
        fwrite($f,$data);
        fclose($f);
        $this->info('Successfully written ' . $extension . ' file at ' . $file_path);
    }

    /**
     * A function that converts a JSON to XML and write it
     * @param array $data
     * @param string|null $file_path
     */
    function write_xml(array $data, string $file_path = null)
    {
        // Use the XML utils ckass
        $xml = XMLUtils::convert_xml($data);
        $new_file_name = $this->default_save_path . '\\xml\\data.xml';
        $this->write_file($new_file_name,$xml,'XML');

        if ($file_path != null)
            //Write file . The CLI will put the new file in the same sirectory as the CSV , so i will replace the csv with xml
            $this->write_file(str_replace('csv','xml',$file_path),$xml,'XML');
    }

    /**
     * A function that writes a JSON file
     * @param array $data
     * @param string|null $file_export_path
     */
    public function write_json(array $data,string $file_export_path = null)
    {
        $new_file_name = $this->default_save_path . '\\json\\data.json';
        $this->write_file($new_file_name,json_encode($data),'JSON');
        if ($file_export_path != null)
            $this->write_file(str_replace('csv','json',$file_export_path),json_encode($data),'JSON');

    }

    /**
     * A function that accepts a string and tries to convert it to the proper type
     * If it has decimal so will convert it to float
     * If its a number so to  int
     * Else to string
     * @param string $value
     * @return float|int|string
     */
    public function get_right_value(string $value)
    {
        $try_float = floatval($value);
        if ($try_float)
            // If the number is not equal the number after parsing it to float
            // E.g. 3.47 != intval(3.47)
            // So this means it's a float number
            //
            if (intval($try_float) != $try_float)
                return $try_float;
            else
                return intval($value);
        return $value;


    }

    /**
     * A function that accepts a file path as args and tries to convert the CSV file into a json array
     * @param string $file_path
     * @return array Return the CSV data as JSON array
     */
    public function get_csv_data(string $file_path)
    {
        //Read the file content as array using str_getcsv callback
        $csv = array_map('str_getcsv', file($file_path));
        $json_data = array();
        //Iterate over the array starting from index 1 , Because index 0 have only the table header
        for ($i = 1; $i < count($csv); $i++) {
            $arr = array();
            //Iterating over the every item of the array . Then assigns a new key to it
            for ($j = 0; $j < count($csv[0]); $j++) {
                $to_write = $csv[$i][$j];
                $arr[$csv[0][$j]] = $this->get_right_value($to_write);
            }

            array_push($json_data, $arr);
        }
        return $json_data;
    }
    /**
     * Checks if the file is correct and exist
     * @param $file_path string
     * @return bool
     */
    public function valid_file(string $file_path)
    {
        if (file_exists($file_path))
        {
            $last_three = substr($file_path,-3);
            if (strcmp($last_three, "csv") == 0)
                return true;
            return false;
        }
        return false;

    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Ask the user of the csv file
        $input = $this->ask("Please type the location of the CSV file");
        // If the file exists and valid then complete the program
        // Else view an error message
        if ($this->valid_file($input))
        {
            $can_export = $this->confirm("By default the CLI will export the result into ". $this->default_save_path ." \nDo you want to export the output file into " . $input . " location ?");
            //Read the csv data
            $data = $this->get_csv_data($input);
            //Write it as json
            $this->write_json($data,$can_export ? $input : null);
            //Write it as xml
            $this->write_xml($data,$can_export ? $input : null);
            return 0;
        }
        else
        {
            $this->info("The entered file path either not correct nor doesn't exist");
            return 1;
        }

    }
}
