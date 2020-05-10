<?php

class Stripe {

    private $api_key;

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    public function api(string $endpoint, array $data) : stdClass
    {
        /*CREE LE CLIENT SUR STRIPE*/
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.stripe.com/v1/$endpoint", /**/
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => $this->api_key, /*Renvoie la clé secrète Stripe*/
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_POSTFIELDS => http_build_query($data)
        ]);

        $response = json_decode(curl_exec($ch));
        curl_close($ch);

        /*Génère une erreur lorsque l'utilisateur recharge la page alors qu'il a déjà payé*/
        if (property_exists($response, 'error'))
        {
            throw new Exception($response->error->message);
        }

        return $response;
    }
}