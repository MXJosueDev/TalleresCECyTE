<?php

namespace MXJosueDev\TalleresCecyte\lib;

use Dotenv\Dotenv;
use Exception;

class DB
{
    const QUERIES = [
        "register_commentary" => "INSERT INTO `commentary`(`commentary`, `client_ip`) VALUES (?, ?)",
        "register_record" => "INSERT INTO `record`(`workshop_id`, `control_number`, `name`, `last_name`, `sex`, `career_id`, `semester`, `group`) VALUES (?,?,?,?,?,?,?,?)",
        "get_all_workshops_data" => "SELECT `w`.`workshop_id`, `w`.`name` AS workshop_name, `w`.`image_url`, `w`.`max_capacity`, `w`.`registered`, `t`.`teacher_id`, `t`.`name` AS teacher_name, `t`.`last_name` FROM `workshop_view` w JOIN `teacher` t ON `t`.`teacher_id` = `w`.`teacher_id`;",
        "get_all_records" => "SELECT `r`.`record_id`, `r`.`control_number`, `r`.`name` AS student_name, `r`.`last_name`, `r`.`sex`, `r`.`semester`, `r`.`group`, `r`.`register_date`, `c`.`career_id`, `c`.`name` AS career_name, `c`.`short_name` FROM `record` r JOIN `career` c ON `c`.`career_id` = `r`.`career_id` WHERE `r`.`workshop_id` = ? ORDER BY `r`.`last_name` ASC, `r`.`name` ASC",
        "get_workshop_data" => "SELECT `w`.`workshop_id`, `w`.`name` AS workshop_name, `w`.`image_url`, `w`.`max_capacity`, `w`.`registered`, `t`.`teacher_id`, `t`.`name` AS teacher_name, `t`.`last_name` FROM `workshop_view` w JOIN `teacher` t ON `t`.`teacher_id` = `w`.`teacher_id` WHERE `w`.`workshop_id` = ?;",
        "get_carieers" => "SELECT * FROM `career`;"
    ];

    private \mysqli|false $conn;

    public function __construct()
    {
        $env = Dotenv::createImmutable(__DIR__ . "/../../");
        $env->load();

        $hostname = $_ENV["HOSTNAME"] ?? "";
        $username = $_ENV["USERNAME"] ?? "";
        $password = $_ENV["PASSWORD"] ?? "";
        $database = $_ENV["DATABASE"] ?? "";
        $port = $_ENV["PORT"] ?? 3306;

        try {
            $this->conn = new \mysqli($hostname, $username, $password, $database, $port);
        } catch (Exception $exception) {
            $this->conn = false;
        }
    }

    public function getConnection(): \mysqli|false
    {
        if ($this->conn instanceof \mysqli) {
            if ($this->conn->connect_error || !$this->conn->ping()) {
                return false;
            }
        }

        return $this->conn;
    }
}
