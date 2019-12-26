<?php

namespace app\data\model;

use think\Model;
use Yansongda\Pay\Pay;
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
            'private_key'     => 'MIIEpQIBAAKCAQEAjkdeTrs5RK3NjiMckbBDOX6N3TQYj3xWxsCcyJ+e9upa7i2JNsLk5V+RL/UDzk+HdCexfhr0NluGAK3eEAWKxPJDg2zgxP46Xwu6mKBvcCM34KSL444PYvhIEBzTGB2XoZazRuq3Qn1f3xcykG8/kUgSS5lbnEmcRbSxgrtIVLI9yg7WCnz0BEyMxrMpUvB2Jj4eLZHubzmH6aopUVTapHPwPTBM4CQdfIDsf6f9LDjOH7oCH6T9g8VS9qlSKs1Q8vm40nrXby8rp9rMoCA6vkggBWoVeg1uu7CZxDFL9dAoMxm2r5klmEWGgxpEUN1f8s/kRAO3DnOCLwltDuNAYQIDAQABAoIBAQCG6Ik14jU1OBAW3Jg0VIwJskRWIRXAyEeIAg8n9KLIwgMioK7g7AAatnl2nb7UG3j23MRiLLCv8iyn7DUJwBeLE6SMs+qVH/K9OOPf4RCJpftP2PaD+KoCUCYUkSBgV371y22GqvzF4RfM87QQXExMN6iRYoMJOIsjVWiT6310QG3q0jihcPA/ZsYECoUFZQdsjHh5X5fKv6fhVUjLRFevs8Ns2ap4rlSwauTTn56MNL+rI42eDQR9W3uR9K30OXZx1dfGzYkX1IAGxqET0F0StU2u38sT3LWFMI5KedFRy4DQNG26p42U0iZ17bANsaf3NCAt80q3kjfR7UuQq7l5AoGBAP1MWlf5rA4o7aQQwS3IQPqcZeQoyCs3GH/+/dACRpYu51TVTKMpWUp4f9Ix81ZodYlrCEFl/kXq+qr56oUZG9S7/NiylbL9IchK+g+hdWLDdeKSo5lpVwC6IeHozl3iNWbNyIixsMP2LKC6MDN///ZFapMMs5LPinBgCiFfnQAfAoGBAI/L3qV7vvy2Bsj2NXDTt61c03whcZtMiBNwcr+FoKH9hd75EVGxe6G5x3TK36jItYz2ytinSJDQO7gF6AFxI3al4tuS6sUpbwgK5Svq0C4XZsZM9ad6oNqTCWCRE6MHAN6Yv9DZ/OEobAR98f3q71WenUF0RM9YdNEpy/vpta9/AoGBAIEAPs6pUFAR1h2FjuzjHPzFZDsT7gXcVHTzh45Fam+YSaZxz0sVhu0fe3GwkM6D+sBWq2irKhmvt6QWDbNle0AX0YkHQqhatLbOQJZvU1pOU55lsj4yYOX05capC1jTGQFXcnbzkCPtHwNob5365YAmEEX95QKzAj2DHAWtLUdfAoGBAI0XTG6y7MKpGB829VivZBoGarvxVLc8cIgiXXTueJ55U1FksUmnC9ezobFHHg1OYlTeEkpiWSE+MFpv8ST5DgLs4ZrwnMq3zOnnRtXAoGOZMo6AFMkv2YSdoSXPM6VSydefqRYTzbxfHR2LNlYenpcz+riujJWmBXj1ueCDgHGhAoGAT99Ing3OwI4Fir38e+i3ZgzBqJ+D4oyBioaH0ifVidAPOxq/CQb62E3/xxWuCmrhWZDWw+CxdAI7VNOSh3w5cCSWihGPj3tX7SdSs6Nkpvj9blx3oVZopbkMEzPsVb9sRsBye26IJcrmBn9EN1SxtSWOQJ9BEKuPFa8n8GRCb/U=',
        ],
    ];

    public function index()
    {
        $config_biz = [
            'out_trade_no' => time(),
            'total_amount' => '1',
            'subject'      => 'test subject',
        ];

        $pay = new Pay($this->config);
        return $pay->driver('alipay')->gateway('scan')->pay($config_biz);
//        return $pay->driver('alipay')->gateway()->pay($config_biz);
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
