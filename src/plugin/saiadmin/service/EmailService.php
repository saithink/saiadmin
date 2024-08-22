<?php
namespace plugin\saiadmin\service;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use plugin\saiadmin\app\logic\system\SystemConfigLogic;
use plugin\saiadmin\exception\ApiException;
use plugin\saiadmin\utils\Arr;

/**
 * 邮件服务类
 */
class EmailService
{
    /**
     * 读取配置
     * @return array|mixed|null
     */
    public static function getConfig()
    {
        $logic = new SystemConfigLogic();
        $config = $logic->getGroup('email_config');
        if (!$config) {
            throw new ApiException('未设置邮件配置');
        }
        return $config;
    }

    /**
     * Get Mailer
     * @return PHPMailer
     * @throws ApiException
     */
    public static function getMailer(): PHPMailer
    {
        if (!class_exists(PHPMailer::class)) {
            throw new ApiException('请执行 composer require phpmailer/phpmailer 并重启');
        }
        $config = static::getConfig();
        $mailer = new PHPMailer();
        $mailer->SMTPDebug = intval(Arr::getConfigValue($config,'SMTPDebug'));
        $mailer->isSMTP();
        $mailer->Host = Arr::getConfigValue($config,'Host');
        $mailer->SMTPAuth = true;
        $mailer->CharSet = Arr::getConfigValue($config,'CharSet');
        $mailer->Username = Arr::getConfigValue($config,'Username');
        $mailer->Password = Arr::getConfigValue($config,'Password');
        $mailer->SMTPSecure = Arr::getConfigValue($config,'SMTPSecure');
        $mailer->Port = Arr::getConfigValue($config,'Port');
        return $mailer;
    }

    /**
     * 发送邮件
     * @param $from
     * @param $to
     * @param $subject
     * @param $content
     * @return void
     * @throws Exception
     */
    public static function send($from, $to, $subject, $content)
    {
        $mailer = static::getMailer();
        call_user_func_array([$mailer, 'setFrom'], (array)$from);
        call_user_func_array([$mailer, 'addAddress'], (array)$to);
        $mailer->Subject = $subject;
        $mailer->isHTML(true);
        $mailer->Body = $content;
        $mailer->send();
    }

    /**
     * 按照模版发送
     * @param string|array $to
     * @param $subject
     * @param $content
     * @param array $templateData
     * @return void
     * @throws Exception
     */
    public static function sendByTemplate($to, $subject, $content, array $templateData = [])
    {
        if ($templateData) {
            $search = [];
            foreach ($templateData as $key => $value) {
                $search[] = '{' . $key . '}';
            }
            $content = str_replace($search, array_values($templateData), $content);
        }
        $config = static::getConfig();
        static::send([Arr::getConfigValue($config,'From'), Arr::getConfigValue($config,'FromName')], $to, $subject, $content);
    }
    
}