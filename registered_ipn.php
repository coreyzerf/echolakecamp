<?php
    // Response from Paypal
    // read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    foreach ($_POST as $key => $value) {
        $value = urlencode(stripslashes($value));
        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',$value);// IPN fix
        $req .= "&$key=$value";
    }

    // assign posted variables to local variables
    $data['item_name']          = $_POST['item_name'];
    $data['item_number']        = $_POST['item_number'];
    $data['payment_status']     = $_POST['payment_status'];
    $data['payment_amount']     = $_POST['mc_gross'];
    $data['payment_currency']   = $_POST['mc_currency'];
    $data['txn_id']             = $_POST['txn_id'];
    $data['receiver_email']     = $_POST['receiver_email'];
    $data['payer_email']        = $_POST['payer_email'];
    $data['custom']             = $_POST['custom'];
    $data['invoice']            = $_POST['invoice'];
    $data['paypallog']          = $req;

    // post back to PayPal system to validate
    $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
    $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
    $fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30); 

    if (!$fp) {
        // HTTP ERROR
    } else {    


        fputs ($fp, $header . $req);
        while (!feof($fp)) {
            ////mail('atiftariq80@gmail.com','Step 9','Step 9');        
            $res = fgets ($fp, 1024);
            if (true || strcmp($res, "VERIFIED") == 0) {
                ////mail('atiftariq80@gmail.com','PAYMENT VALID','PAYMENT VALID');  

            // Validate payment (Check unique txnid & correct price)
            $valid_txnid = check_txnid($data['txn_id']);
            $valid_price = check_price($data['payment_amount'], $data['item_number']);
            // PAYMENT VALIDATED & VERIFIED!
            if($valid_txnid && $valid_price){               
            //----------------- INSERT RECORDS TO DATABASE-------------------------------------
            if ($data['invoice']=='basic') {
                $price = 39;
            } else { 
                $price = 159;
            }
            $this->user_model->update_user(
                array(
                    'id' => $data['custom'],
                    'user_status' => 1,
                    'payment_date' => date("Y-m-d H:i:s",time()),
                    'next_payment_date' => date('Y-m-d', strtotime('+32 days')),
                    'user_package' => $data['invoice'],
                    'package_price' => $price
                )
            );
            $data2 = array('id' => '',
            'txn_id' => $data['txn_id'],
            'amount' => $data['payment_amount'],
            'mode ' => $data['payment_status'],
            'paypal_log' => $data['paypallog'],
            'user_id' => $data['custom'],
            'created_at' => date('Y-m-d H:i:s',time())

            );
            $this->db->insert('tbl_paypal_log', $data2);
            //----------------- INSERT RECORDS TO DATABASE-------------------------------------
            }else{                  
            // Payment made but data has been changed
            // E-mail admin or alert user
            }                       

        } elseif ($res=='INVALID') {

                // PAYMENT INVALID & INVESTIGATE MANUALY! 
                // E-mail admin or alert user
                ////mail('atiftariq80@gmail.com','PAYMENT INVALID AND INVESTIGATE MANUALY','PAYMENT INVALID AND INVESTIGATE MANUALY');  

        }       
        }       
    fclose ($fp);
    }
?>