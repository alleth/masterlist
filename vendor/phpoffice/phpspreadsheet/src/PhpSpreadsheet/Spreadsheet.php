<?php

namespace PhpOffice\PhpSpreadsheet;

use JsonSerializable;
use PhpOffice\PhpSpreadsheet\Calculation\Calculation;
use PhpOffice\PhpSpreadsheet\Cell\IValueBinder;
use PhpOffice\PhpSpreadsheet\Document\Properties;
use PhpOffice\PhpSpreadsheet\Document\Security;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Shared\Font as SharedFont;
use PhpOffice\PhpSpreadsheet\Shared\StringHelper;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Iterator;
use PhpOffice\PhpSpreadsheet\Worksheet\Table;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Spreadsheet implements JsonSerializable
{
    // Allowable values for workbook window visilbity
    const VISIBILITY_VISIBLE = 'visible';
    const VISIBILITY_HIDDEN = 'hidden';
    const VISIBILITY_VERY_HIDDEN = 'veryHidden';

    private const DEFINED_NAME_IS_RANGE = false;
    private const DEFINED_NAME_IS_FORMULA = true;

    private const WORKBOOK_VIEW_VISIBILITY_VALUES = [
        self::VISIBILITY_VISIBLE,
        self::VISIBILITY_HIDDEN,
        self::VISIBILITY_VERY_HIDDEN,
    ];

    protected int $excelCalendar = Date::CALENDAR_WINDOWS_1900;

    /**
     * Unique ID.
     */
    private string $uniqueID;

    /**
     * Document properties.
     */
    private Properties $properties;

    /**
     * Document security.
     */
    private Security $security;

    /**
     * Collection of Worksheet objects.
     *
     * @var Worksheet[]
     */
    private array $workSheetCollection;

    /**
     * Calculation Engine.
     */
    private ?Calculation $calculationEngine;

    /**
     * Active sheet index.
     */
    private int $activeSheetIndex;

    /**
     * Named ranges.
     *
     * @var DefinedName[]
     */
    private array $definedNames;

    /**
     * CellXf supervisor.
     */
    private Style $cellXfSupervisor;

    /**
     * CellXf collection.
     *
     * @var Style[]
     */
    private array $cellXfCollection = [];

    /**
     * CellStyleXf collection.
     *
     * @var Style[]
     */
    private array $cellStyleXfCollection = [];

    /**
     * hasMacros : this workbook have macros ?
     */
    private bool $hasMacros = false;

    /**
     * macrosCode : all macros code as binary data (the vbaProject.bin file, this include form, code,  etc.), null if no macro.
     */
    private ?string $macrosCode = null;

    /**
     * macrosCertificate : if macros are signed, contains binary data vbaProjectSignature.bin file, null if not signed.
     */
    private ?string $macrosCertificate = null;

    /**
     * ribbonXMLData : null if workbook is'nt Excel 2007 or not contain a customized UI.
     *
     * @var null|array{target: string, data: string}
     */
    private ?array $ribbonXMLData = null;

    /**
     * ribbonBinObjects : null if workbook is'nt Excel 2007 or not contain embedded objects (picture(s)) for Ribbon Elements
     * ignored if $ribbonXMLData is null.
     *
     * @var null|mixed[]
     */
    private ?array $ribbonBinObjects = null;

    /**
     * List of unparsed loaded data for export to same format with better compatibility.
     * It has to be minimized when the library start to support currently unparsed data.
     *
     * @var array<array<array<array<string>|string>>>
     */
    private array $unparsedLoadedData = [];

    /**
     * Controls visibility of the horizonal scroll bar in the application.
     */
    private bool $showHorizontalScroll = true;

    /**
     * Controls visibility of the horizonal scroll bar in the application.
     */
    private bool $showVerticalScroll = true;

    /**
     * Controls visibility of the sheet tabs in the application.
     */
    private bool $showSheetTabs = true;

    /**
     * Specifies a boolean value that indicates whether the workbook window
     * is minimized.
     */
    private bool $minimized = false;

    /**
     * Specifies a boolean value that indicates whether to group dates
     * when presenting the user with filtering optiomd in the user
     * interface.
     */
    private bool $autoFilterDateGrouping = true;

    /**
     * Specifies the index to the first sheet in the book view.
     */
    private int $firstSheetIndex = 0;

    /**
     * Specifies the visible status of the workbook.
     */
    private string $visibility = self::VISIBILITY_VISIBLE;

    /**
     * Specifies the ratio between the workbook tabs bar and the horizontal
     * scroll bar.  TabRatio is assumed to be out of 1000 of the horizontal
     * window width.
     */
    private int $tabRatio = 600;

    private Theme $theme;

    private ?IValueBinder $valueBinder = null;

    /** @var array<string, int> */
    private array $fontCharsets = [
        'B Nazanin' => SharedFont::CHARSET_ANSI_ARABIC,
    ];

    /**
     * @param int $charset uses any value from Shared\Font,
     *    but defaults to ARABIC because that is the only known
     *    charset for which this declaration might be needed
     */
    public function addFontCharset(string $fontName, int $charset = SharedFont::CHARSET_ANSI_ARABIC): void
    {
        $this->fontCharsets[$fontName] = $charset;
    }

    public function getFontCharset(string $fontName): int
    {
        return $this->fontCharsets[$fontName] ?? -1;
    }

    /**
     * Return all fontCharsets.
     *
     * @return array<string, int>
     */
    public function getFontCharsets(): array
    {
        return $this->fontCharsets;
    }

    public function getTheme(): Theme
    {
        return $this->theme;
    }

    /**
     * The workbook has macros ?
     */
    public function hasMacros(): bool
    {
        return $this->hasMacros;
    }

    /**
     * Define if a workbook has macros.
     *
     * @param bool $hasMacros true|false
     */
    public function setHasMacros(bool $hasMacros): void
    {
        $this->hasMacros = (bool) $hasMacros;
    }

    /**
     * Set the macros code.
     */
    public function setMacrosCode(?string $macroCode): void
    {
        $this->macrosCode = $macroCode;
        $this->setHasMacros($macroCode !== null);
    }

    /**
     * Return the macros code.
     */
    public function getMacrosCode(): ?string
    {
        return $this->macrosCode;
    }

    /**
     * Set the macros certificate.
     */
    public function setMacrosCertificate(?string $certificate): void
    {
        $this->macrosCertificate = $certificate;
    }

    /**
     * Is the project signed ?
     *
     * @return bool true|false
     */
    public function hasMacrosCertificate(): bool
    {
        return $this->macrosCertificate !== null;
    }

    /**
     * Return the macros certificate.
     */
    public function getMacrosCertificate(): ?string
    {
        return $this->macrosCertificate;
    }

    /**
     * Remove all macros, certificate from spreadsheet.
     */
    public function discardMacros(): void
    {
        $this->hasMacros = false;
        $this->macrosCode = null;
        $this->macrosCertificate = null;
    }

    /**
     * set ribbon XML data.
     */
    public function setRibbonXMLData(mixed $target, mixed $xmlData): void
    {
        if (is_string($target) && is_string($xmlData)) {
            $this->ribbonXMLData = ['target' => $target, 'data' => $xmlData];
        } else {
            $this->ribbonXMLData = null;
        }
    }

    /**
     * retrieve ribbon XML Data.
     *
     * @return mixed[]
     */
    public function getRibbonXMLData(string $what = 'all'): null|array|string //we need some constants here...
    {
        $returnData = null;
        $what = strtolower($what);
        switch ($what) {
            case 'all':
                $returnData = $this->ribbonXMLData;

                break;
            case 'target':
            case 'data':
                if (is_array($this->ribbonXMLData)) {
                    $returnData = $this->ribbonXMLData[$what];
                }

                break;
        }

        return $returnData;
    }

    /**
     * store binaries ribbon objects (pictures).
     */
    public function setRibbonBinObjects(mixed $binObjectsNames, mixed $binObjectsData): void
    {
        if ($binObjectsNames !== null && $binObjectsData !== null) {
            $this->ribbonBinObjects = ['names' => $binObjectsNames, 'data' => $binObjectsData];
        } else {
            $this->ribbonBinObjects = null;
        }
    }

    /**
     * List of unparsed loaded data for export to same format with better compatibility.
     * It has to be minimized when the library start to support currently unparsed data.
     *
     * @internal
     *
     * @return mixed[]
     */
    public function getUnparsedLoadedData(): array
    {
        return $this->unparsedLoadedData;
    }

    /**
     * List of unparsed loaded data for export to same format with better compatibility.
     * It has to be minimized when the library start to support currently unparsed data.
     *
     * @internal
     *
     * @param array<array<array<array<string>|string>>> $unparsedLoadedData
     */
    public function setUnparsedLoadedData(array $unparsedLoadedData): void
    {
        $this->unparsedLoadedData = $unparsedLoadedData;
    }

    /**
     * retrieve Binaries Ribbon Objects.
     *
     * @return mixed[]
     */
    public function getRibbonBinObjects(string $what = 'all'): ?array
    {
        $ReturnData = null;
        $what = strtolower($what);
        switch ($what) {
            case 'all':
                return $this->ribbonBinObjects;
            case 'names':
            case 'data':
                if (is_array($this->ribbonBinObjects) && is_array($this->ribbonBinObjects[$what] ?? null)) {
                    $ReturnData = $this->ribbonBinObjects[$what];
                }

                break;
            case 'types':
                if (
                    is_array($this->ribbonBinObjects)
                    && isset($this->ribbonBinObjects['data']) && is_array($this->ribbonBinObjects['data'])
                ) {
                    $tmpTypes = array_keys($this->ribbonBinObjects['data']);
                    $ReturnData = array_unique(array_map(fn (string $path): string => pathinfo($path, PATHINFO_EXTENSION), $tmpTypes));
                } else {
                    $ReturnData = []; // the caller want an array... not null if empty
                }

                break;
        }

        return $ReturnData;
    }

    /**
     * This workbook have a custom UI ?
     */
    public function hasRibbon(): bool
    {
        return $this->ribbonXMLData !== null;
    }

    /**
     * This workbook have additionnal object for the ribbon ?
     */
    public function hasRibbonBinObjects(): bool
    {
        return $this->ribbonBinObjects !== null;
    }

    /**
     * Check if a sheet with a specified code name already exists.
     *
     * @param string $codeName Name of the worksheet to check
     */
    public function sheetCodeNameExists(string $codeName): bool
    {
        return $this->getSheetByCodeName($codeName) !== null;
    }

    /**
     * Get sheet by code name. Warning : sheet don't have always a code name !
     *
     * @param string $codeName Sheet name
     */
    public function getSheetByCodeName(string $codeName): ?Worksheet
    {
        $worksheetCount = count($this->workSheetCollection);
        for ($i = 0; $i < $worksheetCount; ++$i) {
            if ($this->workSheetCollection[$i]->getCodeName() == $codeName) {
                return $this->workSheetCollection[$i];
            }
        }

        return null;
    }

    /**
     * Create a new PhpSpreadsheet with one Worksheet.
     */
    public function __construct()
    {
        $this->uniqueID = uniqid('', true);
        $this->calculationEngine = new Calculation($this);
        $this->theme = new Theme();

        // Initialise worksheet collection and add one worksheet
        $this->workSheetCollection = [];
        $this->workSheetCollection[] = new Worksheet($this);
        $this->activeSheetIndex = 0;

        // Create document properties
        $this->properties = new Properties();

        // Create document security
        $this->security = new Security();

        // Set defined names
        $this->definedNames = [];

        // Create the cellXf supervisor
        $this->cellXfSupervisor = new Style(true);
        $this->cellXfSupervisor->bindParent($this);

        // Create the default style
        $this->addCellXf(new Style());
        $this->addCellStyleXf(new Style());
    }

    /**
     * Code to execute when this worksheet is unset().
     */
    public function __destruct()
    {
        $this->disconnectWorksheets();
        $this->calculationEngine = null;
        $this->cellXfCollection = [];
        $this->cellStyleXfCollection = [];
        $this->definedNames = [];
    }

    /**
     * Disconnect all worksheets from this PhpSpreadsheet workbook object,
     * typically so that the PhpSpreadsheet object can be unset.
     */
    public function disconnectWorksheets(): void
    {
        foreach ($this->workSheetCollection as $worksheet) {
            $worksheet->disconnectCells();
            unset($worksheet);
        }
        $this->workSheetCollection = [];
    }

    /**
     * Return the calculation engine for this worksheet.
     */
    public function getCalculationEngine(): ?Calculation
    {
        return $this->calculationEngine;
    }

    /**
     * Get properties.
     */
    public function getProperties(): Properties
    {
        return $this->properties;
    }

    /**
     * Set properties.
     */
    public function setProperties(Properties $documentProperties): void
    {
        $this->properties = $documentProperties;
    }

    /**
     * Get security.
     */
    public function getSecurity(): Security
    {
        return $this->security;
    }

    /**
     * Set security.
     */
    public function setSecurity(Security $documentSecurity): void
    {
        $this->security = $documentSecurity;
    }

    /**
     * Get active sheet.
     */
    public function getActiveSheet(): Worksheet
    {
        return $this->getSheet($this->activeSheetIndex);
    }

    /**
     * Create sheet and add it to this workbook.
     *
     * @param null|int $sheetIndex Index where sheet should go (0,1,..., or null for last)
     */
    public function createSheet(?int $sheetIndex = null): Worksheet
    {
        $newSheet = new Worksheet($this);
        $this->addSheet($newSheet, $sheetIndex, true);

        return $newSheet;
    }

    /**
     * Check if a sheet with a specified name already exists.
     *
     * @param string $worksheetName Name of the worksheet to check
     */
    public function sheetNameExists(string $worksheetName): bool
    {
        return $this->getSheetByName($worksheetName) !== null;
    }

    public function duplicateWorksheetByTitle(string $title): Worksheet
    {
        $original = $this->getSheetByNameOrThrow($title);
        $index = $this->getIndex($original) + 1;
        $clone = clone $original;

        return $this->addSheet($clone, $index, true);
    }

    /**
     * Add sheet.
     *
     * @param Worksheet $worksheet The worksheet to add
     * @param null|int $sheetIndex Index where sheet should go (0,1,..., or null for last)
     */
    public function addSheet(Worksheet $worksheet, ?int $sheetIndex = null, bool $retitleIfNeeded = false): Worksheet
    {
        if ($retitleIfNeeded) {
            $title = $worksheet->getTitle();
            if ($this->sheetNameExists($title)) {
                $i = 1;
                $newTitle = "$title $i";
                while ($this->sheetNameExists($newTitle)) {
                    ++$i;
                    $newTitle = "$title $i";
                }
                $worksheet->setTitle($newTitle);
            }
        }
        if ($this->sheetNameExists($worksheet->getTitle())) {
            throw new Exception(
                "Workbook already contains a worksheet named '{$worksheet->getTitle()}'. Rename this worksheet first."
            );
        }

        if ($sheetIndex === null) {
            if ($this->activeSheetIndex < 0) {
                $this->activeSheetIndex = 0;
            }
            $this->workSheetCollection[] = $worksheet;
        } else {
            // Insert the sheet at the requested index
            array_splice(
                $this->workSheetCollection,
                $sheetIndex,
                0,
                [$worksheet]
            );

            // Adjust active sheet index if necessary
            if ($this->activeSheetIndex >= $sheetIndex) {
                ++$this->activeSheetIndex;
            }
            if ($this->activeSheetIndex < 0) {
                $this->activeSheetIndex = 0;
            }
        }

        if ($worksheet->getParent() === null) {
            $worksheet->rebindParent($this);
        }

        return $worksheet;
    }

    /**
     * Remove sheet by index.
     *
     * @param int $sheetIndex Index position of the worksheet to remove
     */
    public function removeSheetByIndex(int $sheetIndex): void
    {
        $numSheets = count($this->workSheetCollection);
        if ($sheetIndex > $numSheets - 1) {
            throw new Exception(
                "You tried to remove a sheet by the out of bounds index: {$sheetIndex}. The actual number of sheets is {$numSheets}."
            );
        }
        array_splice($this->workSheetCollection, $sheetIndex, 1);

        // Adjust active sheet index if necessary
        if (
            ($this->activeSheetIndex >= $sheetIndex)
            && ($this->activeSheetIndex > 0 || $numSheets <= 1)
        ) {
            --$this->activeSheetIndex;
        }
    }

    /**
     * Get sheet by index.
     *
     * @param int $sheetIndex Sheet index
     */
    public function getSheet(int $sheetIndex): Worksheet
    {
        if (!isset($this->workSheetCollection[$sheetIndex])) {
            $numSheets = $this->getSheetCount();

            throw new Exception(
                "Your requested sheet index: {$sheetIndex} is out of bounds. The actual number of sheets is {$numSheets}."
            );
        }

        return $this->workSheetCollection[$sheetIndex];
    }

    /**
     * Get all sheets.
     *
     * @return Worksheet[]
     */
    public function getAllSheets(): array
    {
        return $this->workSheetCollection;
    }

    /**
     * Get sheet by name.
     *
     * @param string $worksheetName Sheet name
     */
    public function getSheetByName(string $worksheetName): ?Worksheet
    {
        $trimWorksheetName = trim($worksheetName, "'");
        foreach ($this->workSheetCollection as $worksheet) {
            if (strcasecmp($worksheet->getTitle(), $trimWorksheetName) === 0) {
                return $worksheet;
            }
        }

        return null;
    }

    /**
     * Get sheet by name, throwing exception if not found.
     */
    public function getSheetByNameOrThrow(string $worksheetName): Worksheet
    {
        $worksheet = $this->getSheetByName($worksheetName);
        if ($worksheet === null) {
            throw new Exception("Sheet $worksheetName does not exist.");
        }

        return $worksheet;
    }

    /**
     * Get index for sheet.
     *
     * @return int index
     */
    public function getIndex(Worksheet $worksheet, bool $noThrow = false): int
    {
        $wsHash = $worksheet->getHashInt();
        foreach ($this->workSheetCollection as $key => $value) {
            if ($value->getHashInt() === $wsHash) {
                return $key;
            }
        }
        if ($noThrow) {
            return -1;
        }

        throw new Exception('Sheet does not exist.');
    }

    /**
     * Set index for sheet by sheet name.
     *
     * @param string $worksheetName Sheet name to modify index for
     * @param int $newIndexPosition New index for the sheet
     *
     * @return int New sheet index
     */
    public function setIndexByName(string $worksheetName, int $newIndexPosition): int
    {
        $oldIndex = $this->getIndex($this->getSheetByNameOrThrow($worksheetName));
        $worksheet = array_splice(
            $this->workSheetCollection,
            $oldIndex,
            1
        );
        array_splice(
            $this->workSheetCollection,
            $newIndexPosition,
            0,
            $worksheet
        );

        return $newIndexPosition;
    }

    /**
     * Get sheet count.
     */
    public function getSheetCount(): int
    {
        return count($this->workSheetCollection);
    }

    /**
     * Get active sheet index.
     *
     * @return int Active sheet index
     */
    public function getActiveSheetIndex(): int
    {
        return $this->activeSheetIndex;
    }

    /**
     * Set active sheet index.
     *
     * @param int $worksheetIndex Active sheet index
     */
    public function setActiveSheetIndex(int $worksheetIndex): Worksheet
    {
        $numSheets = count($this->workSheetCollection);

        if ($worksheetIndex > $numSheets - 1) {
            throw new Exception(
                "You tried to set a sheet active by the out of bounds index: {$worksheetIndex}. The actual number of sheets is {$numSheets}."
            );
        }
        $this->activeSheetIndex = $worksheetIndex;

        return $this->getActiveSheet();
    }

    /**
     * Set active sheet index by name.
     *
     * @param string $worksheetName Sheet title
     */
    public function setActiveSheetIndexByName(string $worksheetName): Worksheet
    {
        if (($worksheet = $this->getSheetByName($worksheetName)) instanceof Worksheet) {
            $this->setActiveSheetIndex($this->getIndex($worksheet));

            return $worksheet;
        }

        throw new Exception('Workbook does not contain sheet:' . $worksheetName);
    }

    /**
     * Get sheet names.
     *
     * @return string[]
     */
    public function getSheetNames(): array
    {
        $returnValue = [];
        $worksheetCount = $this->getSheetCount();
        for ($i = 0; $i < $worksheetCount; ++$i) {
            $returnValue[] = $this->getSheet($i)->getTitle();
        }

        return $returnValue;
    }

    /**
     * Add external sheet.
     *
     * @param Worksheet $worksheet External sheet to add
     * @param null|int $sheetIndex Index where sheet should go (0,1,..., or null for last)
     */
    public function addExternalSheet(Worksheet $worksheet, ?int $sheetIndex = null): Worksheet
    {
        if ($this->sheetNameExists($worksheet->getTitle())) {
            throw new Exception("Workbook already contains a worksheet named '{$worksheet->getTitle()}'. Rename the external sheet first.");
        }

        // count how many cellXfs there are in this workbook currently, we will need this below
        $countCellXfs = count($this->cellXfCollection);

        // copy all the shared cellXfs from the external workbook and append them to the current
        foreach ($worksheet->getParentOrThrow()->getCellXfCollection() as $cellXf) {
            $this->addCellXf(clone $cellXf);
        }

        // move sheet to this workbook
        $worksheet->rebindParent($this);

        // update the cellXfs
        foreach ($worksheet->getCoordinates(false) as $coordinate) {
            $cell = $worksheet->getCell($coordinate);
            $cell->setXfIndex($cell->getXfIndex() + $countCellXfs);
        }

        // update the column dimensions Xfs
        foreach ($worksheet->getColumnDimensions() as $columnDimension) {
            $columnDimension->setXfIndex($columnDimension->getXfIndex() + $countCellXfs);
        }

        // update the row dimensions Xfs
        foreach ($worksheet->getRowDimensions() as $rowDimension) {
            $xfIndex = $rowDimension->getXfIndex();
            if ($xfIndex !== null) {
                $rowDimension->setXfIndex($xfIndex + $countCellXfs);
            }
        }

        return $this->addSheet($worksheet, $sheetIndex);
    }

    /**
     * Get an array of all Named Ranges.
     *
     * @return DefinedName[]
     */
    public function getNamedRanges(): array
    {
        return array_filter(
            $this->definedNames,
            fn (DefinedName $definedName): bool => $definedName->isFormula() === self::DEFINED_NAME_IS_RANGE
        );
    }

    /**
     * Get an array of all Named Formulae.
     *
     * @return DefinedName[]
     */
    public function getNamedFormulae(): array
    {
        return array_filter(
            $this->definedNames,
            fn (DefinedName $definedName): bool => $definedName->isFormula() === self::DEFINED_NAME_IS_FORMULA
        );
    }

    /**
     * Get an array of all Defined Names (both named ranges and named formulae).
     *
     * @return DefinedName[]
     */
    public function getDefinedNames(): array
    {
        return $this->definedNames;
    }

    /**
     * Add a named range.
     * If a named range with this name already exists, then this will replace the existing value.
     */
    public function addNamedRange(NamedRange $namedRange): void
    {
        $this->addDefinedName($namedRange);
    }

    /**
     * Add a named formula.
     * If a named formula with this name already exists, then this will replace the existing value.
     */
    public function addNamedFormula(NamedFormula $namedFormula): void
    {
        $this->addDefinedName($namedFormula);
    }

    /**
     * Add a defined name (either a named range or a named formula).
     * If a defined named with this name already exists, then this will replace the existing value.
     */
    public function addDefinedName(DefinedName $definedName): void
    {
        $upperCaseName = StringHelper::strToUpper($definedName->getName());
        if ($definedName->getScope() == null) {
            // global scope
            $this->definedNames[$upperCaseName] = $definedName;
        } else {
            // local scope
            $this->definedNames[$definedName->getScope()->getTitle() . '!' . $upperCaseName] = $definedName;
        }
    }

    /**
     * Get named range.
     *
     * @param null|Worksheet $worksheet Scope. Use null for global scope
     */
    public function getNamedRange(string $namedRange, ?Worksheet $worksheet = null): ?NamedRange
    {
        $returnValue = null;

        if ($namedRange !== '') {
            $namedRange = StringHelper::strToUpper($namedRange);
            // first look for global named range
            $returnValue = $this->getGlobalDefinedNameByType($namedRange, self::DEFINED_NAME_IS_RANGE);
            // then look for local named range (has priority over global named range if both names exist)
            $returnValue = $this->getLocalDefinedNameByType($namedRange, self::DEFINED_NAME_IS_RANGE, $worksheet) ?: $returnValue;
        }

        return $returnValue instanceof NamedRange ? $returnValue : null;
    }

    /**
     * Get named formula.
     *
     * @param null|Worksheet $worksheet Scope. Use null for global scope
     */
    public function getNamedFormula(string $namedFormula, ?Worksheet $worksheet = null): ?NamedFormula
    {
        $returnValue = null;

        if ($namedFormula !== '') {
            $namedFormula = StringHelper::strToUpper($namedFormula);
            // first look for global named formula
            $returnValue = $this->getGlobalDefinedNameByType($namedFormula, self::DEFINED_NAME_IS_FORMULA);
            // then look for local named formula (has priority over global named formula if both names exist)
            $returnValue = $this->getLocalDefinedNameByType($namedFormula, self::DEFINED_NAME_IS_FORMULA, $worksheet) ?: $returnValue;
        }

        return $returnValue instanceof NamedFormula ? $returnValue : null;
    }

    private function getGlobalDefinedNameByType(string $name, bool $type): ?DefinedName
    {
        if (isset($this->definedNames[$name]) && $this->definedNames[$name]->isFormula() === $type) {
            return $this->definedNames[$name];
        }

        return null;
    }

    private function getLocalDefinedNameByType(string $name, bool $type, ?Worksheet $worksheet = null): ?DefinedName
    {
        if (
            ($worksheet !== null) && isset($this->definedNames[$worksheet->getTitle() . '!' . $name])
            && $this->definedNames[$worksheet->getTitle() . '!' . $name]->isFormula() === $type
        ) {
            return $this->definedNames[$worksheet->getTitle() . '!' . $name];
        }

        return null;
    }

    /**
     * Get named range.
     *
     * @param null|Worksheet $worksheet Scope. Use null for global scope
     */
    public function getDefinedName(string $definedName, ?Worksheet $worksheet = null): ?DefinedName
    {
        $returnValue = null;

        if ($definedName !== '') {
            $definedName = StringHelper::strToUpper($definedName);
            // first look for global defined name
            if (isset($this->definedNames[$definedName])) {
                $returnValue = $this->definedNames[$definedName];
            }

            // then look for local defined name (has priority over global defined name if both names exist)
            if (($worksheet !== null) && isset($this->definedNames[$worksheet->getTitle() . '!' . $definedName])) {
                $returnValue = $this->definedNames[$worksheet->getTitle() . '!' . $definedName];
            }
        }

        return $returnValue;
    }

    /**
     * Remove named range.
     *
     * @param null|Worksheet $worksheet scope: use null for global scope
     *
     * @return $this
     */
    public function removeNamedRange(string $namedRange, ?Worksheet $worksheet = null): self
    {
        if ($this->getNamedRange($namedRange, $worksheet) === null) {
            return $this;
        }

        return $this->removeDefinedName($namedRange, $worksheet);
    }

    /**
     * Remove named formula.
     *
     * @param null|Worksheet $worksheet scope: use null for global scope
     *
     * @return $this
     */
    public function removeNamedFormula(string $namedFormula, ?Worksheet $worksheet = null): self
    {
        if ($this->getNamedFormula($namedFormula, $worksheet) === null) {
            return $this;
        }

        return $this->removeDefinedName($namedFormula, $worksheet);
    }

    /**
     * Remove defined name.
     *
     * @param null|Worksheet $worksheet scope: use null for global scope
     *
     * @return $this
     */
    public function removeDefinedName(string $definedName, ?Worksheet $worksheet = null): self
    {
        $definedName = StringHelper::strToUpper($definedName);

        if ($worksheet === null) {
            if (isset($this->definedNames[$definedName])) {
                unset($this->definedNames[$definedName]);
            }
        } else {
            if (isset($this->definedNames[$worksheet->getTitle() . '!' . $definedName])) {
                unset($this->definedNames[$worksheet->getTitle() . '!' . $definedName]);
            } elseif (isset($this->definedNames[$definedName])) {
                unset($this->definedNames[$definedName]);
            }
        }

        return $this;
    }

    /**
     * Get worksheet iterator.
     */
    public function getWorksheetIterator(): Iterator
    {
        return new Iterator($this);
    }

    /**
     * Copy workbook (!= clone!).
     */
    public function copy(): self
    {
        return unserialize(serialize($this)); //* @phpstan-ignore-line
    }

    /**
     * Implement PHP __clone to create a deep clone, not just a shallow copy.
     */
    public function __clone()
    {
        $this->uniqueID = uniqid('', true);

        $usedKeys = [];
        // I don't now why new Style rather than clone.
        $this->cellXfSupervisor = new Style(true);
        //$this->cellXfSupervisor = clone $this->cellXfSupervisor;
        $this->cellXfSupervisor->bindParent($this);
        $usedKeys['cellXfSupervisor'] = true;

        $oldCalc = $this->calculationEngine;
        $this->calculationEngine = new Calculation($this);
        if ($oldCalc !== null) {
            $this->calculationEngine
                ->setSuppressFormulaErrors(
                    $oldCalc->getSuppressFormulaErrors()
                )
                ->setCalculationCacheEnabled(
                    $oldCalc->getCalculationCacheEnabled()
                )
                ->setBranchPruningEnabled(
                    $oldCalc->getBranchPruningEnabled()
                )
                ->setInstanceArrayReturnType(
                    $oldCalc->getInstanceArrayReturnType()
                );
        }
        $usedKeys['calculationEngine'] = true;

        $currentCollection = $this->cellStyleXfCollection;
        $this->cellStyleXfCollection = [];
        foreach ($currentCollection as $item) {
            $clone = $item->exportArray();
            $style = (new Style())->applyFromArray($clone);
            $this->addCellStyleXf($style);
        }
        $usedKeys['cellStyleXfCollection'] = true;

        $currentCollection = $this->cellXfCollection;
        $this->cellXfCollection = [];
        foreach ($currentCollection as $item) {
            $clone = $item->exportArray();
            $style = (new Style())->applyFromArray($clone);
            $this->addCellXf($style);
        }
        $usedKeys['cellXfCollection'] = true;

        $currentCollection = $this->workSheetCollection;
        $this->workSheetCollection = [];
        foreach ($currentCollection as $item) {
            $clone = clone $item;
            $clone->setParent($this);
            $this->workSheetCollection[] = $clone;
        }
        $usedKeys['workSheetCollection'] = true;

        foreach (get_object_vars($this) as $key => $val) {
            if (isset($usedKeys[$key])) {
                continue;
            }
            switch ($key) {
                // arrays of objects not covered above
                case 'definedNames':
                    /** @var DefinedName[] */
                    $currentCollection = $val;
                    $this->$key = [];
                    foreach ($currentCollection as $item) {
                        $clone = clone $item;
                        $this->{$key}[] = $clone;
                    }

                    break;
                default:
                    if (is_object($val)) {
                        $this->$key = clone $val;
                    }
            }
        }
    }

    /**
     * Get the workbook collection of cellXfs.
     *
     * @return Style[]
     */
    public function getCellXfCollection(): array
    {
        return $this->cellXfCollection;
    }

    /**
     * Get cellXf by index.
     */
    public function getCellXfByIndex(int $cellStyleIndex): Style
    {
        return $this->cellXfCollection[$cellStyleIndex];
    }

    public function getCellXfByIndexOrNull(?int $cellStyleIndex): ?Style
    {
        return ($cellStyleIndex === null) ? null : ($this->cellXfCollection[$cellStyleIndex] ?? null);
    }

    /**
     * Get cellXf by hash code.
     *
     * @return false|Style
     */
    public function getCellXfByHashCode(string $hashcode): bool|Style
    {
        foreach ($this->cellXfCollection as $cellXf) {
            if ($cellXf->getHashCode() === $hashcode) {
                return $cellXf;
            }
        }

        return false;
    }

    /**
     * Check if style exists in style collection.
     */
    public function cellXfExists(Style $cellStyleIndex): bool
    {
        return in_array($cellStyleIndex, $this->cellXfCollection, true);
    }

    /**
     * Get default style.
     */
    public function getDefaultStyle(): Style
    {
        if (isset($this->cellXfCollection[0])) {
            return $this->cellXfCollection[0];
        }

        throw new Exception('No default style found for this workbook');
    }

    /**
     * Add a cellXf to the workbook.
     */
    public function addCellXf(Style $style): void
    {
        $this->cellXfCollection[] = $style;
        $style->setIndex(count($this->cellXfCollection) - 1);
    }

    /**
     * Remove cellXf by index. It is ensured that all cells get their xf index updated.
     *
     * @param int $cellStyleIndex Index to cellXf
     */
    public function removeCellXfByIndex(int $cellStyleIndex): void
    {
        if ($cellStyleIndex > count($this->cellXfCollection) - 1) {
            throw new Exception('CellXf index is out of bounds.');
        }

        // first remove the cellXf
        array_splice($this->cellXfCollection, $cellStyleIndex, 1);

        // then update cellXf indexes for cells
        foreach ($this->workSheetCollection as $worksheet) {
            foreach ($worksheet->getCoordinates(false) as $coordinate) {
                $cell = $worksheet->getCell($coordinate);
                $xfIndex = $cell->getXfIndex();
                if ($xfIndex > $cellStyleIndex) {
                    // decrease xf index by 1
                    $cell->setXfIndex($xfIndex - 1);
                } elseif ($xfIndex == $cellStyleIndex) {
                    // set to default xf index 0
                    $cell->setXfIndex(0);
                }
            }
        }
    }

    /**
     * Get the cellXf supervisor.
     */
    public function getCellXfSupervisor(): Style
    {
        return $this->cellXfSupervisor;
    }

    /**
     * Get the workbook collection of cellStyleXfs.
     *
     * @return Style[]
     */
    public function getCellStyleXfCollection(): array
    {
        return $this->cellStyleXfCollection;
    }

    /**
     * Get cellStyleXf by index.
     *
     * @param int $cellStyleIndex Index to cellXf
     */
    public function getCellStyleXfByIndex(int $cellStyleIndex): Style
    {
        return $this->cellStyleXfCollection[$cellStyleIndex];
    }

    /**
     * Get cellStyleXf by hash code.
     *
     * @return false|Style
     */
    public function getCellStyleXfByHashCode(string $hashcode): bool|Style
    {
        foreach ($this->cellStyleXfCollection as $cellStyleXf) {
            if ($cellStyleXf->getHashCode() === $hashcode) {
                return $cellStyleXf;
            }
        }

        return false;
    }

    /**
     * Add a cellStyleXf to the workbook.
     */
    public function addCellStyleXf(Style $style): void
    {
        $this->cellStyleXfCollection[] = $style;
        $style->setIndex(count($this->cellStyleXfCollection) - 1);
    }

    /**
     * Remove cellStyleXf by index.
     *
     * @param int $cellStyleIndex Index to cellXf
     */
    public function removeCellStyleXfByIndex(int $cellStyleIndex): void
    {
        if ($cellStyleIndex > count($this->cellStyleXfCollection) - 1) {
            throw new Exception('CellStyleXf index is out of bounds.');
        }
        array_splice($this->cellStyleXfCollection, $cellStyleIndex, 1);
    }

    /**
     * Eliminate all unneeded cellXf and afterwards update the xfIndex for all cells
     * and columns in the workbook.
     */
    public function garbageCollect(): void
    {
        // how many references are there to each cellXf ?
        $countReferencesCellXf = [];
        foreach ($this->cellXfCollection as $index => $cellXf) {
            $countReferencesCellXf[$index] = 0;
        }

        foreach ($this->getWorksheetIterator() as $sheet) {
            // from cells
            foreach ($sheet->getCoordinates(false) as $coordinate) {
                $cell = $sheet->getCell($coordinate);
                ++$countReferencesCellXf[$cell->getXfIndex()];
            }

            // from row dimensions
            foreach ($sheet->getRowDimensions() as $rowDimension) {
                if ($rowDimension->getXfIndex() !== null) {
                    ++$countReferencesCellXf[$rowDimension->getXfIndex()];
                }
            }

            // from column dimensions
            foreach ($sheet->getColumnDimensions() as $columnDimension) {
                ++$countReferencesCellXf[$columnDimension->getXfIndex()];
            }
        }

        // remove cellXfs without references and create mapping so we can update xfIndex
        // for all cells and columns
        $countNeededCellXfs = 0;
        $map = [];
        foreach ($this->cellXfCollection as $index => $cellXf) {
            if ($countReferencesCellXf[$index] > 0 || $index == 0) { // we must never remove the first cellXf
                ++$countNeededCellXfs;
            } else {
                unset($this->cellXfCollection[$index]);
            }
            $map[$index] = $countNeededCellXfs - 1;
        }
        $this->cellXfCollection = array_values($this->cellXfCollection);

        // update the index for all cellXfs
        foreach ($this->cellXfCollection as $i => $cellXf) {
            $cellXf->setIndex($i);
        }

        // make sure there is always at least one cellXf (there should be)
        if (empty($this->cellXfCollection)) {
            $this->cellXfCollection[] = new Style();
        }

        // update the xfIndex for all cells, row dimensions, column dimensions
        foreach ($this->getWorksheetIterator() as $sheet) {
            // for all cells
            foreach ($sheet->getCoordinates(false) as $coordinate) {
                $cell = $sheet->getCell($coordinate);
                $cell->setXfIndex($map[$cell->getXfIndex()]);
            }

            // for all row dimensions
            foreach ($sheet->getRowDimensions() as $rowDimension) {
                if ($rowDimension->getXfIndex() !== null) {
                    $rowDimension->setXfIndex($map[$rowDimension->getXfIndex()]);
                }
            }

            // for all column dimensions
            foreach ($sheet->getColumnDimensions() as $columnDimension) {
                $columnDimension->setXfIndex($map[$columnDimension->getXfIndex()]);
            }

            // also do garbage collection for all the sheets
            $sheet->garbageCollect();
        }
    }

    /**
     * Return the unique ID value assigned to this spreadsheet workbook.
     */
    public function getID(): string
    {
        return $this->uniqueID;
    }

    /**
     * Get the visibility of the horizonal scroll bar in the application.
     *
     * @return bool True if horizonal scroll bar is visible
     */
    public function getShowHorizontalScroll(): bool
    {
        return $this->showHorizontalScroll;
    }

    /**
     * Set the visibility of the horizonal scroll bar in the application.
     *
     * @param bool $showHorizontalScroll True if horizonal scroll bar is visible
     */
    public function setShowHorizontalScroll(bool $showHorizontalScroll): void
    {
        $this->showHorizontalScroll = (bool) $showHorizontalScroll;
    }

    /**
     * Get the visibility of the vertical scroll bar in the application.
     *
     * @return bool True if vertical scroll bar is visible
     */
    public function getShowVerticalScroll(): bool
    {
        return $this->showVerticalScroll;
    }

    /**
     * Set the visibility of the vertical scroll bar in the application.
     *
     * @param bool $showVerticalScroll True if vertical scroll bar is visible
     */
    public function setShowVerticalScroll(bool $showVerticalScroll): void
    {
        $this->showVerticalScroll = (bool) $showVerticalScroll;
    }

    /**
     * Get the visibility of the sheet tabs in the application.
     *
     * @return bool True if the sheet tabs are visible
     */
    public function getShowSheetTabs(): bool
    {
        return $this->showSheetTabs;
    }

    /**
     * Set the visibility of the sheet tabs  in the application.
     *
     * @param bool $showSheetTabs True if sheet tabs are visible
     */
    public function setShowSheetTabs(bool $showSheetTabs): void
    {
        $this->showSheetTabs = (bool) $showSheetTabs;
    }

    /**
     * Return whether the workbook window is minimized.
     *
     * @return bool true if workbook window is minimized
     */
    public function getMinimized(): bool
    {
        return $this->minimized;
    }

    /**
     * Set whether the workbook window is minimized.
     *
     * @param bool $minimized true if workbook window is minimized
     */
    public function setMinimized(bool $minimized): void
    {
        $this->minimized = (bool) $minimized;
    }

    /**
     * Return whether to group dates when presenting the user with
     * filtering optiomd in the user interface.
     *
     * @return bool true if workbook window is minimized
     */
    public function getAutoFilterDateGrouping(): bool
    {
        return $this->autoFilterDateGrouping;
    }

    /**
     * Set whether to group dates when presenting the user with
     * filtering optiomd in the user interface.
     *
     * @param bool $autoFilterDateGrouping true if workbook window is minimized
     */
    public function setAutoFilterDateGrouping(bool $autoFilterDateGrouping): void
    {
        $this->autoFilterDateGrouping = (bool) $autoFilterDateGrouping;
    }

    /**
     * Return the first sheet in the book view.
     *
     * @return int First sheet in book view
     */
    public function getFirstSheetIndex(): int
    {
        return $this->firstSheetIndex;
    }

    /**
     * Set the first sheet in the book view.
     *
     * @param int $firstSheetIndex First sheet in book view
     */
    public function setFirstSheetIndex(int $firstSheetIndex): void
    {
        if ($firstSheetIndex >= 0) {
            $this->firstSheetIndex = (int) $firstSheetIndex;
        } else {
            throw new Exception('First sheet index must be a positive integer.');
        }
    }

    /**
     * Return the visibility status of the workbook.
     *
     * This may be one of the following three values:
     * - visibile
     *
     * @return string Visible status
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }

    /**
     * Set the visibility status of the workbook.
     *
     * Valid values are:
     *  - 'visible' (self::VISIBILITY_VISIBLE):
     *       Workbook window is visible
     *  - 'hidden' (self::VISIBILITY_HIDDEN):
     *       Workbook window is hidden, but can be shown by the user
     *       via the user interface
     *  - 'veryHidden' (self::VISIBILITY_VERY_HIDDEN):
     *       Workbook window is hidden and cannot be shown in the
     *       user interface.
     *
     * @param null|string $visibility visibility status of the workbook
     */
    public function setVisibility(?string $visibility): void
    {
        if ($visibility === null) {
            $visibility = self::VISIBILITY_VISIBLE;
        }

        if (in_array($visibility, self::WORKBOOK_VIEW_VISIBILITY_VALUES)) {
            $this->visibility = $visibility;
        } else {
            throw new Exception('Invalid visibility value.');
        }
    }

    /**
     * Get the ratio between the workbook tabs bar and the horizontal scroll bar.
     * TabRatio is assumed to be out of 1000 of the horizontal window width.
     *
     * @return int Ratio between the workbook tabs bar and the horizontal scroll bar
     */
    public function getTabRatio(): int
    {
        return $this->tabRatio;
    }

    /**
     * Set the ratio between the workbook tabs bar and the horizontal scroll bar
     * TabRatio is assumed to be out of 1000 of the horizontal window width.
     *
     * @param int $tabRatio Ratio between the tabs bar and the horizontal scroll bar
     */
    public function setTabRatio(int $tabRatio): void
    {
        if ($tabRatio >= 0 && $tabRatio <= 1000) {
            $this->tabRatio = (int) $tabRatio;
        } else {
            throw new Exception('Tab ratio must be between 0 and 1000.');
        }
    }

    public function reevaluateAutoFilters(bool $resetToMax): void
    {
        foreach ($this->workSheetCollection as $sheet) {
            $filter = $sheet->getAutoFilter();
            if (!empty($filter->getRange())) {
                if ($resetToMax) {
                    $filter->setRangeToMaxRow();
                }
                $filter->showHideRows();
            }
        }
    }

    /**
     * @throws Exception
     */
    public function jsonSerialize(): mixed
    {
        throw new Exception('Spreadsheet objects cannot be json encoded');
    }

    public function resetThemeFonts(): void
    {
        $majorFontLatin = $this->theme->getMajorFontLatin();
        $minorFontLatin = $this->theme->getMinorFontLatin();
        foreach ($this->cellXfCollection as $cellStyleXf) {
            $scheme = $cellStyleXf->getFont()->getScheme();
            if ($scheme === 'major') {
                $cellStyleXf->getFont()->setName($majorFontLatin)->setScheme($scheme);
            } elseif ($scheme === 'minor') {
                $cellStyleXf->getFont()->setName($minorFontLatin)->setScheme($scheme);
            }
        }
        foreach ($this->cellStyleXfCollection as $cellStyleXf) {
            $scheme = $cellStyleXf->getFont()->getScheme();
            if ($scheme === 'major') {
                $cellStyleXf->getFont()->setName($majorFontLatin)->setScheme($scheme);
            } elseif ($scheme === 'minor') {
                $cellStyleXf->getFont()->setName($minorFontLatin)->setScheme($scheme);
            }
        }
    }

    public function getTableByName(string $tableName): ?Table
    {
        $table = null;
        foreach ($this->workSheetCollection as $sheet) {
            $table = $sheet->getTableByName($tableName);
            if ($table !== null) {
                break;
            }
        }

        return $table;
    }

    /**
     * @return bool Success or failure
     */
    public function setExcelCalendar(int $baseYear): bool
    {
        if (($baseYear === Date::CALENDAR_WINDOWS_1900) || ($baseYear === Date::CALENDAR_MAC_1904)) {
            $this->excelCalendar = $baseYear;

            return true;
        }

        return false;
    }

    /**
     * @return int Excel base date (1900 or 1904)
     */
    public function getExcelCalendar(): int
    {
        return $this->excelCalendar;
    }

    public function deleteLegacyDrawing(Worksheet $worksheet): void
    {
        unset($this->unparsedLoadedData['sheets'][$worksheet->getCodeName()]['legacyDrawing']);
    }

    public function getLegacyDrawing(Worksheet $worksheet): ?string
    {
        /** @var ?string */
        $temp = $this->unparsedLoadedData['sheets'][$worksheet->getCodeName()]['legacyDrawing'] ?? null;

        return $temp;
    }

    public function getValueBinder(): ?IValueBinder
    {
        return $this->valueBinder;
    }

    public function setValueBinder(?IValueBinder $valueBinder): self
    {
        $this->valueBinder = $valueBinder;

        return $this;
    }

    /**
     * All the PDF writers treat charts as if they occupy a single cell.
     * This will be better most of the time.
     * It is not needed for any other output type.
     * It changes the contents of the spreadsheet, so you might
     * be better off cloning the spreadsheet and then using
     * this method on, and then writing, the clone.
     */
    public function mergeChartCellsForPdf(): void
    {
        foreach ($this->workSheetCollection as $worksheet) {
            foreach ($worksheet->getChartCollection() as $chart) {
                $br = $chart->getBottomRightCell();
                $tl = $chart->getTopLeftCell();
                if ($br !== '' && $br !== $tl) {
                    if (!$worksheet->cellExists($br)) {
                        $worksheet->getCell($br)->setValue(' ');
                    }
                    $worksheet->mergeCells("$tl:$br");
                }
            }
        }
    }

    /**
     * All the PDF writers do better with drawings than charts.
     * This will be better some of the time.
     * It is not needed for any other output type.
     * It changes the contents of the spreadsheet, so you might
     * be better off cloning the spreadsheet and then using
     * this method on, and then writing, the clone.
     */
    public function mergeDrawingCellsForPdf(): void
    {
        foreach ($this->workSheetCollection as $worksheet) {
            foreach ($worksheet->getDrawingCollection() as $drawing) {
                $br = $drawing->getCoordinates2();
                $tl = $drawing->getCoordinates();
                if ($br !== '' && $br !== $tl) {
                    if (!$worksheet->cellExists($br)) {
                        $worksheet->getCell($br)->setValue(' ');
                    }
                    $worksheet->mergeCells("$tl:$br");
                }
            }
        }
    }

    /**
     * Excel will sometimes replace user's formatting choice
     * with a built-in choice that it thinks is equivalent.
     * Its choice is often not equivalent after all.
     * Such treatment is astonishingly user-hostile.
     * This function will undo such changes.
     */
    public function replaceBuiltinNumberFormat(int $builtinFormatIndex, string $formatCode): void
    {
        foreach ($this->cellXfCollection as $style) {
            $numberFormat = $style->getNumberFormat();
            if ($numberFormat->getBuiltInFormatCode() === $builtinFormatIndex) {
                $numberFormat->setFormatCode($formatCode);
            }
        }
    }
}
