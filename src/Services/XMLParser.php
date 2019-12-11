<?php


namespace App\Services;

use Carbon\Carbon;
use PHPUnit\Exception;

/**
 * Class XMLParser
 * @package App\Services
 */
class XMLParser
{
    /** var \XMLReader */
    private $xmlReader;

    private $schemasDir;

    /**
     * XMLParser constructor.
     */
    public function __construct(string $schemasDir)
    {
        $this->xmlReader = new \XMLReader();
        $this->schemasDir = $schemasDir;
    }

    /**
     * @param string $fileName
     * @return string|null
     */
    public function getXSDSchemaFromFile(string $fileName)
    {
        try {
            $this->xmlReader->open($fileName);
            $schemaFound = false;
            while ($this->xmlReader->read() && !$schemaFound) {
                if ($this->xmlReader->nodeType == \XMLReader::ELEMENT && $this->xmlReader->name == 'z:root') {
                    $fileSchema = $this->xmlReader->getAttribute('xmlns:z');
                    $schemaParts = explode('/', $fileSchema);
                    $schemaName = $this->schemasDir . '/' . end($schemaParts) . '.xsd';
                    $schemaFound = true;
                }
            }
        } catch (\Exception $ex) {
            return null;
        }

        return $schemaName ?? null;
    }

    /**
     * @param string $fileName
     * @param string $XSDSchemaFile
     * @return bool
     */
    public function validateAgainstXSDSchema(string $fileName, string $XSDSchemaFile)
    {
        try {
            libxml_use_internal_errors(true);

            $this->xmlReader->open($fileName);
            $this->xmlReader->setSchema($XSDSchemaFile);

            while ($this->xmlReader->read()) { }; // empty loop

            return count(libxml_get_errors ()) == 0;
        } catch (\Exception $ex) {
            return false;
        }

        return true;
    }

    /**
     * @param string $fileName
     * @return array
     */
    public function getReportAttributes(string $fileName)
    {
        $this->xmlReader->open($fileName);
        $attributes = [];
        $allAttributesReady = false;
        while ($this->xmlReader->read() && !$allAttributesReady) {
            if ($this->xmlReader->nodeType == \XMLReader::ELEMENT && $this->xmlReader->name == 'z:root') {
                $attributes['name'] = $this->xmlReader->getAttribute('D_NAME');
                $attributes['edrpou'] = $this->xmlReader->getAttribute('D_EDRPOU');
                $attributes['nreg'] = "TRUE" == strtoupper($this->xmlReader->getAttribute('NREG'));
                $attributes['public_dt'] = Carbon::parse($this->xmlReader->getAttribute('REGDATE'));
                $allAttributesReady = true;
            }
        }

        return $attributes;
    }
}
