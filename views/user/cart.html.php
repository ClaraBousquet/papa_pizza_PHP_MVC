<?php use App\Models\Order;
use App\Models\OrderRow;
 ?>
<h1 class="title">Panier</h1>


<!-- on parcourt les commande -->
<?php foreach ($orders as $order): ?>
    <div class="order">
        <h2>Commande n° <?= $order->order_number ?></h2>
        <p>Date de commande : <?= $order->date_order ?></p>
        <p>Statut : <?= $order->status ?></p>

        <?php foreach ($order->order_row as $row): ?>
            <div class="order-row">
                <p>Nom du produit : <?= $order_row->product_name ?></p>
                <p>Quantité : <?= $order_row->quantity ?></p>
                <p>Prix unitaire : <?= $order_row->unit_price ?></p>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>


