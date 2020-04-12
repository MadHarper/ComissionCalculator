<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\App;

use InvalidArgumentException;

/**
 * Class CsvReader
 * Read data from csv file.
 */
class CsvReader implements DataReaderInterface
{
    const DELIMITER = ',';

    private $root;

    public function __construct($root)
    {
        $this->root = $root;
    }

    public function read(array $args): array
    {
        if (!isset($args[1])) {
            throw new InvalidArgumentException('Missing command argument');
        }

        $path = $this->root.'/'.$args[1];

        if (!file_exists($path)) {
            throw new InvalidArgumentException('File not found');
        }

        $list = [];
        if (($fp = fopen($path, 'rb')) !== false) {
            while (($data = fgetcsv($fp, 0, self::DELIMITER)) !== false) {
                $list[] = $data;
            }
            fclose($fp);
        }

        if (!count($list)) {
            throw new InvalidArgumentException('Not valid data');
        }

        return $list;
    }
}
