<?php
namespace App\Services;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Exception as ReaderException;
use PhpOffice\PhpSpreadsheet\Reader\Xls as Reader;
use Symfony\Component\Filesystem\Filesystem;

class ImportLegalStatusService
{
    const  FILE_REFERENCIEL_FORM_JURIDIQUE = __DIR__ . '/../../public/uploads/referentiel_form_juridique.xls';

    public function __construct(protected Filesystem $filesystem)
    {
    }

    /**
     * Importer les status juridiques des entreprises
     * @return bool|array
     * @throws Exception
     * @throws ReaderException
     */
    public function importLegalStatus() : bool|array
    {
        if($this->filesystem->exists(ImportLegalStatusService::FILE_REFERENCIEL_FORM_JURIDIQUE))
        {
            $reader = new Reader();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load(ImportLegalStatusService::FILE_REFERENCIEL_FORM_JURIDIQUE);

            $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());

            return $sheet->toArray();
        }
        return false;
    }
}
