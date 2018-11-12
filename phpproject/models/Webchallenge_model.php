<?php
/**
 * Created by PhpStorm.
 * User: kev
 * Date: 10/11/2018
 * Time: 20:32
 */

class Webchallenge_model extends Model
{
    function __construct()
    {
        parent::__construct();
    }

    function getdata($id)
    {
        $sql = "SELECT * FROM web_challenge WHERE id>=$id order by id desc limit 0,100";
        $result = $this->conn->query($sql);
        $data = [];
        if ($result->num_rows > 0)
        {
            while ($row = $result->fetch_assoc())
            {
                $temp = [];
                foreach ($row as $key => $value)
                {
                    if (in_array($key, ["rich_data", "raw_data", "response"], True)) {
                        $temp[$key] = trim(base64_decode($value));
                    }else{
                        $temp[$key] = $value;
                    }
                }
                array_push($data, $temp);
            }
        }
        return $data;
    }
}