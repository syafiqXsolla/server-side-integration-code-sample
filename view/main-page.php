<?php

use App\Helpers\Env;

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<form action="">
    <fieldset>
        <!-- https://developers.xsolla.com/api/pay-station/operation/create-token/ -->
        <legend>Create token (PayStation)</legend>
        <label>Merchant id <input name="merchant" type="text" value="<?= Env::get('XSOLLA_MERCHANT_ID') ?>"></label><br><br>
        <label>Project id <input name="project" type="text" value="<?= Env::get('XSOLLA_PROJECT_ID') ?>"></label><br><br>
        <label>Api key <input name="api-key" type="text" value="<?= Env::get('XSOLLA_API_KEY') ?>"></label><br><br>
        <label>JSON body <textarea cols="90" rows="40" name="body">
{
  "sandbox": true,
  "user": {
    "id": {
      "value": "user-id"
    },
    "country": {
      "value": "US",
      "allow_modify": false
    }
  },
  "purchase": {
    "items": [
      {
        "sku": "cup01",
        "quantity": 2
      }
    ]
  },
  "settings": {
    "currency": "USD"
  }
}
            </textarea></label><br><br>
        <button>Get token</button><br><br>
        <div id="result">
        </div>
    </fieldset>
</form>

<script>
    $('form').on('submit', async function (e) {
        e.preventDefault();

        let $form = $('form');
        let merchant = $form.find('input[name="merchant"]').val();
        let project = $form.find('input[name="project"]').val();
        let apiKey = $form.find('input[name="api-key"]').val();
        let body = $form.find('textarea[name="body"]').val();

        let bodyJson = JSON.parse(body);

        let $result = $('#result');
        $result.html('Loading...');
        // if json not valid - error
        if (bodyJson === null) {
            $result.html('Json in body is not valid');
            return;
        }

        const resp = await fetch(
            `https://store.xsolla.com/api/v3/project/${project}/admin/payment/token`,
            {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: 'Basic ' + btoa(`${merchant}:${apiKey}`)
                },
                body: body
            }
        );

        const data = await resp.json();
        console.log(data);

        let stringUrl = '';
        if (data.token) {
            stringUrl = `https://secure.xsolla.com/paystation4/?token=${data.token}`;
            if (bodyJson.sandbox === true) {
                stringUrl = `https://sandbox-secure.xsolla.com/paystation4/?token=${data.token}`;
            }
        }

        $result.html(JSON.stringify(data, null, 2) + `<br><br><a target="_blank" href="${stringUrl}">${stringUrl}</a>`);
    });
</script>