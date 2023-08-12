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
  <!-- <link href="<?= base_url('assets/css/app.css') ?>" rel="stylesheet"> -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    @import url(https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap);

    * {
      font-family: 'Poppins', sans-serif;
    }

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

    .print table,
    .print td,
    .print tr {
      border: solid 1px #000;
    }



    .invoice-table th,
    .invoice-table td {
      padding: 10px;
      text-align: left;
    }

    .invoice-table td {
      border-bottom: 1px solid #ddd;
    }

    .invoice-total {
      font-weight: bold;
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

<body class="text-dark py-3 print">
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
              <h3 class="fs-3 "><strong>POLY-TRANS SUARL</strong></h3>
              <span>Transit - Transport - Manutention - Consignation - Entreposage - Groupage - Conseils</span>
            </div>
          </div>
          <div>
            <div id="qrcode"></div>
          </div>
        </div>
      </div>
      <hr>
      <h2 class="invoice-title text-center text-capitalize  fs-1"><span class="text-dark">Facture</span> Nº <?= $facture['id'] ?></h2>
      <div class="invoice-details d-flex align-items-center justify-content-between">
        <div>
          <p class="fs-1"><?= $facture['consignataire'] ?></p>
          <p><strong>Compte Nº</strong> <?= $facture['id_client'] ?></p>
          <p><strong>Date de facturation</strong> <?= $facture['date_creation'] ?></p>
        </div>
        <div>
          <p class="fs-1"></p>
          <p><strong>BL Nº</strong> <?= $facture['bl'] ?></p>
          <p><strong>Compagnie</strong> <?= $facture['compagnie'] ?></p>
        </div>
      </div>
      <table class="table ">
        <thead class=" border border-danger bg-danger">
          <tr>
            <th class="text-white">Désignation</th>
            <th class="text-white">Quantité 20'</th>
            <th class="text-white">P.U. 20'</th>
            <th class="text-white">Quantité 40'</th>
            <th class="text-white">P.U. 40'</th>
            <th class="text-white">Total</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($zones as $z) : ?>
            <tr class=" border-dark">
              <td>
                <div>
                  <p class="d-flex g-1 flex-column">
                    <b><?= $z['designation'] ?></b>
                    <i><?= $z['adresse'] ?></i>
                  </p>
                  <?php if (sizeof($z['c_20']) > 0) : ?>
                    <h6><small>Conteneurs 20'</small></h6>
                    <div class="container-fluid">

                      <div class="row">
                        <?php foreach ($z['c_20'] as $c) : ?>
                          <div class="col-6 text-uppercase text-sm text-muted"><small><?= $c['conteneur'] ?></small></div>
                        <?php endforeach ?>
                      </div>
                    </div>
                  <?php endif ?>
                  <?php if (sizeof($z['c_40']) > 0) : ?>
                    <h6><small>Conteneurs 40'</small></h6>
                    <div class="container-fluid">

                      <div class="row">
                        <?php foreach ($z['c_40'] as $c) : ?>
                          <div class="col-6 text-uppercase text-sm text-muted"><small><?= $c['conteneur'] ?></small></div>
                        <?php endforeach ?>
                      </div>
                    </div>
                  <?php endif ?>
                </div>
              </td>
              <td class="num"><?= sizeof($z['c_20']) ?></td>
              <td class="num"><?= (isset($z['c_20'][0]['prix'])) ? $z['c_20'][0]['prix'] : '' ?></td>
              <td class="num"><?= sizeof($z['c_40']) ?></td>
              <td class="num"><?= (isset($z['c_40'][0]['prix'])) ? $z['c_40'][0]['prix'] : '' ?></td>
              <?php
              $tc = 0;
              if (isset($z['c_20'][0]['prix'])) {
                $tc += $z['c_20'][0]['prix'] * sizeof($z['c_20']);
              }
              if (isset($z['c_40'][0]['prix'])) {
                $tc += $z['c_40'][0]['prix'] * sizeof($z['c_40']);
              }
              ?>
              <td class="tp num"><?= $tc ?></td>
            </tr>
          <?php endforeach ?>
          <?php if ($facture['hammar'] > 0) : ?>
            <tr class=" border-dark">
              <td colspan="5">
                <b>Frais de manutension Hammar</b>
              </td>
              <td>
                <span class="num"><?= $facture['hammar'] ?></span>
              </td>
            </tr>
          <?php endif ?>
          <?php if ($facture['ages'] > 0 and $facture['avec_ages'] == 'OUI') : ?>
            <tr class=" border-dark">
              <td colspan="5">
                <b>Ticket A.G.S</b>
              </td>
              <td>
                <span class="num"><?= $facture['ages'] ?></span>
              </td>
            </tr>
          <?php endif ?>
          <?php if ($facture['copie'] > 0) : ?>
            <tr class=" border-dark">
              <td colspan="5">
                <b>Impression</b>
              </td>
              <td>
                <?= $facture['copie'] ?>
              </td>
            </tr>
          <?php endif ?>
        </tbody>
        <tfoot>
          <tr class=" border-dark">
            <td colspan="5" class="invoice-total ">
              Total Hors Taxe <br>
              TVA <br>
              Taxes
            </td>
            <td id="total">
              <span class="num"><?= $total ?></span> <br>
              <?= $facture['avec_tva'] == 'OUI' ? '18%' : '0' ?> <br>
              <span class="num"><?= $taxe ?></span>
            </td>
          </tr>

          <tr class=" border-dark fs-3">
            <td colspan="5" class="invoice-total text-end">
              NET À PAYER
            </td>
            <td id="total">
              <span class="num"><?= $ttc ?></span>
            </td>
          </tr>
        </tfoot>
      </table>
      <p class=""><strong>Arrête la présente facture à la somme de Francs CFA: <span id="lettre" class=" text-uppercase "></span></strong></p>
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
      "<?= base_url('docs/livraisons/details/' . $facture['id']) ?>",
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
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      var elementsAvecNombres = document.querySelectorAll('.num'); // Remplacez "votre-classe" par la classe appropriée

      elementsAvecNombres.forEach(function(element) {
        var texte = element.textContent;
        if (!isNaN(texte)) {
          var nombreAvecPoints = ajouterPoints(texte);
          element.textContent = nombreAvecPoints;
        }
      });
    });

    function ajouterPoints(nombre) {
      return nombre.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
  </script>
</body>


</html>