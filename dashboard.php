<?php
// dashboard.php

require_once 'includes/db.php';
require_once 'includes/auth.php';
requireLogin();



$user_id = $_SESSION['user_id'];
$name = $_SESSION['user_name'];

$stmt = $conn->prepare("SELECT * FROM orders WHERE (user_id = ? or email = ?) and status <> 'initiated' ORDER BY created_at DESC");
$stmt->execute([$user_id, $_SESSION['user_email']]);
$orders = [];
$result = $stmt->get_result();
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Your Dashboard</title>
        <?php include 'includes/head-main.html'; ?>
        <style>

            /* .order-table { width: 100%; border-collapse: collapse; margin-top: 1.5rem; background: white; box-shadow: 0 0 10px rgba(0,0,0,0.05); }
            .order-table th, .order-table td { padding: 12px 16px; border-bottom: 1px solid #eee; text-align: left; vertical-align: top; }
            .order-table th { background: #f9f9f9; color: #444; } */

            .order-table td ul { padding-left: 20px; margin: 0; }
            .order-table td li { margin-bottom: 4px; }
            .order-table td .file-date { font-size: 0.9em; color: #888; }
            .logout { margin-top: 1rem; text-align: right; }
            .logout a { color: #555; text-decoration: none; font-size: 0.9rem; }
            @media (max-width: 768px) {

            .order-table td:nth-of-type(1):before { content: "Order ID"; }
            .order-table td:nth-of-type(2):before { content: "Plan"; }
            .order-table td:nth-of-type(3):before { content: "Duration"; }
            .order-table td:nth-of-type(4):before { content: "Total"; }
            .order-table td:nth-of-type(5):before { content: "Status"; }
            .order-table td:nth-of-type(6):before { content: "Created At"; }
            .order-table td:nth-of-type(7):before { content: "Services"; }
            .order-table td:nth-of-type(8):before { content: "Uploads"; }
            }            
        </style>
    </head>
<body>
    <?php include 'includes/header.php'; ?>
<h3 style="text-align: center;">Welcome, <?= htmlspecialchars($name) ?>!</h3>
<div class="dashboard-container">
<h3>Your Orders</h3>

<?php if (count($orders) > 0): ?>
        <table class="order-table">
            <tr>
                <th>Order ID</th>
                <th>Plan</th>
                <th>Duration</th>
                <th>Total</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Services</th>
                <th>Uploads</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                    <tr>
                        <td>#<?= $order['id'] ?></td>
                        <td><?= ucfirst($order['plan']) ?></td>
                        <td><?= $order['duration'] ?></td>
                        <td>$<?= number_format($order['total_price'], 2) ?></td>
                        <td><?= ucfirst($order['status']) ?></td>
                        <td><?= $order['created_at'] ?></td>
                        <td>
                            <ul>
                            <?php
                            $stmt_services = $conn->prepare("SELECT service_name FROM order_items WHERE order_id = ?");
                            $stmt_services->bind_param("i", $order['id']);
                            $stmt_services->execute();
                            $result_services = $stmt_services->get_result();
                            while ($row = $result_services->fetch_assoc()) {
                                echo "<li>" . htmlspecialchars($row['service_name']) . "</li>";
                            }
                            ?>
                            </ul>
                        </td>
                        <td>
                            <?php
                            $stmt_uploads = $conn->prepare("SELECT file_name, file_path FROM uploads WHERE order_id = ?");
                            $stmt_uploads->bind_param("i", $order['id']);
                            $stmt_uploads->execute();
                            $result_uploads = $stmt_uploads->get_result();
                            while ($file = $result_uploads->fetch_assoc()) {
                                echo "<li><a href='" . htmlspecialchars($file['file_path']) . "' target='_blank'>" . htmlspecialchars($file['file_name']) . "</a></li>";
                            }

                            ?>
                            </ul>
                        </td>
                    </tr>
            <?php endforeach; ?>
        </table>
<?php else: ?>
        <p>You have not placed any orders yet.</p>
<?php endif; ?>


</div>



</body>
</html>
