
<h1 class="title">Panier</h1>


<!-- on parcourt les commande -->
<?php foreach ($orders as $order): ?>
    <div class="order">
        <h2>Commande n° <?= $order->order_number ?></h2>
        <p>Date de commande : <?= $order->date_order ?></p>
        <p>Statut : <?= $order->status ?></p>

        <!--boucle pour parcourir les lignes de commandes -->
        <?php foreach ($order->order_row as $row): ?>
            <div class="order-row">
                <p>Nom du produit : <?= $row->product_name ?></p>
                <p>Quantité : <?= $row->quantity ?></p>
                <p>Prix unitaire : <?= $row->unit_price ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>


