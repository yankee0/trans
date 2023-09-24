<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FactLiv;
use App\Controllers\Facturations;
use App\Models\Utilisateurs;

class Pay extends BaseController
{
    public function payDelivery(string $invoice_num)
    {
        $invoice = (new Facturations)
            ->FactLivInfos(
                (new FactLiv)
                    ->select('fact_liv.*,clients.nom as nom_client')
                    ->join('clients', 'clients.id = fact_liv.id_client')
                    ->find($invoice_num)
            );


        $postFields = array(
            "item_name"    => 'Facture livraisons Nº' . $invoice['id'],
            "item_price"   => $invoice['total'],
            "currency"     => "XOF",
            "ref_command"  => $invoice['id'] . '_yankee_' . date('YmdHis'),
            "command_name" => "Facture Nº" . $invoice['id'] . ' de ' . $invoice['nom_client'] . ' facturé le ' . $invoice['date_creation'],
            "env"          => 'test',
            "ipn_url"      => base_url(),
            "success_url"  => base_url(session()->has('u') ? session()->r . '/livraisons/details/' . $invoice['id'] : 'espace-client' . '/livraisons/details/' . $invoice['id']),
            "cancel_url"   => base_url(session()->has('u') ? session()->r . '/livraisons/details/' . $invoice['id'] : 'espace-client' . '/livraisons/details/' . $invoice['id']),
        );

        $jsonResponse = $this->postPay('https://paytech.sn/api/payment/request-payment', $postFields, [
            "API_KEY: " . getenv('PAY_KEY'),
            "API_SECRET: " . getenv('PAY_SECRET'),
        ]);

        $response = json_decode($jsonResponse, true);
        dd($response);
        if (!$response['success']) {
            return redirect()->back()->with('n', $response['message']['0']);
        } else {
            return redirect()->to($response['redirect_url']);
        }
    }

    protected function postPay($url, $data = [], $header = [])
    {
        $strPostField = http_build_query($data);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $strPostField);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge($header, [
            'Content-Type: application/x-www-form-urlencoded;charset=utf-8',
            'Content-Length: ' . mb_strlen($strPostField)
        ]));

        return curl_exec($ch);
    }

    private function get($name)
    {
        return !empty($_POST[$name]) ? $_POST[$name] : '';
    }

    public function IPNDelivery()
    {

        $type_event = $this->get('type_event');
        $custom_field = json_decode($this->get('custom_field'), true);
        $ref_command = $this->get('ref_command');
        $item_name = $this->get('item_name');
        $item_price = $this->get('item_price');
        $devise = $this->get('devise');
        $command_name = $this->get('command_name');
        $env = $this->get('env');
        $token = $this->get('token');
        $api_key_sha256 = $this->get('api_key_sha256');
        $api_secret_sha256 = $this->get('api_secret_sha256');
        $my_api_key = getenv('API_KEY');
        $my_api_secret = getenv('API_SECRET');


        if (!(hash('sha256', $my_api_secret) === $api_secret_sha256 && hash('sha256', $my_api_key) === $api_key_sha256)) {
            $inv = explode('_yankee_', $ref_command);
            //Enregistrement du paiement
            // (new FactLiv())->save([
            //     'id' => $inv[0],
            //     'paiement' => 'OUI',
            //     'date_paiement' => date('Y-m-d'),
            // ]);

            //rechercher de la facture
            $invoice = (new Facturations)
                ->FactLivInfos(
                    (new FactLiv)
                        ->select('fact_liv.*,clients.nom as nom_client')
                        ->join('clients', 'clients.id = fact_liv.id_client', 'left')
                        ->find($inv[0])
                );

            //Envoie de l'email de confirmation de paiement
            if (!empty($invoice)) {
                $us = (new Utilisateurs())
                    ->where('profil', 'ADMIN')
                    ->orWhere('profil', 'FACTURATION')
                    ->find();
                return (new Mailer())->sendPaymentMail($us, $invoice);
            }
        } else {
            return 'woops';
        }
    }
}
