<?php

namespace Example\Storage;

class CsvFileStorage extends AbstractStorage implements StorageInterface
{
    const DELIMITER = ',';

    /**
     * @inheritDoc
     */
    public function get()
    {
        return $this->readRows();
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        $rows = $this->readRows();
        $rowNumber = $id - 1;
        if (isset($rows[$rowNumber])) {
            return $rows[$rowNumber];
        }
        return [];
    }

    /**
     * @inheritDoc
     */
    public function create(array $data)
    {
        $this->addRow($data);
        return $this->countRows();
    }

    /**
     * @inheritDoc
     */
    public function update($id, array $data)
    {
        $rows = $this->readRows();
        $rowNumber = $id - 1;
        if (isset($rows[$rowNumber])) {
            $rows[$rowNumber] = array_replace($rows[$rowNumber], $data);
        }
        return $this->writeRows($rows);
    }

    /**
     * @inheritDoc
     */
    public function delete($id)
    {
        $rows = $this->readRows();
        $rowNumber = $id - 1;
        if (isset($rows[$rowNumber])) {
            unset($rows[$rowNumber]);
        }
        return $this->writeRows($rows);
    }

    /**
     * A one row will be added to the end of the file
     * @param array $row
     * @return bool
     */
    protected function addRow(array $row)
    {
        $filePath = $this->getOption('file');
        $file = fopen($filePath, 'a');
        fputcsv($file, $row, self::DELIMITER);
        fclose($file);
        return true;
    }

    /**
     * Rows count in the file
     * @return mixed
     */
    protected function countRows()
    {
        $filePath = $this->getOption('file');
        $rows = file($filePath, FILE_SKIP_EMPTY_LINES);
        return count($rows);
    }

    /**
     * Rows write to the file
     * @param array $rows
     * @return bool
     */
    protected function writeRows(array $rows)
    {
        $filePath = $this->getOption('file');
        $file = fopen($filePath, 'w');
        foreach ($rows as $row) {
            fputcsv($file, $row, self::DELIMITER);
        }
        fclose($file);
        return true;
    }

    /**
     * Rows read from the file
     * @return array
     */
    protected function readRows()
    {
        $rows = [];
        $filePath = $this->getOption('file');
        $file = fopen($filePath, 'r');

        while (!feof($file)) {
            $string = fgetcsv($file, null, self::DELIMITER);
            if (!empty($string)) {
                $rows[] = $string;
            }
        }

        fclose($file);
        return $rows;
    }
}
