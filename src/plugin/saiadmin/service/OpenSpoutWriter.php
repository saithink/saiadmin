<?php
namespace plugin\saiadmin\service;

use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use OpenSpout\Writer\XLSX\Writer;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Style;

/**
 * Excel写入类
 * OpenSpout
 */
class OpenSpoutWriter
{
    /**
     * 操作实例
     * @var Writer
     */
    protected $instance;

    /**
     * 文件路径
     * @var string
     */
    protected $filepath;

    /**
     * 初始化
     * @param string $fileName 文件名称
     */
    public function __construct(string $fileName)
    {
        $this->filepath = $this->getFileName($fileName);
        $this->instance = new Writer();
        $this->instance->openToFile($this->filepath);
    }

    /**
     * 获取完整的文件路径
     * @param string $fileName
     * @return string
     */
    public function getFileName(string $fileName): string
    {
        $path = base_path() . '/plugin/saiadmin/public/export/';
        @mkdir($path, 0777, true);
        return $path . $fileName;
    }

    /**
     * 设置表格宽度
     * @param array $width 宽度数组
     * @return void
     */
    public function setWidth(array $width = [])
    {
        if (empty($width)) {
            return;
        }
        $sheet = $this->instance->getCurrentSheet();
        foreach ($width as $key => $value) {
            $sheet->setColumnWidth($value, $key + 1);
        }
    }

    /**
     * 设置表头
     * @param array $header 表头数组
     * @param $style
     * @return void
     */
    public function setHeader(array $header = [], $style = null): void
    {
        if (empty($style)) {
            $border = new Border(
                new BorderPart("top", "black", "thin"),
                new BorderPart("right", "black", "thin"),
                new BorderPart("bottom", "black", "thin"),
                new BorderPart("left", "black", "thin"),
            );
            $style = new Style();
            $style->setFontBold();
            $style->setCellAlignment("center");
            $style->setBorder($border);
        }
        $rowFromValues = Row::fromValues($header, $style);
        $this->instance->addRow($rowFromValues);
    }

    /**
     * 设置数据
     * @param array $data 数据数组
     * @param $style
     * @return void
     */
    public function setData(array $data = [], $style = null, array $filter = []): void
    {
        if (empty($style)) {
            $border = new Border(
                new BorderPart("top", "black", "thin"),
                new BorderPart("right", "black", "thin"),
                new BorderPart("bottom", "black", "thin"),
                new BorderPart("left", "black", "thin"),
            );
            $style = new Style();
            $style->setCellAlignment("center");
            $style->setBorder($border);
        }
        foreach($data as $row) {
            if (!empty($filter)) {
                foreach ($filter as $key => $value) {
                    foreach ($value  as $item) {
                        if ($item['value'] == $row[$key]) {
                            $row[$key] = $item['label'];
                            break;
                        }
                    }
                }
            }
            $rowFromValues = Row::fromValues($row, $style);
            $this->instance->addRow($rowFromValues);
        }
    }

    /**
     * 获取文件
     * @return string
     */
    public function returnFile(): string
    {
        $this->instance->close();
        return $this->filepath;
    }

}