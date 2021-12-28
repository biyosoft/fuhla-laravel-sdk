<?php

namespace Biyosoft\FuhlaLaravelSdk\Library;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class Fuhla
{
    private $fuhla_user_id = NULL;
    private $fuhla_url = NULL;

    public function __construct($f)
    {
        $this->fuhla_user_id = $f['id'];
        $this->fuhla_url = $f['url'];
    }

    public function get_fuhla_data()
    {
        $ref_id = request()->query('ref_id');
        $reward_id =  request()->query('reward_id');
        $campaign_id =  request()->query('campaign_id');
        if (!empty($ref_id) && !empty($reward_id) && !empty($campaign_id)) {
            Cookie::queue('fuhla_ref_id', $ref_id, 86400 * 15);
            Cookie::queue('fuhla_reward_id', $reward_id, 86400 * 15);
            Cookie::queue('fuhla_campaign_id', $campaign_id, 86400 * 15);
        }
    }
    public function fuhla_trigger(
        $action,
        $unique_id,
        $name = "",
        $email = "",
        $invoice_no = "",
        $receipt_no = "",
        $extra1 = "",
        $extra2 = "",
        $amount = ""
    ) {
        $user_token = $this->fuhla_user_id;
        $URL = $this->fuhla_url ? 'https://www.fuhla.com/' : 'https://www.fuhla.com/sandbox/';
        $ref_id = Cookie::get('fuhla_ref_id');
        $reward_id = Cookie::get('fuhla_reward_id');
        $campaign_id = Cookie::get('fuhla_campaign_id');
        $url = $URL . "revamp-api/api/Fuhla/fuhla_callback?name=$name&email=$email&invoice_no=$invoice_no&receipt_no=$receipt_no&extra1=$extra1&extra2=$extra2&token=QCYLNgRX9eCLPGIUyjnHSOhrqqoya8bOHTCNXRSSi5ktCWCNQ93mSp9bT4MG8dg0b3VURnb&user_token=$user_token&ref_id=$ref_id&reward_id=$reward_id&campaign_token=$campaign_id&action=$action&amount=$amount&unique_id=$unique_id";
        try {
           $response = Http::withOptions([
                'verify' => false,
                'headers' => [
                    'Accept'     => 'application/json',
                ]
            ])->get($url);
            $res =   $response->json();
            return $res;
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
