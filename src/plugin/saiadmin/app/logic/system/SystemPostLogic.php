<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use plugin\saiadmin\app\model\system\SystemPost;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\Excel;

/**
 * 系统公告逻辑层
 */
class SystemPostLogic extends BaseLogic
{
    /**
     * 构造函数
     */
    public function __construct()
    {
        $this->model = new SystemPost();
    }

    /**
     * 可操作岗位
     * @param array $where
     * @return array
     */
    public function accessPost(array $where = []): array
    {
        $query = $this->search($where);
        return $this->getAll($query);
    }

    /**
     * 导入数据
     */
    public function import($file)
    {
        $path = $this->getImport($file);
        $spreadsheet = IOFactory::load($path);
        try {
            $sheet = $spreadsheet->getSheet(0);
            $highest_row = $sheet->getHighestRow(); // 取得总行数
            $data = [];
            for ($i = 2; $i <= $highest_row; $i++) {
                $data[] = [
                    'name' => $sheet->getCellByColumnAndRow(1, $i)->getValue(),
                    'code' => $sheet->getCellByColumnAndRow(2, $i)->getValue(),
                    'sort' => $sheet->getCellByColumnAndRow(3, $i)->getValue(),
                    'status' => $sheet->getCellByColumnAndRow(4, $i)->getValue(),
                ];
            }
            $this->saveAll($data);
        } catch (Exception $e) {
            throw new ApiException('导入文件错误，操作失败');
        }
    }

    /**
     * 导出数据
     */
    public function export($where = [])
    {
        $query = $this->search($where)->field('id,name,code,sort,status,create_time');
        $data = $this->getAll($query);
        $file_name = '岗位数据.xlsx';
        $header = ['编号', '岗位名称', '岗位标识', '排序', '状态', '创建时间'];
        $title = pathinfo($file_name, PATHINFO_FILENAME);
        $instance = new Excel();
        $file_path = $instance->setTitle($title)
            ->setContent($header, $data)
            ->saveFile($file_name, true);
        return response()->download($file_path, urlencode($file_name));
    }

}
