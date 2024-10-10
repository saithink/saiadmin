<?php
// +----------------------------------------------------------------------
// | saithink [ saithink快速开发框架 ]
// +----------------------------------------------------------------------
// | Author: sai <1430792918@qq.com>
// +----------------------------------------------------------------------
namespace plugin\saiadmin\app\logic\system;

use plugin\saiadmin\app\model\system\SystemPost;
use plugin\saiadmin\basic\BaseLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\service\OpenSpoutWriter;
use OpenSpout\Reader\XLSX\Reader;

/**
 * 岗位管理逻辑层
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
        $reader = new Reader();
        try {
            $reader->open($path);
            $data = [];
            foreach ($reader->getSheetIterator() as $sheet) {
                $isHeader = true;
                foreach ($sheet->getRowIterator() as $row) {
                    if ($isHeader) {
                        $isHeader = false;
                        continue;
                    }
                    $cells = $row->getCells();
                    $data[] = [
                        'name' => $cells[0]->getValue(),
                        'code' => $cells[1]->getValue(),
                        'sort' => $cells[2]->getValue(),
                        'status' => $cells[3]->getValue(),
                    ];
                }
            }
            $this->saveAll($data);
        } catch (\Exception $e) {
            throw new ApiException('导入文件错误，请上传正确的文件格式xlsx');
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
        $filter = [
            'status' => [
                ['value' => 1, 'label' => '正常'],
                ['value' => 2, 'label' => '禁用']
            ]
        ];
        $writer = new OpenSpoutWriter($file_name);
        $writer->setWidth([15, 15, 20, 15, 15, 25]);
        $writer->setHeader($header);
        $writer->setData($data, null, $filter);
        $file_path = $writer->returnFile();
        return response()->download($file_path, urlencode($file_name));
    }

}
