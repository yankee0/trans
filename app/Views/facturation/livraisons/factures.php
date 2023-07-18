<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Yankee">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>" />
  <title><?= APP_NAME ?> - Facture N<?= $facture['id'] ?></title>
  <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    .invoice-container {
      padding: 0px;
      background-color: white;
      background: white;
      /* box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); */
    }

    #logo {
      display: block;
    }

    .invoice-header {
      text-align: center;
      margin-bottom: 20px;
    }

    #lo {
      height: 100px;
      width: 100px;
      background: url(<?= base_url('assets/img/logo.png') ?>);
      background-size: contain;
      background-position: center center;
      background-repeat: no-repeat;
    }

    .invoice-title {
      font-size: 24px;
      font-weight: bold;
    }

    .invoice-details {
      margin-bottom: 20px;
    }

    .invoice-details p {
      margin: 0;
    }

    .invoice-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    .invoice-table th,
    .invoice-table td {
      padding: 10px;
      text-align: left;
    }

    .invoice-table th {
      background-color: #f0f0f0;
    }

    .invoice-table td {
      border-bottom: 1px solid #ddd;
    }

    .invoice-total {
      font-weight: bold;
    }

    tr,
    td {
      border: solid 1px black;
      border-color: black;
    }

    @media print {
      @page {
        size: A4;
        padding: 0;
      }

      #invoice {
        padding: 0;
        background-color: white;
        background: white;
      }

      .btn {
        display: none;
      }

      #logo {
        display: block;
      }

      .container {
        box-shadow: none;
        margin: 0, 0, 0, 0;
      }

      .align-items-start {
        text-align: left;
      }

      tr>td,
      tr>th {
        min-width: max-content;
        flex-grow: 1;
      }

      body {
        background-color: #fff;
        padding-top: 20px;
      }


    }
  </style>
</head>

