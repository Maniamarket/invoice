<?php
/*
 * CREATE TABLE IF NOT EXISTS 'ibn_table' (
'id' int(11) NOT NULL AUTO_INCREMENT,
'itransaction_id' varchar(60) NOT NULL,
'ipayerid' varchar(60) NOT NULL,
'iname' varchar(60) NOT NULL,
'iemail' varchar(60) NOT NULL,
'itransaction_date' datetime NOT NULL,
'ipaymentstatus' varchar(60) NOT NULL,
'ieverything_else' text NOT NULL,
PRIMARY KEY ('id')
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
 */
//Change these with your information
$paypalmode = 'sandbox'; //Sandbox for testing or empty ''
$dbusername     = 'xxxxxx_username'; //db username
$dbpassword     = 'xxxxxx_password'; //db password
$dbhost     = 'localhost'; //db host
$dbname     = 'xxxxxx_db_name'; //db name

if ($_REQUEST)
{
    $req = 'cmd=' . urlencode('_notify-validate');
    foreach ($_REQUEST as $key => $value) {
        $value = urlencode(stripslashes($value));
        $req .= "&$key=$value";
    }

    $fp = fopen("../runtime/logs/ipn.txt", "a"); // Открываем файл в режиме записи
    $mytext = "Это строку необходимо нам записать\r\n"; // Исходная строка
    $test = fwrite($fp, $req); // Запись в файл
    if ($test) echo 'Данные в файл успешно занесены.';
    else echo 'Ошибка при записи в файл.';

    if($paypalmode=='sandbox')
    {
        $paypalmode     =   '.sandbox';
    }
    $req = 'cmd=' . urlencode('_notify-validate');
    foreach ($_POST as $key => $value) {
        $value = urlencode(stripslashes($value));
        $req .= "&$key=$value";
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr');
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www'.$paypalmode.'.sandbox.paypal.com'));
    $res = curl_exec($ch);
    curl_close($ch);

    if (strcmp ($res, "VERIFIED") == 0)
    {
        $test = fwrite($fp, "\r\n VERIFIED"); // Запись в файл
/*        $transaction_id = $_REQUEST['txn_id'];
        $payerid = $_REQUEST['payer_id'];
        $firstname = $_REQUEST['first_name'];
        $lastname = $_REQUEST['last_name'];
        $payeremail = $_REQUEST['payer_email'];
        $paymentdate = $_REQUEST['payment_date'];
        $paymentstatus = $_REQUEST['payment_status'];
        $mdate= date('Y-m-d h:i:s',strtotime($paymentdate));
        $otherstuff = json_encode($_REQUEST);

        $conn = mysql_connect($dbhost,$dbusername,$dbpassword);
        if (!$conn)
        {
            die('Could not connect: ' . mysql_error());
        }

        mysql_select_db($dbname, $conn);

        // insert in our IPN record table
        $query = "INSERT INTO ibn_table
            (itransaction_id,ipayerid,iname,iemail,itransaction_date, ipaymentstatus,ieverything_else)
            VALUES
            ('$transaction_id','$payerid','$firstname $lastname','$payeremail','$mdate', '$paymentstatus','$otherstuff')";

        if(!mysql_query($query))
        {
            //mysql error..!
        }
        mysql_close($conn);*/

    }
    fclose($fp); //Закрытие файла
}
