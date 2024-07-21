<?php

namespace MXJosueDev\TalleresCecyte\lib\db;

use Exception;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBConnectException;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBException;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBExecuteException;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBInvalidQueryException;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBPrepareException;
use MXJosueDev\TalleresCecyte\lib\db\exception\DBResultException;
use MXJosueDev\TalleresCecyte\lib\Env;

class DB
{
    private static DB $db;

    public static function renderException(DBException $exception, bool $onlyText = false): void
    {
        global $dbException;
        $dbException = $exception;

        if (!$onlyText) {
            require __DIR__ . "/../../views/db/DBExceptionView.php";
        } else {
            require __DIR__ . "/../../components/db/DBExceptionText.php";
        }
    }

    public static function getGlobalConn(): \mysqli|false
    {
        if (!isset(self::$db)) {
            self::$db = new DB();
        }

        $conn = self::$db->getConnection();

        if (!$conn) throw new DBConnectException("No se pudo conectar a la base de datos.");

        return $conn;
    }

    public static function prepareStmt(string $queryKey, mixed ...$queryParams): \mysqli_stmt
    {
        if (!isset(self::QUERIES[$queryKey])) throw new DBInvalidQueryException("El query que especificaste no existe.");

        $stmt = self::getGlobalConn()->prepare(self::QUERIES[$queryKey]);

        if (!$stmt) throw new DBPrepareException("Ocurrio un error al preparar la consulta.");
        if (self::QUERIES_PARAMS[$queryKey] !== null) $stmt->bind_param(self::QUERIES_PARAMS[$queryKey], ...$queryParams);

        return $stmt;
    }

    /**
     * @return array<\mysqli_stmt|\mysqli_result>
     */
    public static function query(string $queryKey, mixed ...$queryParams): array
    {
        $stmt = self::prepareStmt($queryKey, ...$queryParams);

        try {
            if (!$stmt->execute()) throw new DBExecuteException("No se pudo ejecutar la consulta en la base de datos.");
        } catch (Exception $exception) {
            throw new DBExecuteException("No se pudo ejecutar la consulta en la base de datos.");
        }

        $result = $stmt->get_result();
        if (!$result) throw new DBResultException("No se pudo obtener el resultado de la consulta.");

        return [$stmt, $result];
    }

    public static function endQuery(\mysqli_stmt $stmt, \mysqli_result $result): void
    {
        $stmt->close();
        $result->close();
    }

    // Static Queries
    public static function registerCommentary(string $commentary, string $clientIp)
    {
        [$stmt, $result] = self::query("register_commentary", $commentary, $clientIp);

        self::endQuery($stmt, $result);
    }

    public static function registerRecord(int $workshopId, string $controlNumber, string $name, string $lastName, string $sex, int $careerId, string $semester, string $group): void
    {
        [$stmt, $result] = self::query("register_record", $workshopId, $controlNumber, $name, $lastName, $sex, $careerId, $semester, $group);

        self::endQuery($stmt, $result);
    }

    public static function getAllWorkshops(): array
    {
        [$stmt, $result] = self::query("get_all_workshops");

        $data = $result->fetch_all(MYSQLI_ASSOC);

        self::endQuery($stmt, $result);

        return $data;
    }

    public static function getAllCommentaries(): array
    {
        [$stmt, $result] = self::query("get_all_commentaries");

        $data = $result->fetch_all(MYSQLI_ASSOC);

        self::endQuery($stmt, $result);

        return $data;
    }


    public static function getAllRecords(int $workshopId): array
    {
        [$stmt, $result] = self::query("get_all_records", $workshopId);

        $data = $result->fetch_all(MYSQLI_ASSOC);

        self::endQuery($stmt, $result);

        return $data;
    }

    public static function getWorkshop(int $workshopId): array
    {
        [$stmt, $result] = self::query("get_workshop", $workshopId);

        $data = $result->fetch_assoc();

        self::endQuery($stmt, $result);

        return $data;
    }

    public static function getCarieers(): array
    {
        [$stmt, $result] = self::query("get_carieers");

        $data = $result->fetch_all(MYSQLI_ASSOC);

        self::endQuery($stmt, $result);

        return $data;
    }

    const QUERIES = [
        "register_commentary" => "INSERT INTO `commentary`(`commentary`, `client_ip`) VALUES (?, ?)",
        "register_record" => "INSERT INTO `record`(`workshop_id`, `control_number`, `name`, `last_name`, `sex`, `career_id`, `semester`, `group`) VALUES (?,?,?,?,?,?,?,?)",
        "get_all_workshops" => "SELECT `w`.`workshop_id`, `w`.`name` AS workshop_name, `w`.`image_url`, `w`.`max_capacity`, `w`.`registered`, `t`.`teacher_id`, `t`.`name` AS teacher_name, `t`.`last_name` FROM `workshop_view` w JOIN `teacher` t ON `t`.`teacher_id` = `w`.`teacher_id`;",
        "get_all_commentaries" => "SELECT * FROM commentary;",
        "get_all_records" => "SELECT `r`.`record_id`, `r`.`control_number`, `r`.`name` AS student_name, `r`.`last_name`, `r`.`sex`, `r`.`semester`, `r`.`group`, `r`.`register_date`, `c`.`career_id`, `c`.`name` AS career_name, `c`.`short_name` FROM `record` r JOIN `career` c ON `c`.`career_id` = `r`.`career_id` WHERE `r`.`workshop_id` = ? ORDER BY `r`.`last_name` ASC, `r`.`name` ASC",
        "get_workshop" => "SELECT `w`.`workshop_id`, `w`.`name` AS workshop_name, `w`.`image_url`, `w`.`max_capacity`, `w`.`registered`, `t`.`teacher_id`, `t`.`name` AS teacher_name, `t`.`last_name` FROM `workshop_view` w JOIN `teacher` t ON `t`.`teacher_id` = `w`.`teacher_id` WHERE `w`.`workshop_id` = ?;",
        "get_carieers" => "SELECT * FROM `career`;"
    ];

    const QUERIES_PARAMS = [
        "register_commentary" => "ss",
        "register_record" => "issssiss",
        "get_all_workshops" => null,
        "get_all_commentaries" => null,
        "get_all_records" => "i",
        "get_workshop" => "i",
        "get_carieers" => null
    ];

    private \mysqli|false $conn;

    public function __construct()
    {
        $this->reconnect();
    }

    public function getConnection(): \mysqli|false
    {
        if ($this->conn instanceof \mysqli) {
            if ($this->conn->connect_error || !$this->conn->ping()) {
                return $this->reconnect();
            }
        }

        return $this->conn;
    }

    private function reconnect(): \mysqli|false
    {
        $hostname = Env::getenv("DB_PORT_3306_TCP_ADDR") ?? Env::getenv("DB_HOST");
        $username = Env::getenv("DB_USER") ?? "root";
        $password = Env::getenv("DB_ENV_MARIADB_ROOT_PASSWORD") ?? Env::getenv("DB_PASSWORD");
        $database = Env::getenv("DB_DATABASE") ?? "talleres"; // Need at run
        $port = Env::getenv("DB_PORT_3306_TCP_PORT") ?? Env::getenv("DB_PORT");

        // var_dump($hostname);
        // var_dump($username);
        // var_dump($password);
        // var_dump($database);
        // var_dump($port);
        // echo "<br/>";

        try {
            $this->conn = new \mysqli($hostname, $username, $password, $database, $port);
        } catch (Exception $exception) {
            echo $exception;
            echo "\n\n\n";
            $this->conn = false;
        }

        return $this->conn;
    }
}