<body class="text-dark py-3">
  <div id="invoice" class="container invoice-container bg-white" style="min-width: 794px;">
    <?php if (
      $facture['annulation'] == 'NON'
      and $facture['paiement'] == 'OUI'
    ) : ?>
      <p class="text-center display-4 text-bg-success text-white">PAYÉE</p>
    <?php endif ?>
    <?php if ($facture['annulation'] == 'OUI') : ?>
      <div class="bg-danger">
        <p class="text-center display-2 text-bg-danger">ANNULÉE</p>
        <p class="text-center text-bg-danger"><?= $facture['motif'] ?></p>
      </div>
    <?php endif ?>
    <div class="p-2">
      <div class="invoice-header">
        <div class="d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center gap-2">
            <div id="lo"></div>
            <!-- <img id="logo" src="<?= base_url('assets/img/logo.png') ?>" height="100px" alt=""> -->
            <div class=" d-flex flex-column align-items-start">
              <h3 class="fs-3 text-primary">POLY-TRANS SUARL</h3>
              <span>Transit - Transport - Manutention - Consignation - Entreposage - Groupage - Conseils</span>
            </div>
          </div>
          <div>
            <div id="qrcode"></div>
          </div>
        </div>
      </div>
      <hr>
      <h2 class="invoice-title text-center text-capitalize text-primary fs-1"><span class="text-dark">Facture</span> Nº <?= $facture['id'] ?></h2>
      <div class="invoice-details d-flex align-items-center justify-content-between">
        <div>
          <p class="fs-1"><?= $facture['consignataire'] ?></p>
          <p>Compte Nº <?= $facture['id_client'] ?></p>
          <p>Date de facturation : <?= $facture['created_at'] ?></p>
        </div>
        <div>
          <p class="fs-1"></p>
          <p>BL Nº <?= $facture['bl'] ?></p>
        </div>
      </div>
      <table class="table invoice-table">
        <thead>
          <tr>
            <th>Désignation</th>
            <th>Quantité 20'</th>
            <th>P.U. 20'</th>
            <th>Quantité 40'</th>
            <th>P.U. 40'</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($zones as $z) : ?>
            <tr>
              <td>
                <p class="d-flex g-1 flex-column">
                  <b><?= $z['designation'] ?></b>
                  <i><?= $z['adresse'] ?></i>
                </p>
                <?php if (sizeof($z['c_20']) > 0) : ?>
                  <h6><small>Conteneurs 20'</small></h6>
                  <div class="row gap-2">
                    <?php foreach ($z['c_20'] as $c) : ?>
                      <div class="col-3 text-uppercase text-sm text-muted"><?= $c ?></div>
                    <?php endforeach ?>
                  </div>
                <?php endif ?>
                <?php if (sizeof($z['c_40']) > 0) : ?>
                  <h6><small>Conteneurs 40'</small></h6>
                  <div class="row gap-2">
                    <?php foreach ($z['c_40'] as $c) : ?>
                      <div class="col-3 text-uppercase text-sm text-muted"><?= $c ?></div>
                    <?php endforeach ?>
                  </div>
                <?php endif ?>
              </td>
              <td><?= sizeof($z['c_20']) ?></td>
              <td><?= (isset($z['c_20'][0]['prix'])) ? $z['c_20'][0]['prix'] : '' ?></td>
              <td><?= sizeof($z['c_40']) ?></td>
              <td><?= (isset($z['c_40'][0]['prix'])) ? $z['c_40'][0]['prix'] : '' ?></td>
              <?php
              $tc = 0;
              if (isset($z['c_20'][0]['prix'])) {
                $tc += $z['c_20'][0]['prix'] * sizeof($z['c_20']);
              }
              if (isset($z['c_40'][0]['prix'])) {
                $tc += $z['c_40'][0]['prix'] * sizeof($z['c_40']);
              }
              ?>
              <td class="tp"><?= $tc ?></td>
            </tr>
            <?php if ($facture['hammar'] > 0) : ?>
              <tr>
                <td colspan="5">
                  <b>Frais de manutension Hammar</b>
                </td>
                <td>
                  <?= $facture['hammar'] ?>
                </td>
              </tr>
            <?php endif ?>
            <?php if ($facture['ages'] > 0) : ?>
              <tr>
                <td colspan="5">
                  <b>Ticket A.G.S</b>
                </td>
                <td>
                  <?= $facture['ages'] ?>
                </td>
              </tr>
            <?php endif ?>
            <?php if ($facture['copie'] > 0) : ?>
              <tr>
                <td colspan="5">
                  <b>Impression</b>
                </td>
                <td>
                  <?= $facture['copie'] ?>
                </td>
              </tr>
            <?php endif ?>
          <?php endforeach ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="5" class="invoice-total ">
              Total Hors Taxe <br>
              TVA <br>
              Taxe
            </td>
            <td id="total">
              <?= $total ?> <br>
              18% <br>
              <?= $taxe ?>
            </td>
          </tr>

          <tr class="fs-3">
            <td colspan="5" class="invoice-total text-end">
              NET À PAYER
            </td>
            <td id="total">
              <?= $ttc ?>
            </td>
          </tr>
        </tfoot>
      </table>
      <p class=""><strong>Arrête la présente facture à la somme de Francs CFA: <span id="lettre" class=" text-uppercase text-primary"></span></strong></p>
      <p class="text-sm">
        44, Av Lamine GUEYE Immeuble BHT 2ème étage porte B <br>
        Tél/Fax: 33 842 52 58 <br>
        RC: SN-DKR-2027-B-1563 <br>
        NINEA: 006214332 2Y2 <br>
        Email: contact@poly-trans.sn
      </p>
    </div>
  </div>
  <script>
    // Fonction pour imprimer la page
    function printPage() {
      window.print();
    }
  </script>

  <!-- Bouton pour imprimer la page -->
  <div class="text-center mt-4 mb-3 ">
    <button class="btn btn-primary" onclick="printInvoice()">Imprimer la facture</button>
  </div>
  <script>
    generateQRCode(
      'Facture de <?= $facture['consignataire'] ?> | Montant: <?= $ttc ?>',
      'qrcode'
    )

    function generateQRCode(text, elementId) {
      var qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" + encodeURIComponent(text);
      var qrCodeImg = '<img src="' + qrCodeUrl + '" alt="QR Code">';
      document.getElementById(elementId).innerHTML = qrCodeImg;
    }
  </script>
  <script>
    // Fonction pour imprimer la facture
    function printInvoice() {
      var printContents = document.getElementById('invoice').innerHTML;
      var originalContents = document.body.innerHTML;

      document.body.innerHTML = printContents;
      window.print();
      document.body.innerHTML = originalContents;
    }
  </script>
  <script src="<?= base_url('assets/js/compter.js') ?>"></script>
  <script>
    const nombre = <?= $ttc ?>;
    const resultat = NumberToLetter(nombre);
    document.getElementById('lettre').innerHTML = resultat
  </script>
</body>


</html>