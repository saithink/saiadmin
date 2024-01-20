<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\utils;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

/**
 * Excel操作类
 * Class Excel
 * @package plugin\saiadmin\utils
 */
class Excel
{

    protected static $instance;

    protected $currentRow = 1;

    protected $width = 20;
    protected $height = 20;

    protected $bodyStyle = [];

    /**
     * 获取实例
     */
    public function instance(): Spreadsheet
    {
        if (is_null(self::$instance))
            self::$instance = new Spreadsheet();

        return self::$instance;
    }

    /**
     * 获取文件路径和名称
     */
    protected function getFileName(string $fileName)
    {
        $path = base_path() . '/plugin/saiadmin/public/export/';
        @mkdir($path, 0777, true);
        return $path . $fileName;
    }

    /**
     * 设置sheet标题
     */
    public function setTitle(string $sheetTitle)
    {
        $sheet = self::instance()->getActiveSheet();
        $sheet->setTitle($sheetTitle);
        return $this;
    }

    /**
     * 设置cell宽度和高度
     */
    public function setWidthAndHeight(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
        return $this;
    }

    /**
     * 设置表格的样式
     */
    public function setStyle(array $bodyStyle = [])
    {
        $this->bodyStyle = array_merge([
            'font'=>[
                'bold'=>true,
                'size'=>20,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER
            ],
        ], $bodyStyle);
        return $this;
    }

    /**
     * 初始化基础样式
     */
    protected function initStyle()
    {
        $sheet = self::instance()->getActiveSheet();
        $sheet->getDefaultRowDimension()->setRowHeight($this->height);
        $sheet->getDefaultColumnDimension()->setWidth($this->width);
    }

    /**
     * 设置表头和内容
     * @param array $header 表头数组
     * @param array $data 内容数组
     * @return Excel
     */
    public function setContent(array $header, array $data)
    {
        $this->initStyle();
        $sheet = self::instance()->getActiveSheet();
        // 总列数
        $count = count($header);
        // 设置表头
        $start = 'A'.$this->currentRow;
        $colEn = 'A';
        for ($i=0; $i < $count; $i++) {
            $sheet->setCellValueByColumnAndRow($i + 1, $this->currentRow, $header[$i]);
            if ($i > 0) {
                $colEn++;
            }
        }
        $sheet->getRowDimension($this->currentRow)->setRowHeight($this->height);
        $this->currentRow += 1;
        $statStart = $this->currentRow;
        // 设置数据
        for ($i=0; $i < count($data); $i++) {
            $j = 0;
            foreach ($data[$i] as $item) {
                $sheet->getCellByColumnAndRow($j + 1, $this->currentRow)->setValueExplicit($item,'s'); // 修复数字内容自动转换成科学计数法
                $j++;
            }
            $sheet->getRowDimension($this->currentRow)->setRowHeight($this->height);
            $this->currentRow += 1;
        }
        $endCol = $colEn.($this->currentRow - 1);
        // 设置内容样式
        $sheet->getStyle($start.':'.$endCol)->applyFromArray($this->bodyStyle);
        return $this;
    }

    /**
     * 保存文件
     * @param string $fileName 文件名称
     * @param bool $isMix 是否混淆名称
     * @return false|string
     */
    public function saveFile(string $fileName = 'test.xlsx', bool $isMix = false)
    {
        if ($isMix) {
            $fileName = md5(time().rand(1000,9999)).'.'.pathinfo($fileName, PATHINFO_EXTENSION);
        }
        $file = $this->getFileName($fileName);
        $format = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (!in_array($format, ['xlsx', 'xls', 'csv'])) {
            return false;
        }
        $writer = IOFactory::createWriter(self::instance(), ucfirst($format));
        $writer->save($file);
        return $file;
    }

}
