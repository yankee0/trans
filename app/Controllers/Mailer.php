<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Mailer extends BaseController
{
    public function sendTCDealineMail(array $to, array $data)
    {
        $sent = 0;
        $email = \Config\Services::email();

        foreach ($to as $u) {

            $email->setTo($u['email']);
            $email->setSubject('Alerte deadline TC');
            $email->setMessage(view('emails/TCDeadline', [
                'nom' => $u['nom'],
                'tcs' => $data,
            ]));
            if ($email->send()) {
                $sent++;
            }
        }

        return count($data) . ' alerts sent to ' . $sent . ' out of ' . count($to) . ' users.';
    }

    public function sendPaymentMail(array $to, array $data)
    {

        $sent = 0;
        $email = \Config\Services::email();
        
        foreach ($to as $u) {
            $email->setTo($u['email']);
            $email->setSubject('Notification de paiement');
            $email->setMessage(view('emails/paymentDelivery', [
                'nom' => $u['nom'],
                'data' => $data,
            ]));
            if ($email->send()) {
                $sent++;
            }
        }

        return 'Sent to ' . $sent . ' out of ' . count($to) . ' users.';
    }
}
