<?php

namespace app\data\model;

use think\Model;
use Yansongda\Pay\Pay;

/**
 * @author fyk
 * 支付宝支付
 * Class Alipay
 * @package app\data\model
 */
class Alipay extends Model
{
    protected $config = [
        'alipay' => [
            'app_id' => '2018082861128764',
            'notify_url' => 'http://yansongda.cn/alipay_notify.php',
            'return_url' => 'http://yansongda.cn/return.php',
            //'ali_public_key'        => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIgHnOn7LLILlKETd6BFRJ0GqgS2Y3mn1wMQmyh9zEyWlz5p1zrahRahbXAfCfSqshSNfqOmAQzSHRVjCqjsAw1jyqrXaPdKBmr90DIpIxmIyKXv4GGAkPyJ/6FTFY99uhpiq0qadD/uSzQsefWo0aTvP/65zi3eof7TcZ32oWpwIDAQAB',
            // 'private_key'     => 'MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAJlJ7tgZ4vI2Nnxt7DzznbhVwGN8INQ1s/ZnXYgtRMmvbNKLTHZ1SbRmiAKixn3TDbzkHMvo0jY7ldb7puqUJUKZuKfVwaRcAYgI6NamflqtTDWhSq+hPZ5ZrB36lx7N7AxlMD038WvJC5pHbld06DDxhlUslS3pJCGrB9P6HO0RAgMBAAECgYArrFTQXQ+70pZTfT4BX6dgDY5yybrQuzw6x9huI/elPsXSdr2iQmhtbYjyt022K5uOZa+OqRa7PN7EEY7M5sh2cFRX5P77o2vN61Gwklc11iaJIpPgUOZUmAG8jHnj3lf40+YtMwdPxQfbiZ36UOebQYPc8iuJczUNoVtSPP3IwQJBAMZzCSV7pjTQ4mp2MNT/h3/5ZhaQnqlO4wm0etekKDDTrpvUlSN8MjRjhyJhRvulKd0zUdfrjASEUjZhsZydEAMCQQDFviiKquR0TgYK0eircDwR89XHUBKoblPLYi/GSdPXSL92AzyvDIyNF/GPwHOkc1c+BA/4ocuW/T+u4KfYWBRbAkEAvV/Rfp98gDJFnmqjNt+SIqGQtj/T6KWLKxu7jkTsxYt7uOEoYPCHyE6iCkDiSAnY5Wmv1GjG+Rh8i8C2iUmomQJBAIaeVmtQvAaRt3tWO9e6qKpwHXF7Cbiwo0sqpOuRBy7gz7c/rOhe2rCTRFhg5FloTFRj35ucSkWYUupy9tFJ5VECQDyK++bn0ZpJG/HRNJHvuKOSUM8U6LSvQrTGpyvKlj5wLcOniDAYEcCzkapY/wHAUMshD0eoFY2X3F/3PcuIgW4=',
            // ...
            'ali_public_key'        => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAmKw/C4jHlGLUhpATv2yesGaZOSI9MmOuw5AMcB6odktNj19CSNDAmS5gDCKM4bJyVFOCFb3BNgvADvhoXHMPngGUkqHkJuRotGpvbr3A5UCyWLsF442cFnO7KZC5blKY59DmB/zZ7E9gRT5BhmQebJkkMls2PcVkvEUNTdQiorcNunhxOfsyUuYqsZP0yPoptR8YarmiWZVXwNxJ7Ha3zVzc7kVPqNYyDkCYtSfvVjOeutUh2dGsz1irsYUZpQP4Kra2YyhPlXpNS/KR3TSl1eLXxAQH6g1YWIsQ7/AZRi+Qv1mczwB9miYjQyPkEtjyYQkHVaItxeGW3fvsSvXy9QIDAQAB',
            'private_key'     => 'MIIEowIBAAKCAQEAydhpt8EHQWE6lv1ExOuWo9dOZ09v4i4zW2r0/ftC6lUVwkLwiXberMQl4GZd7CDnYL9Te5nhce1jJ2VerIhFn0pZmFZwjcRUBVGtZC39m4ziGrrTrdwrCVXvLzje2QXGfU2kf80NsWht3QEXBXs4yeAjJdscC+IXo8bopR9Gav7Byxt38thDErUGvX4Mw5e3eag4UGwDffp2q9SyWZaCZdOS3SuE2HM5baPyoyp6bjcMSi3p4pqr5YePc3BXAZ/AVKYblmhOe1oM+TjCinh+NdHhWvDOki9/Hb69dBKCxWMgjvikRw3b2QtOPLFIgU9GMdTRdnaV53wbPreLuJMNjQIDAQABAoIBABpfd3i19O+693/Q+dJNAfLIaAshmvnPlZBFSluBH/4kPeKTAoDDkla6jkRiu7Tlm7XNaegFdCqBnOoB2bvrVkV43noEGVK8q0nCoUgspi1T3Bsn/A6EbO8cVlMyOBPdKFEo+uxj630ZqvksckiaEBJ4gb8pgOGgmfwhOjaQ/o9uHGaS2ay58EXrG3gWC5ldA5N7Kd1EVf7x4H1Z+ymvjsyCcg1n3d0h7dNPHt/kXhlupbsQsuRu0QXOXc7ZP1YshQgMx1tVTFexzLEnnkU/qVnG6SM40/mksfTLGRJnOvKjJlkVOOqQlZfaXIq4aGiPDdm8Cyq7JEuirgSFFx4Np9UCgYEA9jU5McmfpiLXvMSePufbLLjj3MmQqJMvbPUcnuWakD/G714tp6jHgBCcM0qJaTkvX+JBuU7D/q2B56AKWvr/DpkIC2Y5PdgJz90XuLyQjO7ldORE+mrnbZ2uAn2v5W7VXGsN8z9gb6qVFhaAYWRNspT6p3ck+OSarsqGCuwpZk8CgYEA0d+CqLYLDSvLbe5s1VH1BHmXn2hqq0T2pLAoYU/3vvbtBY9B7eXsY/kehdNnsmmnlSfIYCNg17ZhkU6/dTZBpgbIJQ1lKBtINwrXAL/yVBIHkmXPlBobcgzI1ZW44leY41CfzUnDPfL4ULD//S13Dk/+GiEXlZLkAUzoHn71c2MCgYAGkwlB8RZYQ1nranynRV2u5gj/nkpElhmQGUN4Yr0r2OghACzL60/YdZkWLYlZy/Md5lbG8fl91XhAjR95qnYhF6kFVOd2ZUxtxoOZpT9e5Aowgt/sp+oiHTHGU0DdKYZ8/0bSFgEnOjDc9CDdeOYyPJQs4JuWIdSXkkTeCcxZNQKBgEHTE3zs09yGruBE1pe1g96qcFbL/iDHmYAfzBpxZWfctIx42RnPcmwMt3kLzEtV/fy3JI6aqgYeKs3TYBNYOBDlsaKFaAPDQswYt0SB73RUz1EoY4m1AoSr49WxhvJevRIWuHg/uV/Vs/JDAZcbymqPxkfVtzrvflm2EFt4QG23AoGBAJMUb4qxT4cIiQ5beUHD99mogeQzuLdd03jZy/udPRG0Q9fnIu4xR2V3UtedPF4h5jQGzy/HXjteBl+F3PRyBog3/EjlZ6fpxiaYtRTAPHFYpkk/CckHn4uzhx4snM1s69YSdn/ypisdqFO0AH3qTm12GeoAcWX/iO0VnEok6H7U',
        ],
    ];

    /**
     * 扫码支付接口
     * @param $no
     * @param $money
     * @param $title
     * @return mixed
     */
    public function get_alipay($no,$money,$title)
    {


        $config_biz = [
            'out_trade_no' => $no,
            'total_amount' => $money,
            'subject'      => $title,
        ];

        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway('web')->pay($config_biz);
    }

    public function return(Request $request)
    {
        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->verify($request->all());
    }


    public function notify(Request $request)
    {
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->all())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号；
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）；
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）；
            // 4、验证app_id是否为该商户本身。
            // 5、其它业务逻辑情况
            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}
